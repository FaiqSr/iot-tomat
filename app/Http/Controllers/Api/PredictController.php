<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Models\Prediction;

class PredictController extends Controller
{
    /**
     * Proxy features to external ML predict endpoint configured via env `ML_PREDICT_URL`.
     * Expects body: { "features": { "Suhu_Udara": 25.3, "Kelembaban_Udara": 81, ... } }
     * Returns: { "prediction": 71.942 }
     */
    public function predict(Request $request): JsonResponse
    {
        $data = $request->json()->all();

        if (!isset($data['features']) || !is_array($data['features'])) {
            return response()->json(['error' => 'features object is required'], 422);
        }

        $features = $data['features'];

        $mlUrl = env('ML_PREDICT_URL_RF') ?: env('PREDICT_URL');
        if (!$mlUrl) {
            return response()->json(['error' => 'ML_PREDICT_URL not configured in environment'], 500);
        }

        try {
            $resp = Http::timeout(10)->post($mlUrl, ['features' => $features]);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed calling ML service', 'message' => $e->getMessage()], 500);
        }

        if (!$resp->successful()) {
            return response()->json(['error' => 'ML service error', 'status' => $resp->status(), 'body' => $resp->body()], 500);
        }

        $body = $resp->json();
        // Accept several shapes: {prediction:number} or {result:{prediction:...}} etc.
        $prediction = null;
        if (isset($body['prediction'])) $prediction = $body['prediction'];
        elseif (isset($body['result']['prediction'])) $prediction = $body['result']['prediction'];
        elseif (is_numeric($body)) $prediction = $body;

        if ($prediction === null) {
            return response()->json(['error' => 'ML response did not contain prediction', 'body' => $body], 500);
        }

        // Return numeric prediction rounded to 3 decimals and save to DB
        $pred = round(floatval($prediction), 3);

        try {
            $sensorId = $request->input('sensor_id');
            $saved = Prediction::create([
                'sensor_id' => $sensorId,
                'features' => $features,
                'prediction' => $pred,
            ]);
        } catch (\Throwable $e) {
            // still return prediction, but include a warning
            return response()->json(['prediction' => $pred, 'warning' => 'failed to save prediction', 'save_error' => $e->getMessage()]);
        }

        return response()->json(['prediction' => $pred, 'id' => $saved->id]);
    }

    /**
     * Download a report for a saved prediction (PDF if possible, else HTML).
     */
    public function download($id)
    {
        $pred = Prediction::find($id);
        if (!$pred) return response('Not found', 404);

        $html = view('reports.prediction', ['p' => $pred])->render();

        // If Dompdf is available, render as PDF
        if (class_exists('\Dompdf\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            return response($pdf, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="prediction_'.$pred->id.'.pdf"'
            ]);
        }

        // Fallback: return HTML file for download
        return response($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="prediction_'.$pred->id.'.html"'
        ]);
    }
}
