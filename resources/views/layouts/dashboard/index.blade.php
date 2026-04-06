@extends('layouts.dashboard.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Include Sidebar Partial -->
    @include('partials.sidebar')
    
    <!-- Mobile overlay -->
    <div x-data="{ sidebarOpen: false }">
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>
    </div>
    
    <!-- Main Content -->
    <main class="flex-1 min-w-0">
        <div class="p-8">
            @auth
                <div class="flex justify-end mb-6">
                    @include('partials.auth-dropdown', [
                        'dashboardRoute' => route('dashboard'),
                        'dashboardLabel' => 'Dashboard',
                        'profileRoute' => route('profile.edit'),
                        'profileLabel' => 'Profile',
                        'settingsRoute' => null,
                        'metaText' => 'Pengguna'
                    ])
                </div>
            @endauth

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('dashboard-content')
        </div>
    </main>
</div>

<style>
    /* Main content margin akan mengikuti class dari sidebar */
    .sidebar-collapsed ~ main {
        margin-left: 70px;
    }
    
    .sidebar-expanded ~ main {
        margin-left: 280px;
    }
    
    /* Transisi smooth untuk main content */
    main {
        transition: margin-left 0.3s ease-in-out;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .sidebar-collapsed ~ main,
        .sidebar-expanded ~ main {
            margin-left: 0 !important;
        }
    }
</style>
@endsection