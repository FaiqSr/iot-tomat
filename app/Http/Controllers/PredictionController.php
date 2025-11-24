<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediction;

class PredictionController extends Controller
{
    // List predictions for sensors owned by current user
    public function index(Request $request)
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');

        // collect sensor ids owned by user
        $sensorIds = $user->sensors()->pluck('sensors.id')->toArray();

        $predictions = Prediction::whereIn('sensor_id', $sensorIds)
            ->latest()
            ->paginate(20);

        return view('page.predictions.index', compact('predictions'));
    }

    // Show single prediction details
    public function show($id)
    {
        $user = auth()->user();
        if (! $user) return redirect()->route('login');

        $p = Prediction::find($id);
        if (! $p) return abort(404);

        // ensure user owns the sensor related to this prediction
        $owns = $user->sensors()->where('sensors.id', $p->sensor_id)->exists();
        if (! $owns) return abort(403);

        return view('page.predictions.show', compact('p'));
    }
}
