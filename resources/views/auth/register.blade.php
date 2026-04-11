@extends('layouts.auth')

@section('title', 'Daftar - LaporinAja')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4 py-12">
    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 text-white text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-white/20 w-14 h-14 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold">Daftar</h1>
                <p class="text-blue-100 text-sm mt-1">Bergabunglah dengan LaporinAja</p>
            </div>

            <!-- Form Section -->
            <div class="px-6 py-8">
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 font-medium flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Terjadi kesalahan
                        </p>
                        <ul class="text-red-600 text-sm mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>
                            Nama Lengkap
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                            placeholder="masukkan nama lengkap anda"
                        />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
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
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="masukkan email anda"
                        />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
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

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>
                            Konfirmasi Password
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password_confirmation') border-red-500 @enderror"
                            placeholder="konfirmasi password anda"
                        />
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agree to Terms -->
                    <div class="flex items-start">
                        <input
                            type="checkbox"
                            id="agree"
                            name="agree"
                            required
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1"
                        />
                        <label for="agree" class="ml-2 text-sm text-gray-600">
                            Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Syarat & Ketentuan</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2.5 rounded-lg transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-user-check"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-sm text-gray-500">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-center text-xs text-gray-500">
                <i class="fas fa-shield-alt mr-1 text-blue-600"></i>
                Data anda dilindungi dengan enkripsi tingkat enterprise
            </div>
        </div>
    </div>
</div>
@endsection
