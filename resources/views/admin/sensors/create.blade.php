@extends('layout.adminDashboard')

@section('title', 'Admin - New Sensor')
@section('page', 'admin')
@section('pageName', 'Create Sensor')

@section('content')
    <div class="rounded-2xl border bg-white p-4 dark:bg-gray-900">
        <h3 class="text-lg font-semibold">Create Sensor</h3>
        <form action="{{ route('admin.sensors.store') }}" method="POST" class="mt-4 max-w-lg">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="name" placeholder="Sensor name" class="w-full" required />
                <input type="text" name="type" placeholder="Type" class="w-full" required />
                <select name="status" class="w-full">
                    <option value="active">active</option>
                    <option value="inactive">inactive</option>
                </select>
                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
                    <a href="{{ route('admin.sensors') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
