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
        
        <!-- Navigation -->
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group">
                <i class="fas fa-tachometer-alt w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}"></i>
                <span>Dashboard</span>
            </a>
        <a href="{{ route('laporan.create') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group">
                <i class="fas fa-plus-circle w-5"></i>
                <span>Laporkan Masalah</span>
            </a>
            
            <a href="{{ route('laporan.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('laporan.index') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group">
                <i class="fas fa-eye w-5"></i>
                <span>Pantau Aduan</span>
            </a>
            
            <a href="{{ route('relawan.create') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('relawan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group">
                <i class="fas fa-hands-helping w-5"></i>
                <span>Gabung Relawan</span>
            </a>
        </nav>
    </div>
</aside>