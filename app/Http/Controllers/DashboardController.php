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
        return view('page.dashboard.tools.alat');
    }

    public function showToolsSensor()
    {
        return view('page.dashboard.tools.sensor');
    }

    public function showProfile()
    {
        return view('page.dashboard.profile.index');
    }
}
