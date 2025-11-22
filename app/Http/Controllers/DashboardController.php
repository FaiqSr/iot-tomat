<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showAlatDashboard()
    {
        return view('page.dashboard.alatDashboard');
    }

    public function showSensorDashboard()
    {
        return view('page.dashboard.sensorDashboard');
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
        $groups = \App\Models\SensorGroup::all();

        return view('page.dashboard.tools.sensor', compact('sensors', 'groups'));
    }

    public function showProfile()
    {
        return view('page.dashboard.profile.index');
    }
}
