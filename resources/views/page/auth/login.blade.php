@extends('layout.lp')

@section('title', 'Login - Tomat Guard')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="container mx-auto px-5">
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl shadow p-8">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Masuk ke Tomat Guard</h1>
                    <p class="text-sm text-gray-600 mb-6">Masukkan kredensial akun Anda untuk mengakses dashboard.</p>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input name="email" type="email" required autofocus
                                class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                placeholder="email@contoh.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input name="password" type="password" required
                                class="mt-1 block w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-200"
                                placeholder="••••••">
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remember" class="mr-2">
                                <span class="text-gray-700">Ingat saya</span>
                            </label>

                            <a href="{{ route('password.request') ?? '#' }}" class="text-blue-600 hover:underline">Lupa
                                password?</a>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full px-6 py-3 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-700 transition">Masuk</button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
                    </div>
                </div>

                <div class="mt-6 text-center text-xs text-gray-500">© {{ date('Y') }} Tomat Guard</div>
            </div>
        </div>
    </section>
@endsection
