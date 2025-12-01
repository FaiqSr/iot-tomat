@extends('layout.dashboard')
@section('title', 'Admin Dashboard - Tomat Guard')
@section('page', 'dashboard')
@section('breadcrumb', 'Dashboard')
@section('pageName', 'Dashboard')

@section('content')

    <div class="space-y-6">

        {{-- Top Metrics --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-500">Total Sensors</div>
                        <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalSensors ?? 0 }}</div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v4a1 1 0 001 1h3m10 0h3a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">Overview of all registered sensors</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-500">Active Sensors</div>
                        <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $activeSensors ?? 0 }}</div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-green-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">Sensors with status = <code>active</code></div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-500">Groups</div>
                        <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $groupsCount ?? ($groups->count() ?? 0) }}</div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h8m-8 4h6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">Sensor groups you created</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-500">Recent Predictions</div>
                        <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $recentPredictions->count() ?? 0 }}</div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-indigo-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 17a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">Latest model estimations</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs text-gray-500">Connected Now</div>
                        <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">—</div>
                    </div>
                    <div class="h-12 w-12 rounded-lg bg-red-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">Realtime connection (Firebase)</div>
            </div>
        </div>

        {{-- Main area: Chart + Recent Predictions --}}
        <div class="grid grid-cols-1 lg:grid-cols-3">

            {{-- Right column: Sensors & Groups --}}
            <div class="space-y-6">

                <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-gray-800 dark:text-white">Sensors</h4>
                        <a href="{{ route('dashboard.tools.sensor') }}" class="text-sm text-blue-600">Manage</a>
                    </div>

                    <div class="mt-3 space-y-2 max-h-64 overflow-y-auto">
                        @forelse($sensors as $s)
                            <div
                                class="flex items-center justify-between p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-800">
                                <div>
                                    <div class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $s->name ?? 'Sensor #' . $s->id }}</div>
                                    <div class="text-xs text-gray-400">Type: {{ $s->type ?? '-' }}</div>
                                </div>
                                <div class="text-sm">
                                    @if ($s->status === 'active')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs bg-green-50 text-green-600">Active</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-50 text-gray-600">{{ ucfirst($s->status ?? 'unknown') }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-4">No sensors available.</div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-gray-800 dark:text-white">Groups</h4>
                        <a href="{{ route('dashboard.tools.sensor') }}" class="text-sm text-blue-600">Edit</a>
                    </div>

                    <div class="mt-3 space-y-2 max-h-48 overflow-y-auto">
                        @forelse($groups as $g)
                            <div
                                class="p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-800 flex items-center justify-between">
                                <div>
                                    <div class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $g->name ?? 'Group ' . $g->id }}</div>
                                    <div class="text-xs text-gray-400">{{ $g->sensors->count() }} sensors</div>
                                </div>
                                <div class="text-xs text-gray-400">ID: {{ $g->id }}</div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-3">No groups created.</div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <h4 class="font-semibold text-gray-800 dark:text-white">Quick Actions</h4>
                    <div class="mt-3 grid grid-cols-1 gap-2">
                        <a href="{{ route('dashboard.tools.sensor') }}"
                            class="block px-3 py-2 rounded bg-blue-600 text-white text-center">Add / Manage Sensors</a>
                        <a href="/predictions" class="block px-3 py-2 rounded border text-center">View Predictions</a>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
@section('scripts')
    <script>
        window.INITIAL_SENSORS = @json($sensors->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));
        window.INITIAL_GROUPS = @json($groups->map(fn($g) => ['id' => $g->id, 'name' => $g->name, 'sensors' => $g->sensors->pluck('id')]));
    </script>
@endsection
