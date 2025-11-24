<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAddress;


class UserController extends Controller
{
    /**
     * Update authenticated user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();


        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture = 'storage/' . $path;
        }

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'] ?? null;
        $user->email = $data['email'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update or create authenticated user's address.
     */
    public function updateAddress(Request $request)
    {
        $user = $request->user();


        $data = $request->validate([
            'country' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        UserAddress::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );


        return back()->with('success', 'Address updated successfully.');
    }
}
