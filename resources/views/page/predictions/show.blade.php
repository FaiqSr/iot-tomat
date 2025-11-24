@extends('layout.dashboard')

@section('title', 'Prediction #' . $p->id)
@section('page', 'predictions')
@section('breadcrumb', 'Predictions')
@section('pageName', 'Prediction Detail')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col sm:flex-row  gap-5 sm:items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Prediction #{{ $p->id }}</h3>
                    <p class="text-sm text-gray-500">Details and report for this prediction.</p>
                </div>
                <div class="flex flex-col sm:flex-row  sm:items-center gap-2">
                    <div>

                        <a href="{{ route('predictions.download', $p->id) }}"
                            class="px-3 py-2 rounded bg-blue-600 text-white text-sm">Download Report</a>
                    </div>
                    <a href="{{ route('predictions.index') }}" class="text-sm text-gray-400">Back</a>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-xs text-gray-500">Sensor</div>
                    <div class="font-medium">{{ optional($p->sensor)->name ?? '#' . $p->sensor_id }}</div>

                    <div class="mt-3 text-xs text-gray-500">Predicted Height</div>
                    <div class="text-3xl font-bold">{{ number_format($p->prediction, 3) }} cm</div>

                    <div class="mt-3 text-xs text-gray-500">Created</div>
                    <div class="text-sm text-gray-400">{{ $p->created_at->format('Y-m-d H:i:s') }}</div>
                </div>

                <div>
                    <div class="text-xs text-gray-500">Features</div>
                    <div class="mt-2 bg-gray-50 dark:bg-gray-800 rounded p-2">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-gray-500 text-left">
                                <tr>
                                    <th class="py-2">Feature</th>
                                    <th class="py-2">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($p->features ?? [] as $k => $v)
                                    <tr class="border-t">
                                        <td class="py-2 font-medium text-gray-700">{{ $k }}</td>
                                        <td class="py-2 text-gray-600">{{ is_array($v) ? json_encode($v) : $v }}</td>
                                    </tr>
                                @endforeach
                                @if (empty($p->features))
                                    <tr>
                                        <td colspan="2" class="py-4 text-center text-gray-500">No features available.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
