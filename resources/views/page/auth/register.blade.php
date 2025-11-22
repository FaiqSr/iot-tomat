@extends('layout.lp')

@section('title', 'Register - Tomat Guard')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="container mx-auto px-5">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Daftar Akun Tomat Guard</h1>
                    <p class="text-sm text-gray-600 mb-6">Buat akun untuk mulai memantau tanaman dan perangkat IoT Anda.</p>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama depan</label>
                            <input name="first" type="text" required autofocus
                                class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                placeholder="Nama Anda" value="{{ old('first') }}">
                            @error('first')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                            <input name="last" type="text" required autofocus
                                class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                placeholder="Nama Anda" value="{{ old('last') }}">
                            @error('last')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input name="email" type="email" required
                                class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                placeholder="email@contoh.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input name="password" type="password" required
                                    class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                    placeholder="••••••">
                                @error('password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" required
                                    class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                    placeholder="••••••">
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-700 transition">Daftar</button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
                    </div>
                </div>

                <div class="mt-6 text-center text-xs text-gray-500">© {{ date('Y') }} Tomat Guard</div>
            </div>
        </div>
    </section>
@endsection
