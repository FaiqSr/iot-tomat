<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\SensorOwner;
use App\Models\SensorGroup;
use App\Models\Prediction;
use App\Models\Tools;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $totalSensors = $user ? $user->sensors()->count() : 0;
        $activeSensors = $user ? $user->sensors()->where('status', 'active')->count() : 0;

        // Also provide sensor and group lists for the dashboard analytics panel
        $sensors = $user ? $user->sensors()->get() : collect();
        $groups = $user ? SensorGroup::with('sensors')->where('user_id', $user->id)->get() : collect();

        // Additional stats for a more informative dashboard
        $groupsCount = $groups->count();
        $toolsCount = $user ? $user->tools()->count() : 0;

        // Recent predictions (latest 6)
        $recentPredictions = $user ? Prediction::whereIn('sensor_id', $sensors->pluck('id'))->latest()->limit(6)->get() : collect();

        return view('page.dashboard.index', compact(
            'totalSensors',
            'activeSensors',
            'sensors',
            'groups',
            'groupsCount',
            'toolsCount',
            'recentPredictions'
        ));
    }

    public function showToolsAlat()
    {
        $user = auth()->user();
        $tools = $user ? $user->tools()->get() : collect();

        return view('page.dashboard.tools.alat', compact('tools'));
    }

    public function showToolsSensor()
    {
        $user = auth()->user();
        $sensors = $user ? $user->sensors()->get() : collect();
        // Load groups with their related sensors for edit UI
        $groups = SensorGroup::with('sensors')->where('user_id', $user ? $user->id : 0)->get();

        return view('page.dashboard.tools.sensor', compact('sensors', 'groups'));
    }

    /**
     * Store a new sensor group for the authenticated user.
     */
    public function storeSensorGroup(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        if (! $user) {
            return back()->with('error', 'Authentication required.');
        }

        SensorGroup::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Group created. You can edit the group to add sensors.');
    }

    /**
     * Update sensor group sensors (attach multiple sensors at once).
     */
    public function updateSensorGroup(Request $request, $id)
    {
        $request->validate([
            'sensors' => ['nullable', 'array'],
            'sensors.*' => ['integer', 'exists:sensors,id'],
        ]);

        $user = auth()->user();
        if (! $user) {
            return back()->with('error', 'Authentication required.');
        }

        $group = SensorGroup::find($id);
        if (! $group || $group->user_id !== $user->id) {
            return back()->with('error', 'Group not found or permission denied.');
        }

        $sensorIds = $request->input('sensors', []);

        // Sync sensors into the group (can add multiple at once)
        $group->sensors()->sync($sensorIds);

        return back()->with('success', 'Group updated.');
    }

    public function showProfile()
    {
        return view('page.dashboard.profile.index');
    }

    public function showAnalytic()
    {
        $user = auth()->user();
        $sensors = $user ? $user->sensors()->get() : collect();
        $groups = $user ? SensorGroup::with('sensors')->where('user_id', $user->id)->get() : collect();

        return view('page.dashboard.analytic.index', compact('sensors', 'groups'));
    }

    /**
     * Store sensor ownership for the authenticated user.
     *
     * Request expects: sensor_id
     */
    public function storeSensorOwner(Request $request)
    {
        $request->validate([
            'sensor_id' => ['required', 'integer'],
        ]);

        $sensorId = $request->input('sensor_id');

        $sensor = Sensor::find($sensorId);
        if (! $sensor) {
            return back()->with('error', 'Sensor not found.');
        }

        $user = auth()->user();
        if (! $user) {
            return back()->with('error', 'Authentication required.');
        }

        // Check if ownership already exists
        $exists = SensorOwner::where('sensor_id', $sensorId)->where('user_id', $user->id)->exists();
        if ($exists) {
            return back()->with('error', 'You already own this sensor.');
        }

        // Also prevent multiple owners for same sensor if that's desired
        // $sensorAssigned = SensorOwner::where('sensor_id', $sensorId)->exists();
        // if ($sensorAssigned) {
        //     return back()->with('error', 'This sensor is already owned by another user.');
        // }

        SensorOwner::create([
            'sensor_id' => $sensorId,
            'user_id' => $user->id,
        ]);

        return back()->with('success', 'Sensor successfully added to your account.');
    }

    /**
     * Show sensor detail and edit form for an owned sensor.
     */
    public function showSensorDetail($id)
    {
        $user = auth()->user();
        $sensor = Sensor::find($id);

        if (! $sensor) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Sensor not found.');
        }

        // Ensure user owns this sensor
        $owns = $user ? $user->sensors()->where('sensors.id', $id)->exists() : false;
        if (! $owns) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Permission denied.');
        }

        return view('page.dashboard.tools.sensor_detail', compact('sensor'));
    }

    /**
     * Update sensor data (owned by user).
     */
    public function updateSensor(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $user = auth()->user();
        $sensor = Sensor::find($id);
        if (! $sensor) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Sensor not found.');
        }

        $owns = $user ? $user->sensors()->where('sensors.id', $id)->exists() : false;
        if (! $owns) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Permission denied.');
        }

        $sensor->update($request->only(['name','type','status']));

        return redirect()->route('dashboard.tools.sensor.show', $sensor->id)->with('success', 'Sensor updated.');
    }

    /**
     * Destroy (delete) sensor — only if owned by current user.
     */
    public function destroySensor($id)
    {
        $user = auth()->user();
        $sensor = Sensor::find($id);
        if (! $sensor) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Sensor not found.');
        }

        $owns = $user ? $user->sensors()->where('sensors.id', $id)->exists() : false;
        if (! $owns) {
            return redirect()->route('dashboard.tools.sensor')->with('error', 'Permission denied.');
        }

        // Remove ownership record for this user
        SensorOwner::where('sensor_id', $id)->where('user_id', $user->id)->delete();

        // Detach sensor from any groups owned by this user
        $userGroupIds = SensorGroup::where('user_id', $user->id)->pluck('id');
        if ($userGroupIds->isNotEmpty()) {
            foreach ($userGroupIds as $groupId) {
                $group = SensorGroup::find($groupId);
                if ($group) {
                    $group->sensors()->detach($id);
                }
            }
        }

        return redirect()->route('dashboard.tools.sensor')->with('success', 'Sensor ownership removed and detached from your groups.');
    }


}
