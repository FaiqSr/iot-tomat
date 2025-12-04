@extends('layout.adminDashboard')

@section('title', 'Admin - Edit Sensor')
@section('page', 'admin')
@section('pageName', 'Edit Sensor')

@section('content')
    <div
        class="rounded-2xl border bg-white p-4 dark:bg-gray-900 text-black dark:text-white border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold">Edit Sensor #{{ $s->id }}</h3>
        <form action="{{ route('admin.sensors.update', $s->id) }}" method="POST" class="mt-4 w-full">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <input type="text" name="name" value="{{ $s->name }}" placeholder="Sensor name"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 " required />
                <input type="text" name="type" value="{{ $s->type }}" placeholder="Type"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 " required />
                {{-- <select name="status" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 ">
                    <option value="active" {{ $s->status === 'active' ? 'selected' : '' }}>active</option>
                    <option value="inactive" {{ $s->status === 'inactive' ? 'selected' : '' }}>inactive</option>
                </select> --}}
                <div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                    <a href="{{ route('admin.sensors') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
