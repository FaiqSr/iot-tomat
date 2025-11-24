<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Factory;
use Carbon\Carbon;
use App\Models\Sensor;

class SensorDataController extends Controller
{
    /**
     * Store incoming sensor data into Firebase Realtime Database.
     *
     * Expects JSON body:
     * {
     *   "id_sensor": 123,
     *   "data": {
     *     "Suhu_Udara": 25.3,
     *     "Kelembaban_Udara": 81,
     *     "Kelembaban_Tanah": 47,
     *     "pH_Tanah": 6.4,
     *     "Intensitas_Cahaya": 10460
     *   }
     * }
     *
     * Stores under: data/sensor/{sensor_id}/{timestamp}/data
     * where timestamp is milliseconds since epoch.
     *
     * Note: requires a Firebase service account JSON configured via
     * the environment variable `GOOGLE_APPLICATION_CREDENTIALS`.
     */
    public function store(Request $request): JsonResponse
    {

        $payload = $request->json()->all();


        if (!isset($payload['id_sensor'])) {
            return response()->json(['error' => 'id_sensor is required'], 422);
        }

        $sensorId = $payload['id_sensor'];

        if (!isset($payload['data']) || !is_array($payload['data'])) {
            return response()->json(['error' => 'data object is required'], 422);
        }

        $raw = $payload['data'];

        // Map various incoming keys to normalized keys expected in Firebase
        $map = [
            'suhu_udara' => ['suhu_udara', 'suhu udara', 'suhu_udara', 'suhu'],
            'kel_udara' => ['kelembaban_udara', 'kelembaban udara', 'kelembaban_udara', 'kel_udara', 'kel_udara'],
            'soil' => ['kelembaban_tanah', 'kelembaban tanah', 'soil'],
            'ph' => ['ph_tanah', 'ph tanah', 'ph'],
            'ldr' => ['intensitas_cahaya', 'intensitas cahaya', 'ldr', 'intensitas']
        ];

        $normalized = [];

        // Normalize incoming keys: lower + remove spaces
        foreach ($raw as $k => $v) {
            $key = strtolower(str_replace([' ', '-'], ['_', '_'], trim($k)));
            // map known direct keys
            if (in_array($key, ['suhu_udara','kel_udara','kelembaban_udara','kelembaban_tanah','ph_tanah','intensitas_cahaya','soil','ph','ldr','suhu','kel'])) {
                // handle specific known synonyms
                if (in_array($key, ['suhu','suhu_udara'])) $normalized['suhu_udara'] = round(floatval($v), 2);
                elseif (in_array($key, ['kelembaban_udara','kel','kel_udara'])) $normalized['kel_udara'] = intval($v);
                elseif (in_array($key, ['kelembaban_tanah','soil'])) $normalized['soil'] = intval($v);
                elseif (in_array($key, ['ph_tanah','ph'])) $normalized['ph'] = round(floatval($v), 2);
                elseif (in_array($key, ['intensitas_cahaya','ldr','intensitas'])) $normalized['ldr'] = intval($v);
                continue;
            }

            // fallback: try to match with synonyms map
            foreach ($map as $target => $aliases) {
                foreach ($aliases as $alias) {
                    $aliasKey = strtolower(str_replace([' ', '-'], ['_', '_'], $alias));
                    if ($aliasKey === $key) {
                        // cast numbers
                        if (in_array($target, ['suhu_udara','ph'])) {
                            $normalized[$target] = round(floatval($v), 2);
                        } else {
                            $normalized[$target] = intval($v);
                        }
                    }
                }
            }
        }

        if (empty($normalized)) {
            return response()->json(['error' => 'No recognizable sensor fields found in data'], 422);
        }

        // Build firebase payload with expected key names
        $payloadToSave = [];
        if (array_key_exists('suhu_udara', $normalized)) $payloadToSave['suhu_udara'] = $normalized['suhu_udara'];
        if (array_key_exists('kel_udara', $normalized)) $payloadToSave['kel_udara'] = $normalized['kel_udara'];
        if (array_key_exists('soil', $normalized)) $payloadToSave['soil'] = $normalized['soil'];
        if (array_key_exists('ph', $normalized)) $payloadToSave['ph'] = $normalized['ph'];
        if (array_key_exists('ldr', $normalized)) $payloadToSave['ldr'] = $normalized['ldr'];

        // Timestamp key in milliseconds (epoch ms) using Asia/Jakarta (GMT+7)
        $nowJakarta = Carbon::now('Asia/Jakarta');

        // Create epoch milliseconds robustly (seconds * 1000 + millisecond part)
        $timestampMs = (int) ($nowJakarta->getTimestamp() * 1000 + (int) ($nowJakarta->micro / 1000));

        // Store explicit timezone-aware fields so clients can rely on GMT+7 values
        $payloadToSave['timestamp'] = $timestampMs; // epoch ms (absolute)
        $payloadToSave['timestamp_iso_jakarta'] = $nowJakarta->toIso8601String(); // e.g. 2025-11-24T12:34:56+07:00
        $payloadToSave['timestamp_iso'] = $nowJakarta->toIso8601String();
        $payloadToSave['timezone'] = 'Asia/Jakarta';
        $payloadToSave['utc_offset'] = $nowJakarta->format('P'); // +07:00

        // Build path using timestamp as node key
        $dbPath = sprintf('data/sensor/%s/%s/', $sensorId, $timestampMs);

        // Use explicit service account + database URL to avoid autodiscovery issues.
        try {
            $serviceAccountPath = env('GOOGLE_APPLICATION_CREDENTIALS') ?: storage_path('app/firebase/firebase_cred.json');

            if (!file_exists($serviceAccountPath)) {
                return response()->json(['error' => 'Firebase service account file not found', 'path' => $serviceAccountPath], 500);
            }

            $credJson = json_decode(file_get_contents($serviceAccountPath), true);
            $projectId = $credJson['project_id'] ?? null;

            if (!$projectId) {
                return response()->json(['error' => 'project_id not found in service account JSON'], 500);
            }

            $databaseUrl = env('FIREBASE_DATABASE_URL');
            if (!$databaseUrl) {
                // construct default-rtdb URL from project id
                $databaseUrl = sprintf('https://%s-default-rtdb.asia-southeast1.firebasedatabase.app/', $projectId);
            }

            try {
                $factory = (new Factory())
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUrl);

                $database = $factory->createDatabase();
            } catch (\Throwable $e) {
                return response()->json([
                    'error' => 'Failed creating Firebase database client',
                    'message' => $e->getMessage(),
                    'service_account' => $serviceAccountPath,
                    'database_url' => $databaseUrl
                ], 500);
            }

            // set value at the timestamp node
            $reference = $database->getReference($dbPath);
            $reference->set($payloadToSave);

            // Update sensor record: mark active and update last_seen_at
            try {
                $sensor = Sensor::find($sensorId);
                if ($sensor) {
                    $sensor->status = 'active';
                    $sensor->last_seen_at = Carbon::now('Asia/Jakarta');
                    $sensor->save();
                }
            } catch (\Throwable $e) {
                // non-fatal: continue but include warning in response
                return response()->json(['status' => 'ok', 'path' => $dbPath, 'data' => $payloadToSave, 'warning' => 'Failed updating sensor status: '.$e->getMessage()], 201);
            }

            return response()->json(['status' => 'ok', 'path' => $dbPath, 'data' => $payloadToSave], 201);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Failed writing to Firebase', 'message' => $e->getMessage()], 500);
        }
    }
}
