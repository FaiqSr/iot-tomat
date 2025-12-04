@extends('layout.adminDashboard')

@section('title', 'Admin Dashboard')
@section('page', 'admin')
@section('pageName', 'Admin')

@section('content')
    <div class="space-y-6">
        <div
            class="rounded-2xl border bg-white p-4 dark:bg-gray-800 text-black dark:text-white border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold">Admin Dashboard</h3>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-sm">
                    <div class="text-sm text-gray-500">Users</div>
                    <div class="text-2xl font-bold">{{ $usersCount }}</div>
                    <a href="{{ route('admin.users') }}" class="text-sm text-blue-600">Manage users</a>
                </div>
                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-sm">
                    <div class="text-sm text-gray-500">Sensors</div>
                    <div class="text-2xl font-bold">{{ $sensorsCount }}</div>
                    <a href="{{ route('admin.sensors') }}" class="text-sm text-blue-600">Manage sensors</a>
                </div>
            </div>
        </div>
    </div>
@endsection
