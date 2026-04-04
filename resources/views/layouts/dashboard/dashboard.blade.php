@extends('layouts.dashboard.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-lg min-h-screen fixed left-0 top-0 bottom-0 overflow-y-auto">
        <div class="p-6">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">LaporinAja</h2>
                <p class="text-sm text-gray-500">Platform Pengaduan</p>
            </div>
            
            <!-- User Info -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('laporan.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition">
                    <i class="fas fa-plus-circle w-5"></i>
                    <span>Buat Laporan</span>
                </a>
                
                <a href="{{ route('laporan.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.index') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition">
                    <i class="fas fa-eye w-5"></i>
                    <span>Pantau Aduan</span>
                </a>
                
                <a href="{{ route('relawan.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('relawan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition">
                    <i class="fas fa-hands-helping w-5"></i>
                    <span>Gabung Relawan</span>
                </a>
            </nav>
            
            <!-- Logout -->
            <div class="border-t mt-6 pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-72">
        <div class="p-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-info-circle mr-2"></i>
                    {{ session('info') }}
                </div>
            @endif

            @yield('dashboard-content')
        </div>
    </main>
</div>
@endsection