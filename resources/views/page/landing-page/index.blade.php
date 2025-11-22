@extends('layout.lp')

@section('title', 'Tomat Guard - Solusi Monitoring Tanaman Tomat')

@section('content')
    <!-- Hero Section -->
    <section class="flex items-center bg-gray-100 min-h-svh py-20 sm:py-0">
        <div class="container mx-auto px-5 flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-5">
                    Tomat Guard: Solusi Monitoring Tanaman Tomat Berbasis IoT
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Pantau kondisi tanaman tomat Anda secara real-time dengan teknologi IoT modern. Optimalkan pertumbuhan
                    dan hasil panen dengan data yang akurat.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors text-center">
                        Mulai Sekarang
                    </a>
                    <a href="#alat"
                        class="px-6 py-3 border border-gray-700 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-center">
                        Lihat Alat
                    </a>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <img src="{{ asset('images/robot/tools-1.png') }}" alt="Tomat Guard Device"
                        class="rounded-2xl shadow-md w-full max-w-md">
                    <div class="absolute -bottom-5 -right-5 bg-white p-4 rounded-xl shadow-md">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-gray-700">Status: Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-gray-800 mb-2">500+</div>
                    <div class="text-gray-600">Petani Bergabung</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-gray-800 mb-2">1,200+</div>
                    <div class="text-gray-600">Alat Terpasang</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-gray-800 mb-2">95%</div>
                    <div class="text-gray-600">Kepuasan Pengguna</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alat Section -->
    <section id="alat" class="py-16 bg-gray-100">
        <div class="container mx-auto px-5">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Kategori Alat Tomat Guard</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Temukan berbagai perangkat IoT kami yang dirancang untuk memantau pertumbuhan tanaman tomat Anda.
                </p>
            </div>

            <!-- Carousel Container -->
            <div class="relative">
                <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow hover:bg-gray-200 z-10">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>

                <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow hover:bg-gray-200 z-10">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>

                <div class="overflow-hidden">
                    <div id="carouselTrack" class="flex transition-transform duration-300 ease-in-out">

                        <!-- SLIDE TEMPLATE -->
                        @php
                            $slides = [
                                ['icon' => 'fa-temperature-high', 'title' => 'Sensor Suhu & Kelembaban', 'unit' => 450],
                                ['icon' => 'fa-tint', 'title' => 'Sensor Kelembaban Tanah', 'unit' => 380],
                                ['icon' => 'fa-sun', 'title' => 'Sensor Cahaya', 'unit' => 320],
                                ['icon' => 'fa-wind', 'title' => 'Sensor Kualitas Udara', 'unit' => 280],
                                ['icon' => 'fa-camera', 'title' => 'Kamera Monitoring', 'unit' => 210],
                                ['icon' => 'fa-microchip', 'title' => 'Controller Hub', 'unit' => 150],
                            ];
                        @endphp

                        @foreach ($slides as $s)
                            <div class="carousel-slide flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-4">
                                <div class="bg-white rounded-xl shadow hover:shadow-md transition h-full">
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        <i class="fas {{ $s['icon'] }} text-5xl text-gray-600"></i>
                                    </div>
                                    <div class="p-6">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $s['title'] }}</h3>
                                        <p class="text-gray-600 mb-4">
                                            Perangkat ini membantu pemantauan kondisi tanaman secara real-time.
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Digunakan: <strong>{{ $s['unit'] }}
                                                    unit</strong></span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                                Tersedia
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Indicators -->
                <div class="flex justify-center mt-8 space-x-2">
                    @for ($i = 0; $i < 6; $i++)
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-400"></button>
                    @endfor
                </div>
            </div>

            <!-- Total -->
            <div class="mt-12 bg-gray-800 text-white rounded-xl p-8 text-center">
                <h3 class="text-2xl font-bold mb-2">Total Alat yang Digunakan</h3>
                <div class="text-4xl font-bold mb-4">1,790 Unit</div>
                <p class="text-gray-300">Tersebar di berbagai lokasi pertanian tomat di Indonesia</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-gray-800 text-white">
        <div class="container mx-auto px-5 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Meningkatkan Hasil Panen Anda?</h2>
            <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ratusan petani yang telah merasakan manfaat Tomat Guard.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-white text-gray-800 font-medium rounded-lg hover:bg-gray-200 transition">
                    Mulai Sekarang
                </a>
                <a href="{{ route('contact') }}"
                    class="px-6 py-3 border border-white text-white font-medium rounded-lg hover:bg-gray-700 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('carouselTrack');
            const slides = document.querySelectorAll('.carousel-slide');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.carousel-indicator');

            let currentIndex = 0;
            const slidesToShow = getSlidesToShow();

            function getSlidesToShow() {
                if (window.innerWidth >= 1024) return 3; // lg screen
                if (window.innerWidth >= 768) return 2; // md screen
                return 1; // sm screen
            }

            function updateCarousel() {
                const slideWidth = slides[0].getBoundingClientRect().width;
                const gap = 32; // 8 * 4px from px-4
                const translateX = -currentIndex * (slideWidth + gap);
                track.style.transform = `translateX(${translateX}px)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('bg-blue-600');
                        indicator.classList.remove('bg-gray-300');
                    } else {
                        indicator.classList.remove('bg-blue-600');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }

            function nextSlide() {
                const maxIndex = slides.length - slidesToShow;
                currentIndex = currentIndex < maxIndex ? currentIndex + 1 : 0;
                updateCarousel();
            }

            function prevSlide() {
                const maxIndex = slides.length - slidesToShow;
                currentIndex = currentIndex > 0 ? currentIndex - 1 : maxIndex;
                updateCarousel();
            }

            // Event Listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });
            });

            // Responsive handling
            window.addEventListener('resize', () => {
                const newSlidesToShow = getSlidesToShow();
                if (currentIndex > slides.length - newSlidesToShow) {
                    currentIndex = Math.max(0, slides.length - newSlidesToShow);
                }
                updateCarousel();
            });

            // Auto slide (optional)
            let autoSlide = setInterval(nextSlide, 5000);

            // Pause auto slide on hover
            const carouselContainer = track.parentElement;
            carouselContainer.addEventListener('mouseenter', () => {
                clearInterval(autoSlide);
            });

            carouselContainer.addEventListener('mouseleave', () => {
                autoSlide = setInterval(nextSlide, 5000);
            });

            // Initialize carousel
            updateCarousel();
        });
    </script>

    <style>
        .carousel-slide {
            transition: transform 0.3s ease;
        }

        .carousel-slide:hover {
            transform: translateY(-5px);
        }

        #carouselTrack {
            display: flex;
            gap: 2rem;
        }
    </style>
@endsection
