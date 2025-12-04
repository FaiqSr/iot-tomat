@extends('layout.lp')
@section('title', 'About Tomat Guard')

@section('content')
    <section class="pt-24 pb-16 bg-gradient-to-r from-[#F5F6F7] to-[#E3E8EE]">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-[#4F6F8F] mb-4">
                Tentang <span class="text-[#7BA490]">Tomat Guard</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Tomat Guard adalah sistem pemantauan dan perlindungan tanaman Tomat Berbasis IoT,
                yang dibuat untuk membantu petani mengetahui kesehatan tanaman secara real-time.
            </p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">

            <div>
                <h2 class="text-3xl font-bold text-[#4F6F8F] mb-4">Apa itu Tomat Guard?</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Tomat Guard adalah sebuah project inovasi agritech yang fokus pada monitoring
                    penyakit tanaman tomat menggunakan sensor IoT dan AI berbasis Machine Learning.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Sistem ini memungkinkan petani untuk mengambil keputusan lebih cepat mengenai
                    kondisi tanaman, mencegah kerusakan dini, dan meningkatkan produktivitas lahan pertanian.
                </p>
            </div>

            <div class="rounded-2xl shadow-xl overflow-hidden border border-[#E3E8EE]">
                <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6" class="w-full h-80 object-cover">
            </div>

        </div>
    </section>

    <section class="py-16 bg-[#F5F6F7]">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-[#4F6F8F] mb-8">Visi & Misi</h2>

            <div class="grid md:grid-cols-2 gap-10">
                <div class="p-8 rounded-lg shadow-lg bg-white border border-[#E3E8EE]">
                    <h3 class="text-2xl font-semibold text-[#7BA490] mb-3">Visi</h3>
                    <p class="text-gray-600">
                        Menghadirkan sistem pengawasan tanaman modern yang mudah digunakan, efisien,
                        dan akurat dalam membantu petani meningkatkan hasil panen secara signifikan.
                    </p>
                </div>

                <div class="p-8 rounded-lg shadow-lg bg-white border border-[#E3E8EE]">
                    <h3 class="text-2xl font-semibold text-[#7BA490] mb-3">Misi</h3>
                    <ul class="text-gray-600 space-y-2 text-left list-disc px-6">
                        <li>Memanfaatkan IoT untuk pemantauan kondisi tanaman secara real-time.</li>
                        <li>Menggunakan Machine Learning untuk mendeteksi penyakit lebih awal.</li>
                        <li>Menyediakan sistem yang mudah digunakan oleh semua petani.</li>
                        <li>Meningkatkan produktivitas dan kualitas tanaman tomat.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-[#4F6F8F] mb-8">Tim Pengembang</h2>
            <div class="flex flex-wrap justify-center gap-20">
                <div class="p-2 rounded-sm shadow-lg bg-[#F5F6F7] border border-[#E3E8EE] w-[300px] h-[400px] mx-auto">
                    <section class="w-full h-96 mb-2">
                        <img src="{{ url('/images/kelompok/arif.jpeg') }}" alt=""
                            class="object-cover w-full h-full">
                    </section>
                    <h4 class="text-xl font-semibold text-[#4F6F8F]">Arif Sanda</h4>
                    <p class="text-gray-600">WSeb Developer</p>
                </div>
                <div class="p-2 rounded-sm shadow-lg bg-[#F5F6F7] border border-[#E3E8EE] w-[300px] h-[400px] mx-auto">
                    <section class="w-full h-96 mb-2">
                        <img src="{{ url('/images/kelompok/simamora.png') }}" alt=""
                            class="object-cover w-full h-full">
                    </section>
                    <h4 class="text-xl font-semibold text-[#4F6F8F]">Reynaldi Simamora</h4>
                    <p class="text-gray-600">ML Engineer</p>
                </div>
                <div class="p-2 rounded-sm shadow-lg bg-[#F5F6F7] border border-[#E3E8EE] w-[300px] h-[400px] mx-auto">
                    <section class="w-full h-96 mb-2">
                        <img src="{{ url('/images/kelompok/fad.jpg') }}" alt="" class="object-cover w-full h-full">
                    </section>
                    <h4 class="text-xl font-semibold text-[#4F6F8F]">Fadhil Alfaruq</h4>
                    <p class="text-gray-600">3D Developer</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-[#4F6F8F] text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Ingin Bekerja Sama?</h2>
            <p class="max-w-2xl mx-auto mb-6 text-gray-200">
                Kami terbuka untuk kolaborasi dengan petani, peneliti, dan institusi
                yang ingin mengembangkan teknologi pertanian berbasis IoT.
            </p>

            <a href="/contact"
                class="px-8 py-3 bg-white text-[#4F6F8F] rounded-full shadow-lg font-semibold hover:bg-[#F5F6F7] transition">
                Hubungi Kami
            </a>
        </div>
    </section>

@endsection
