@extends('layout.adminDashboard')

@section('title', 'Admin - Edit User')
@section('page', 'admin')
@section('pageName', 'Edit User')

@section('content')
    <div
        class="rounded-2xl border bg-white p-4 dark:bg-gray-800 text-black dark:text-white border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold">Edit User #{{ $u->id }}</h3>
        <form action="{{ route('admin.users.update', $u->id) }}" method="POST" class="mt-4 max-w-lg">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" value="{{ $u->first_name }}" placeholder="First name"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                    required />
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" value="{{ $u->last_name }}" placeholder="Last name"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700" />
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $u->email }}" placeholder="Email"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                    required />
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password (leave blank to keep)"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700" />

                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm password"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700" />
                <label for="role">Role</label>
                <input type="text" name="role" value="{{ $u->role ?? '' }}" placeholder="Role (e.g. admin)"
                    class="w-full border px-3 py-2 rounded-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700" />
                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                    <a href="{{ route('admin.users') }}" class="ml-3 text-sm dark:text-white text-gray-600">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
