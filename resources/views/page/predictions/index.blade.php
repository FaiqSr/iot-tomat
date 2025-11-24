@extends('layout.dashboard')

@section('title', 'Predictions')
@section('page', 'predictions')
@section('breadcrumb', 'Predictions')
@section('pageName', 'Predictions')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Predictions</h3>
                    <p class="text-sm text-gray-500">Saved model predictions for your sensors.</p>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="py-2">#</th>
                            <th class="py-2">Sensor</th>
                            <th class="py-2">Prediction (cm)</th>
                            <th class="py-2">Created</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($predictions as $p)
                            <tr class="border-t">
                                <td class="py-2">{{ $p->id }}</td>
                                <td class="py-2">{{ optional($p->sensor)->name ?? '#' . $p->sensor_id }}</td>
                                <td class="py-2 font-medium">{{ number_format($p->prediction, 2) }}</td>
                                <td class="py-2 text-xs text-gray-500">{{ $p->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-2">
                                    <a href="{{ route('predictions.show', $p->id) }}"
                                        class="text-sm text-blue-600 mr-3">View</a>
                                    <a href="{{ route('predictions.download', $p->id) }}"
                                        class="text-sm text-gray-600">Download</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">No predictions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $predictions->links() }}
            </div>
        </div>
    </div>
@endsection
