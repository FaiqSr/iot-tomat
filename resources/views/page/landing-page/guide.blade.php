@extends('layout.lp')

@section('title', 'Guide - Tomat Guard')

@section('content')
    <section class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-16">
        <div class="container mx-auto px-5">
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-8">
                <h1 class="text-3xl font-bold mb-2">Panduan Interaktif Tomat Guard</h1>
                <p class="text-gray-600 mb-6">Ikuti langkah demi langkah yang mudah dan interaktif untuk
                    memasang, mengonfigurasi, dan memantau perangkat Tomat Guard.</p>

                <!-- Stepper -->
                <div id="guide" class="mb-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-3 w-full">
                                    <div class="step-indicators flex gap-3 w-full justify-between">
                                        <button data-step="0"
                                            class="step-btn w-10 h-10 rounded-full bg-blue-600 text-white">1</button>
                                        <button data-step="1"
                                            class="step-btn w-10 h-10 rounded-full bg-gray-200 text-gray-700">2</button>
                                        <button data-step="2"
                                            class="step-btn w-10 h-10 rounded-full bg-gray-200 text-gray-700">3</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2 mb-6 overflow-hidden">
                        <div id="progress" class="h-2 bg-blue-600 w-0 transition-all"></div>
                    </div>

                    <div class="step-panels">
                        <div data-panel="0" class="step-panel">
                            <h3 class="text-xl font-semibold mb-2">1. Persiapan Perangkat</h3>
                            <p class="text-gray-600 mb-4">Pastikan baterai terisi, antenna terpasang, dan perangkat
                                terletak di area yang terkena sinyal.</p>
                            <ul class="list-disc pl-5 text-gray-700 mb-4">
                                <li>Periksa kabel dan koneksi.</li>
                                <li>Siapkan smartphone untuk konfigurasi Wi-Fi.</li>
                                <li>Catat ID perangkat (di stiker belakang).</li>
                            </ul>
                            <div class="flex gap-3">
                                <button id="nextBtn"
                                    class="ml-auto px-5 py-2 bg-blue-600 text-white rounded-lg">Lanjut</button>
                            </div>
                        </div>

                        <div data-panel="1" class="step-panel hidden">
                            <h3 class="text-xl font-semibold mb-2">2. Konfigurasi & Registrasi</h3>
                            <p class="text-gray-600 mb-4">Hubungkan perangkat ke Wi-Fi dan registrasikan pada
                                dashboard Tomat Guard.</p>
                            <ol class="list-decimal pl-5 text-gray-700 mb-4">
                                <li>Buka aplikasi/portal dan pilih "Tambah Perangkat".</li>
                                <li>Masukkan ID perangkat dan kredensial Wi-Fi.</li>
                                <li>Tunggu sampai status berubah menjadi "Aktif".</li>
                            </ol>
                            <div class="flex gap-3">
                                <button id="prevBtn"
                                    class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg">Kembali</button>
                                <button id="nextBtn2"
                                    class="ml-auto px-5 py-2 bg-blue-600 text-white rounded-lg">Lanjut</button>
                            </div>
                        </div>

                        <div data-panel="2" class="step-panel hidden">
                            <h3 class="text-xl font-semibold mb-2">3. Monitor & Tindakan</h3>
                            <p class="text-gray-600 mb-4">Gunakan dashboard untuk memantau nilai sensor. Aktifkan
                                notifikasi untuk kondisi kritis.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="font-medium mb-1">Contoh Alert</div>
                                    <div class="text-sm text-gray-600">Suhu > 38°C — Kirim notifikasi ke tim lapangan.</div>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="font-medium mb-1">Rekomendasi</div>
                                    <div class="text-sm text-gray-600">Tambah naungan atau penyiraman manual.</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button id="prevBtn2"
                                    class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg">Kembali</button>
                                <button id="finishBtn"
                                    class="ml-auto px-5 py-2 bg-green-600 text-white rounded-lg">Selesai</button>
                            </div>
                        </div>
                    </div>

                    <div id="finishedToast"
                        class="mt-6 hidden p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">
                        Selamat — panduan selesai. Perangkat sudah siap digunakan.
                    </div>
                </div>

                <!-- Interactive Accordion -->
                <div class="mt-6">
                    <h2 class="text-xl font-semibold mb-4">Tips & FAQ Interaktif</h2>
                    <div class="space-y-3">
                        <div class="border rounded-lg overflow-hidden">
                            <button
                                class="accordion-btn w-full text-left px-4 py-3 flex justify-between items-center bg-white">
                                <span>Bagaimana cara mereset perangkat?</span>
                                <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="accordion-panel px-4 py-3 bg-gray-50 hidden">Tekan tombol reset selama 8 detik
                                sampai lampu berkedip.</div>
                        </div>

                        <div class="border rounded-lg overflow-hidden">
                            <button
                                class="accordion-btn w-full text-left px-4 py-3 flex justify-between items-center bg-white">
                                <span>Apa yang harus dilakukan saat sinyal lemah?</span>
                                <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="accordion-panel px-4 py-3 bg-gray-50 hidden">Pindahkan perangkat lebih dekat ke
                                gateway atau gunakan antena eksternal.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = Array.from(document.querySelectorAll('.step-btn'));
            const panels = Array.from(document.querySelectorAll('.step-panel'));
            const progress = document.getElementById('progress');
            const nextBtn = document.getElementById('nextBtn');
            const nextBtn2 = document.getElementById('nextBtn2');
            const prevBtn = document.getElementById('prevBtn');
            const prevBtn2 = document.getElementById('prevBtn2');
            const finishBtn = document.getElementById('finishBtn');
            const finishedToast = document.getElementById('finishedToast');

            let current = 0;

            function update() {
                steps.forEach((s, i) => {
                    s.classList.toggle('bg-blue-600', i === current);
                    s.classList.toggle('text-white', i === current);
                    s.classList.toggle('bg-gray-200', i !== current);
                    s.classList.toggle('text-gray-700', i !== current);
                });

                panels.forEach((p, i) => {
                    p.classList.toggle('hidden', i !== current);
                });

                const percent = ((current) / (steps.length - 1)) * 100;
                progress.style.width = percent + '%';
            }

            steps.forEach((btn, idx) => {
                btn.addEventListener('click', () => {
                    current = idx;
                    update();
                });
            });

            if (nextBtn) nextBtn.addEventListener('click', () => {
                current = Math.min(current + 1, steps.length - 1);
                update();
            });
            if (nextBtn2) nextBtn2.addEventListener('click', () => {
                current = Math.min(current + 1, steps.length - 1);
                update();
            });
            if (prevBtn) prevBtn.addEventListener('click', () => {
                current = Math.max(current - 1, 0);
                update();
            });
            if (prevBtn2) prevBtn2.addEventListener('click', () => {
                current = Math.max(current - 1, 0);
                update();
            });

            if (finishBtn) finishBtn.addEventListener('click', () => {
                finishedToast.classList.remove('hidden');
                setTimeout(() => finishedToast.classList.add('hidden'), 6000);
            });

            // Accordion
            document.querySelectorAll('.accordion-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const panel = btn.nextElementSibling;
                    const icon = btn.querySelector('svg');
                    const isHidden = panel.classList.contains('hidden');
                    document.querySelectorAll('.accordion-panel').forEach(p => p.classList.add(
                        'hidden'));
                    document.querySelectorAll('.accordion-btn svg').forEach(s => s.classList.remove(
                        'rotate-180'));
                    if (isHidden) {
                        panel.classList.remove('hidden');
                        icon.classList.add('rotate-180');
                    } else {
                        panel.classList.add('hidden');
                        icon.classList.remove('rotate-180');
                    }
                });
            });

            // Initialize
            update();
        });
    </script>

    <style>
        .step-panel {
            transition: opacity 0.2s ease;
        }

        .accordion-panel {
            transition: max-height 0.2s ease;
        }
    </style>
@endsection
