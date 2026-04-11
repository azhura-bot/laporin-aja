@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white/20 w-14 h-14 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold">LaporinAja</h1>
                <p class="text-blue-100 text-sm mt-1">Platform Pengaduan Masyarakat</p>
            </div>

            <div class="px-6 py-8">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 font-medium flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Login gagal
                        </p>
                        <ul class="text-red-600 text-sm mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="masukkan email anda"
                        />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Password
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="masukkan password anda"
                        />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                        <label for="remember" class="ml-2 text-sm text-gray-600">
                            Ingat saya
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2.5 rounded-lg transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </form>

                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-sm text-gray-500">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-center text-xs text-gray-500">
                <i class="fas fa-shield-alt mr-1 text-blue-600"></i>
                Data anda dilindungi dengan enkripsi tingkat enterprise
            </div>
        </div>

        <p class="text-center text-gray-600 text-sm mt-6">
            Butuh bantuan?
            <a href="{{ url('/') }}" class="text-blue-600 font-semibold hover:text-blue-700">Hubungi kami</a>
        </p>
    </div>
</div>
@endsection
