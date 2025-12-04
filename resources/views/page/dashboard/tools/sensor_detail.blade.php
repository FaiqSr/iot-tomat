@extends('layout.dashboard')
@section('title', 'Sensor Detail - Tomat Guard')
@section('page', 'toolsSensor')
@section('breadcrumb', 'Tools')
@section('pageName', 'Sensor Detail')

@section('content')
    <div class="max-w-3xl mx-auto">
        @if (session('error'))
            <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">{{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Sensor Detail</h3>

            <div class="mt-4">
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sensor->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sensor->type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sensor->status }}</dd>
                    </div>
                </dl>
            </div>

            <hr class="my-6" />

            <h4 class="mb-3 text-base font-semibold text-gray-800 dark:text-white">Edit Sensor</h4>
            <form action="{{ route('dashboard.tools.sensor.update', $sensor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $sensor->name) }}" required
                            class="mt-1 w-full rounded border px-3 py-2 text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700">Type</label>
                        <input type="text" name="type" value="{{ old('type', $sensor->type) }}" required
                            class="mt-1 w-full rounded border px-3 py-2 text-sm" />
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 w-full rounded border px-3 py-2 text-sm">
                            <option value="active" {{ old('status', $sensor->status) === 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive" {{ old('status', $sensor->status) === 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('dashboard.tools.sensor') }}" class="rounded border px-3 py-2 text-sm">Back</a>
                        <button type="submit" class="rounded bg-brand-500 px-3 py-2 text-sm text-white">Save</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('dashboard.tools.sensor.destroy', $sensor->id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:underline">Delete Sensor</button>
            </form>
        </div>
    </div>
@endsection
