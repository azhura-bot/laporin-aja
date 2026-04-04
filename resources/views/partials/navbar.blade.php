<nav class="fixed top-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-lg z-50 transition-all duration-300">
    <div class="container mx-auto px-6 md:px-24 flex justify-between items-center py-4">
        <a href="{{ url('/') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent hover:from-blue-700 hover:to-blue-900 transition tracking-tight">
            LaporinAja
        </a>

        <!-- Menu Desktop -->
        <ul class="hidden md:flex space-x-8 font-medium items-center">
            <li><a href="{{ url('/') }}" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                Beranda
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a></li>
            <li><a href="#tentang" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                Tentang Kami
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a></li>
            <li><a href="#layanan" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                Layanan
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a></li>
            <li><a href="#kontak" class="relative text-gray-700 hover:text-blue-600 transition duration-300 group font-medium">
                Kontak
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-blue-500 group-hover:w-full transition-all duration-300"></span>
            </a></li>
        </ul>

        <!-- GROUP BUTTON: PORTAL WARGA (OUTLINE) + PORTAL ADMIN (SOLID) -->
        <div class="hidden md:flex items-center gap-3">
            <!-- TOMBOL PORTAL WARGA - STYLE OUTLINE (seperti "Pelajari Lebih") -->
            @if(Route::has('warga.portal'))
                <a href="{{ route('warga.portal') }}" class="group relative px-5 py-2.5 bg-transparent border-2 border-blue-600 text-blue-600 font-medium rounded-full hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm hover:shadow-md overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fas fa-users text-sm"></i>
                        Portal Warga
                    </span>
                </a>
            @endif
            
            <!-- TOMBOL PORTAL ADMIN - STYLE SOLID (seperti "Buat Laporan") -->
            <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-full hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                <i class="fas fa-user-shield text-sm"></i>
                Portal Admin
            </a>

            <!-- USER MENU FOR AUTHENTICATED USERS -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-full transition duration-300">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-sm" :class="{'rotate-180': open}"></i>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-tachometer-alt w-4"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-user-edit w-4"></i>
                            Profile
                        </a>
                        <div class="border-t my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                <i class="fas fa-sign-out-alt w-4"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Hamburger -->
        <button id="menu-btn" class="md:hidden flex flex-col space-y-1">
            <span class="w-6 h-0.5 bg-gray-700"></span>
            <span class="w-6 h-0.5 bg-gray-700"></span>
            <span class="w-6 h-0.5 bg-gray-700"></span>
        </button>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden flex-col items-center space-y-4 bg-white shadow-md py-6 md:hidden">
        <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-500 font-medium">Beranda</a>
        <a href="#tentang" class="text-gray-700 hover:text-blue-500 font-medium">Tentang Kami</a>
        <a href="#layanan" class="text-gray-700 hover:text-blue-500 font-medium">Layanan</a>
        <a href="#kontak" class="text-gray-700 hover:text-blue-500 font-medium">Kontak</a>
        
        <!-- Divider -->
        <div class="w-3/4 h-px bg-gray-200 my-2"></div>
        
        <!-- Portal Warga di Mobile - OUTLINE -->
        @if(Route::has('warga.portal'))
            <a href="{{ route('warga.portal') }}" class="px-6 py-2.5 bg-transparent border-2 border-blue-600 text-blue-600 font-medium rounded-full w-3/4 text-center flex items-center justify-center gap-2 hover:bg-blue-600 hover:text-white transition duration-300">
                <i class="fas fa-users"></i>
                Portal Warga
            </a>
        @endif
        
        <!-- Portal Admin di Mobile - SOLID -->
        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-full w-3/4 text-center flex items-center justify-center gap-2 hover:from-blue-700 hover:to-blue-800 transition duration-300">
            <i class="fas fa-user-shield"></i>
            Portal Admin
        </a>

        <!-- USER MENU FOR AUTHENTICATED USERS - MOBILE -->
        @auth
            <!-- Divider -->
            <div class="w-3/4 h-px bg-gray-200 my-2"></div>
            
            <div class="w-3/4 text-center">
                <p class="text-sm text-gray-600 mb-2">Halo, {{ Auth::user()->name }}</p>
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-blue-50 text-blue-600 font-medium rounded-full hover:bg-blue-100 transition">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 bg-gray-50 text-gray-700 font-medium rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-user-edit mr-2"></i>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 font-medium rounded-full hover:bg-red-100 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        });
    }
</script>