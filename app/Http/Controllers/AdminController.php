<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sensor;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index()
    {
        $usersCount = User::count();
        $sensorsCount = Sensor::count();
        return view('admin.index', compact('usersCount','sensorsCount'));
    }

    // --- Users CRUD ---
    public function usersIndex()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|string',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_picture' => null,
        ]);

        if (isset($data['role'])) {
            $user->role = $data['role'];
            $user->save();
        }

        return redirect()->route('admin.users')->with('success','User created');
    }

    public function usersEdit($id)
    {
        $u = User::findOrFail($id);
        return view('admin.users.edit', ['u' => $u]);
    }

    public function usersUpdate(Request $request, $id)
    {
        $u = User::findOrFail($id);
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email,' . $u->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'nullable|string',
        ]);

        $u->first_name = $data['first_name'];
        $u->last_name = $data['last_name'] ?? null;
        $u->email = $data['email'];
        if (! empty($data['password'])) {
            $u->password = Hash::make($data['password']);
        }
        if (isset($data['role'])) $u->role = $data['role'];
        $u->save();

        return redirect()->route('admin.users')->with('success','User updated');
    }

    public function usersDestroy($id)
    {
        $u = User::findOrFail($id);
        $u->delete();
        return redirect()->route('admin.users')->with('success','User deleted');
    }

    // --- Sensors CRUD ---
    public function sensorsIndex()
    {
        $sensors = Sensor::paginate(20);
        return view('admin.sensors.index', compact('sensors'));
    }

    public function sensorsCreate()
    {
        return view('admin.sensors.create');
    }

    public function sensorsStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Sensor::create($data);
        return redirect()->route('admin.sensors')->with('success','Sensor created');
    }

    public function sensorsEdit($id)
    {
        $s = Sensor::findOrFail($id);
        return view('admin.sensors.edit', ['s' => $s]);
    }

    public function sensorsUpdate(Request $request, $id)
    {
        $s = Sensor::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
        ]);
        $s->update($data);
        return redirect()->route('admin.sensors')->with('success','Sensor updated');
    }

    public function sensorsDestroy($id)
    {
        $s = Sensor::findOrFail($id);
        $s->delete();
        return redirect()->route('admin.sensors')->with('success','Sensor deleted');
    }
}
