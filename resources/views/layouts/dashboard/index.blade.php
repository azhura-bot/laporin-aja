@extends('layouts.dashboard.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Include Sidebar Partial -->
    @include('partials.sidebar')

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