@extends('layouts.dashboard.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content - akan mengikuti sidebar auto hide -->
    <main class="flex-1 transition-all duration-300" id="mainContent">
        <!-- Top Navbar -->
        <div class="bg-white shadow-sm border-b sticky top-0 z-20">
            <div class="px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex justify-end items-center">
                    @include('partials.auth-dropdown', [
                        'profileRoute' => '#',
                        'profileLabel' => 'Profile',
                        'settingsRoute' => '#',
                        'settingsLabel' => 'Pengaturan'
                    ])
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-4 sm:p-6 lg:p-8">
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
    
    /* Transisi smooth */
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