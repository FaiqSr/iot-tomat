@extends('layout.dashboard')
@section('title', 'Analytics - Tomat Guard')

@section('page', 'analytics')
@section('breadcrumb', 'Analytics')
@section('pageName', 'Analytics')

@section('content')
    {{-- SECTION: REALTIME SENSOR DATA --}}
    <div class="space-y-6">
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 md:p-6 transition-colors duration-200">

            <div class="flex sm:flex-row flex-col sm:items-center justify-between gap-4 ">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Sensor Analytics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Monitoring data sensor secara realtime</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    {{-- METRIC SELECTOR --}}
                    <div class="flex flex-col">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Metric</label>
                        <select id="metricSelect"
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm px-3 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="suhu_udara">Suhu Udara</option>
                            <option value="kel_udara">Kelembaban Udara</option>
                            <option value="soil">Kelembaban Tanah</option>
                            <option value="ph">pH Tanah</option>
                            <option value="ldr">Intensitas Cahaya</option>
                        </select>
                    </div>

                    {{-- TIME RANGE SELECTOR (NEW) --}}
                    <div class="flex flex-col">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Range</label>
                        <select id="timeRangeSelect"
                            class="rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm px-3 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="1h" selected>1 Jam Terakhir</option>
                            <option value="7h">7 Jam Terakhir</option>
                            <option value="24h">24 Jam (Hari Ini)</option>
                            <option value="7d">1 Minggu</option>
                            <option value="30d">1 Bulan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- CHART CONTAINER --}}
            <div class="mt-6 p-2 rounded-xl bg-gray-50 dark:bg-gray-800 border border-white dark:border-gray-800">
                <div id="chartAnalytic" class="h-[360px] w-full text-gray-900 dark:text-white"></div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

                {{-- SENSOR LIST --}}
                <div class="flex flex-col">
                    <h4 class="mb-3 font-medium text-gray-700 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Individual Sensors
                    </h4>

                    <div id="sensorsList"
                        class="flex-1 max-h-48 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-sm bg-gray-50 dark:bg-gray-800">
                        @foreach ($sensors as $s)
                            <label
                                class="flex items-center gap-3 py-2 px-2 hover:bg-white dark:hover:bg-gray-700 rounded cursor-pointer transition">
                                <input type="radio" name="sensorSelect"
                                    class="w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                    value="{{ $s->id }}" />
                                <span
                                    class="text-gray-700 dark:text-white font-medium">{{ $s->name ?? 'Sensor #' . $s->id }}</span>
                            </label>
                        @endforeach

                        @if ($sensors->isEmpty())
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">No sensors connected.</div>
                        @endif
                    </div>
                </div>

                {{-- GROUP LIST --}}
                <div class="flex flex-col">
                    <h4 class="mb-3 font-medium text-gray-700 dark:text-white flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span> Sensor Groups
                    </h4>

                    <div id="groupsList"
                        class="flex-1 max-h-48 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-sm bg-gray-50 dark:bg-gray-800">
                        @foreach ($groups as $g)
                            <label
                                class="flex items-center gap-3 py-2 px-2 hover:bg-white dark:hover:bg-gray-700 rounded cursor-pointer transition">
                                <input type="radio" name="groupSelect"
                                    class="w-4 h-4 text-purple-600 bg-white border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                    value="{{ $g->id }}" />
                                <span
                                    class="text-gray-700 dark:text-white font-medium">{{ $g->name ?? 'Group ' . $g->id }}</span>
                            </label>
                        @endforeach

                        @if ($groups->isEmpty())
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">No groups created.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- SECTION: ML PREDICTION --}}
    <div class="space-y-6 mt-8">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 md:p-6 shadow-sm">

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Growth Prediction (AI)</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Estimasi tinggi tanaman berdasarkan parameter
                    lingkungan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- ML FORM --}}
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 h-fit">
                    <h4
                        class="font-medium mb-4 text-gray-700 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Input Parameters</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">Suhu Udara (°C)</label>
                            <input id="feat_suhu" type="number" step="0.1"
                                class="w-full mt-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="25.3" value="25.3" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">Kelembaban Udara (%)</label>
                            <input id="feat_kel" type="number" step="0.1"
                                class="w-full mt-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="80" value="81" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">Kelembaban Tanah (%)</label>
                            <input id="feat_soil" type="number" step="0.1"
                                class="w-full mt-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="45" value="47" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 dark:text-gray-400">pH Tanah</label>
                            <input id="feat_ph" type="number" step="0.1"
                                class="w-full mt-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="6.5" value="6.4" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs text-gray-500 dark:text-gray-400">Intensitas Cahaya (Lux)</label>
                            <input id="feat_ldr" type="number"
                                class="w-full mt-1 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                                placeholder="10000" value="10460" />
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button id="btnPredict"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2.5 text-sm transition shadow-lg shadow-blue-500/30">
                            Calculate Prediction
                        </button>

                        <button id="btnUseSensor"
                            class="px-4 py-2.5 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition"
                            title="Fill inputs with latest data from selected sensor">
                            Use Sensor Data
                        </button>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Predicted Height</div>
                        <div class="text-3xl font-bold text-gray-800 dark:text-white">
                            <span id="predictValue">-</span> <span class="text-lg font-normal text-gray-500">cm</span>
                        </div>
                    </div>
                </div>

                {{-- PREDICTION HISTORY --}}
                <div class="flex flex-col h-full">
                    <h4 class="font-medium mb-4 text-gray-700 dark:text-white">Recent Calculations</h4>

                    <div id="predictionCards" class="flex-1 overflow-y-auto max-h-[400px] pr-2 space-y-3">
                        {{-- Cards injected by JS here --}}
                        <div
                            class="text-center py-10 text-gray-400 dark:text-gray-600 text-sm italic border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                            Prediction history will appear here
                        </div>
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
