@extends('layout.lp')

@section('title', 'Contact - Tomat Guard')

@section('content')<section class="pt-24 pb-16 bg-gradient-to-r from-[#F5F6F7] to-[#E3E8EE]">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-[#4F6F8F] mb-4">
                Hubungi <span class="text-[#7BA490]">Kami</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Jika Anda memiliki pertanyaan, ingin bekerja sama, atau memiliki masukan, silakan hubungi kami melalui form
                di bawah ini.
            </p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 grid gap-12">

            <!-- Contact Info -->
            <div class="space-y-8">
                <h2 class="text-3xl font-bold text-[#4F6F8F]">Informasi Kontak</h2>
                <p class="text-gray-600 leading-relaxed">
                    Anda dapat menghubungi kami kapan saja melalui kontak di bawah, atau gunakan form pesan langsung.
                    Kami akan membalas dalam waktu secepat mungkin.
                </p>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#E3E8EE] flex items-center justify-center">
                        📍
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#4F6F8F]">Alamat</h3>
                        <p class="text-gray-600">Jl. Mawar No. 12, Bandung, Jawa Barat</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#E3E8EE] flex items-center justify-center">
                        📞
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#4F6F8F]">Telepon</h3>
                        <p class="text-gray-600">+62 857-0000-1234</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#E3E8EE] flex items-center justify-center">
                        ✉️
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-[#4F6F8F]">Email</h3>
                        <p class="text-gray-600">support@tomatguard.com</p>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <section class="py-10 bg-[#F5F6F7]">
        <div class="container mx-auto px-4 text-center">
            <h3 class="text-xl font-bold text-[#4F6F8F] mb-4">Lokasi Kami</h3>
            <div class="w-full h-72 rounded-2xl overflow-hidden shadow-lg border border-[#E3E8EE]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.99200374862!2d107.619!3d-6.902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6f5c3f91!2sBandung!5e0!3m2!1sid!2sid!4v0000"
                    width="100%" height="100%" allowfullscreen loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

@endsection
