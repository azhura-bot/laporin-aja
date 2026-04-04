<!-- Sidebar Admin -->
<aside class="w-72 bg-white shadow-lg min-h-screen fixed left-0 top-0 bottom-0 overflow-y-auto z-30">
    <div class="p-6">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Admin Panel</h2>
            <p class="text-sm text-gray-500">LaporinAja</p>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.laporan.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200">
                <i class="fas fa-file-alt w-5"></i>
                <span>Semua Laporan</span>
                @php
                    $totalPending = \App\Models\Laporan::where('status', 'pending')->count();
                @endphp
                @if($totalPending > 0)
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $totalPending }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.analisis') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.analisis') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200">
                <i class="fas fa-chart-line w-5"></i>
                <span>Data & Analisis</span>
            </a>
            
            <a href="{{ route('admin.kelola-status') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.kelola-status') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200">
                <i class="fas fa-tasks w-5"></i>
                <span>Kelola Status</span>
            </a>
            
            <a href="{{ route('admin.balas-warga') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.balas-warga') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200">
                <i class="fas fa-reply-all w-5"></i>
                <span>Balas Warga</span>
            </a>
        </nav>
        
        <!-- Divider -->
        <div class="border-t my-6"></div>
        
        <!-- Bottom Menu -->
        <nav class="space-y-1">
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
        
        <!-- Version Info -->
        <div class="mt-8 pt-4 border-t text-center">
            <p class="text-xs text-gray-400">Admin Panel v1.0</p>
            <p class="text-xs text-gray-400">LaporinAja &copy; 2026</p>
        </div>
    </div>
</aside>