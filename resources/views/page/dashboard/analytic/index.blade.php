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
    {{-- SECTION: YOLO VIEWER (Live Object Detection) --}}
    <div class="space-y-6 mt-8" x-data="yoloViewer()">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 md:p-6 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Live Monitoring (YOLOv8)</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Deteksi visual tanaman realtime dari Flask Server
                    </p>
                </div>

                {{-- Connection Status Indicator --}}
                <div class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium border"
                    :class="{
                        'bg-green-100 text-green-700 border-green-200': status === 'connected',
                        'bg-red-100 text-red-700 border-red-200': status === 'disconnected' || status === 'error',
                        'bg-yellow-100 text-yellow-700 border-yellow-200': status === 'connecting'
                    }">
                    <span class="w-2 h-2 rounded-full"
                        :class="{
                            'bg-green-600 animate-pulse': status === 'connected',
                            'bg-red-600': status === 'disconnected' || status === 'error',
                            'bg-yellow-600 animate-bounce': status === 'connecting'
                        }"></span>
                    <span x-text="status.charAt(0).toUpperCase() + status.slice(1)"></span>
                </div>
            </div>

            {{-- Device Selection --}}
            <div class="mb-4">
                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1 block">Pilih Kamera / Device
                    ID</label>
                <div class="flex gap-2">
                    <input type="text" x-model="deviceId"
                        class="flex-1 border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Masukkan Device ID (contoh: KAMERA_DEPAN_01)">
                    <button @click="connectToDevice()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        Connect
                    </button>
                </div>
            </div>

            {{-- Video Container --}}
            <div
                class="relative w-full rounded-xl overflow-hidden bg-black aspect-video flex items-center justify-center border border-gray-800 shadow-lg">
                {{-- Placeholder / Loading State --}}
                <div x-show="!annotatedSrc" class="flex flex-col items-center justify-center text-gray-500">
                    <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p class="text-sm">Menunggu stream video...</p>
                </div>

                {{-- Actual Stream Image --}}
                <img x-show="annotatedSrc" :src="annotatedSrc" class="w-full h-full object-contain absolute inset-0"
                    alt="YOLO Stream">
            </div>
        </div>
    </div>

    {{-- SECTION: ML PREDICTION --}}
    <div class="space-y-6 mt-8">
        <div class="rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-5 md:p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Growth Prediction (AI)</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Estimasi tinggi tanaman (Random Forest) berdasarkan
                    parameter lingkungan.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- ML FORM --}}
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 h-fit">
                    <h4
                        class="font-medium mb-4 text-gray-700 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Input Parameters</h4>

                    <form id="predictionForm" onsubmit="return false;">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Suhu Udara (°C)</label>
                                <input id="feat_suhu" name="Air Temperature" type="number" step="0.1"
                                    class="ml-input" placeholder="25.3" value="25.3" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Kelembaban Udara (%)</label>
                                <input id="feat_kel" name="Humidity" type="number" step="0.1" class="ml-input"
                                    placeholder="80" value="81" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Kelembaban Tanah (%)</label>
                                <input id="feat_soil" name="Soil Moisture" type="number" step="0.1"
                                    class="ml-input" placeholder="45" value="47" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">pH Tanah</label>
                                <input id="feat_ph" name="Soil pH" type="number" step="0.1" class="ml-input"
                                    placeholder="6.5" value="6.4" />
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-xs text-gray-500 dark:text-gray-400">Intensitas Cahaya (Lux)</label>
                                <input id="feat_ldr" name="Light Intensity" type="number" class="ml-input"
                                    placeholder="10000" value="10460" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <button type="button" onclick="predictGrowth()" id="btnPredict"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2.5 text-sm transition shadow-lg shadow-blue-500/30 flex justify-center items-center gap-2">
                                <span>Hitung Prediksi</span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Prediksi Tinggi Tanaman</div>
                        <div class="text-3xl font-bold text-gray-800 dark:text-white">
                            <span id="predictValue">-</span> <span class="text-lg font-normal text-gray-500">cm</span>
                        </div>
                        <div id="predictError" class="text-xs text-red-500 mt-2 hidden"></div>
                    </div>
                </div>

                {{-- PREDICTION HISTORY --}}
                <div class="flex flex-col h-full">
                    <h4 class="font-medium mb-4 text-gray-700 dark:text-white">Riwayat Kalkulasi</h4>
                    <div id="predictionCards" class="flex-1 overflow-y-auto max-h-[400px] pr-2 space-y-3">
                        <div
                            class="text-center py-10 text-gray-400 dark:text-gray-600 text-sm italic border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                            Belum ada riwayat prediksi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        /* Custom class untuk input ML agar lebih rapi */
        .ml-input {
            width: 100%;
            margin-top: 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            color: #111827;
            background-color: #ffffff;
            transition: all 0.15s ease-in-out;
            outline: none;
        }

        .dark .ml-input {
            border-color: #4b5563;
            background-color: #374151;
            color: #ffffff;
        }

        .dark .ml-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
        }

        .ml-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }
    </style>
@endsection

@section('scripts')
    {{-- Import Socket.IO Client --}}
    <script type="module">
        @php
            $mlPredictUrlRf = env('ML_PREDICT_URL_RF', 'http://127.0.0.1:5000/predict_rf');
        @endphp

        import {
            io
        } from "https://cdn.socket.io/4.7.2/socket.io.esm.min.js";

        // --- ALPINE JS COMPONENT FOR YOLO VIEWER ---
        document.addEventListener('alpine:init', () => {
            Alpine.data('yoloViewer', () => ({
                serverUrl: '{{ $mlPredictUrlRf }}', // Ganti dengan URL Flask Server Anda
                deviceId: '', // will be set from selected sensor radio
                status: 'disconnected',
                annotatedSrc: null,
                socket: null,

                init() {
                    console.log('YOLO Viewer initialized');
                    // Auto connect on load jika deviceId ada
                    // Bind sensor radio inputs so deviceId follows selection
                    const radios = document.querySelectorAll('input[name="sensorSelect"]');
                    radios.forEach(r => {
                        r.addEventListener('change', (e) => {
                            // set deviceId to the selected sensor id
                            this.deviceId = e.target.value;
                            // update any input field bound to deviceId if present
                            // auto-connect to the selected device
                            this.connectToDevice();
                        });
                    });

                    // If there's already a checked radio, use it
                    const checked = document.querySelector('input[name="sensorSelect"]:checked');
                    if (checked) {
                        this.deviceId = checked.value;
                        this.connectToDevice();
                    }
                },

                connectToDevice() {
                    if (!this.deviceId) return alert('Masukkan Device ID');

                    if (this.socket) {
                        this.socket.disconnect();
                    }

                    this.status = 'connecting';

                    // Inisialisasi Socket IO
                    this.socket = io(this.serverUrl, {
                        transports: ["websocket", "polling"]
                    });

                    // Event Listeners
                    this.socket.on("connect", () => {
                        this.status = 'connected';
                        console.log("Socket Connected to Flask. Joining room:", this.deviceId);

                        // Emit join room event ke Flask Server
                        this.socket.emit("join_monitor", {
                            device_id: this.deviceId
                        });
                    });

                    this.socket.on("disconnect", () => {
                        this.status = 'disconnected';
                    });

                    this.socket.on("connect_error", (err) => {
                        console.error("Socket error:", err);
                        this.status = 'error';
                    });

                    // Menerima Stream Gambar (Event: 'stream_frame')
                    this.socket.on("stream_frame", (data) => {
                        if (data && data.image) {
                            this.annotatedSrc = "data:image/jpeg;base64," + data.image;
                        }
                    });

                    // Handle Device Offline
                    this.socket.on("device_status", (data) => {
                        if (data.status === "offline") {
                            this.status = 'disconnected'; // Atau status khusus 'offline'
                            this.annotatedSrc = null;
                            alert(`Device ${this.deviceId} terputus.`);
                        }
                    });
                }
            }));
        });
    </script>

    <script>
        // --- LOGIC PREDIKSI PERTUMBUHAN (ML) ---
        async function predictGrowth() {
            const btn = document.getElementById('btnPredict');
            const resultSpan = document.getElementById('predictValue');
            const errorDiv = document.getElementById('predictError');
            const historyContainer = document.getElementById('predictionCards');

            // Ambil values
            const suhu = parseFloat(document.getElementById('feat_suhu').value);
            const kel = parseFloat(document.getElementById('feat_kel').value);
            const soil = parseFloat(document.getElementById('feat_soil').value);
            const ph = parseFloat(document.getElementById('feat_ph').value);
            const ldr = parseFloat(document.getElementById('feat_ldr').value);

            // Validasi sederhana
            if (isNaN(suhu) || isNaN(kel) || isNaN(soil) || isNaN(ph) || isNaN(ldr)) {
                alert("Mohon isi semua parameter dengan angka valid.");
                return;
            }

            // UI Loading state
            btn.disabled = true;
            btn.innerHTML =
                `<svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...`;
            resultSpan.innerText = "-";
            errorDiv.classList.add('hidden');

            // Payload sesuai format Flask Anda
            const payload = {
                "features": {
                    "Air Temperature": suhu,
                    "Humidity": kel,
                    "Soil Moisture": soil,
                    "Soil pH": ph,
                    "Light Intensity": ldr
                }
            };

            try {

                const response = await fetch('/predict_rf', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok) {
                    const prediction = data.prediction.toFixed(2);
                    resultSpan.innerText = prediction;

                    // Tambahkan ke history card
                    addHistoryCard(historyContainer, {
                        suhu,
                        kel,
                        soil,
                        ph,
                        ldr
                    }, prediction);
                } else {
                    throw new Error(data.error || 'Server Error');
                }

            } catch (error) {
                console.error("Prediction Error:", error);
                errorDiv.innerText = "Gagal memproses: " + error.message;
                errorDiv.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.innerText = "Hitung Prediksi";
            }
        }

        function addHistoryCard(container, inputs, result) {
            // Hapus placeholder jika ada
            if (container.children[0] && container.children[0].classList.contains('italic')) {
                container.innerHTML = '';
            }

            const card = document.createElement('div');
            card.className =
                "bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm animate-fade-in-down";

            const time = new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            card.innerHTML = `
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs text-gray-400 font-mono">${time}</span>
                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">Hasil: ${result} cm</span>
                </div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600 dark:text-gray-300">
                    <div>🌡️ Suhu: ${inputs.suhu}°C</div>
                    <div>💧 Udara: ${inputs.kel}%</div>
                    <div>🌱 Tanah: ${inputs.soil}%</div>
                    <div>⚗️ pH: ${inputs.ph}</div>
                    <div class="col-span-2">☀️ Cahaya: ${inputs.ldr} Lux</div>
                </div>
            `;

            container.prepend(card);
        }
    </script>
@endsection
