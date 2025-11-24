@extends('layout.adminDashboard')

@section('title', 'Admin - New User')
@section('page', 'admin')
@section('pageName', 'Create User')

@section('content')
    <div class="rounded-2xl border bg-white p-4 dark:bg-gray-900">
        <h3 class="text-lg font-semibold">Create User</h3>
        <form action="{{ route('admin.users.store') }}" method="POST" class="mt-4 max-w-lg">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="first_name" placeholder="First name" class="w-full" required />
                <input type="text" name="last_name" placeholder="Last name" class="w-full" />
                <input type="email" name="email" placeholder="Email" class="w-full" required />
                <input type="password" name="password" placeholder="Password" class="w-full" required />
                <input type="password" name="password_confirmation" placeholder="Confirm password" class="w-full"
                    required />
                <input type="text" name="role" placeholder="Role (e.g. admin)" class="w-full" />
                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
                    <a href="{{ route('admin.users') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
