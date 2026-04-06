<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#3b82f6">
    <meta name="description" content="Admin Panel - LaporinAja">
    
    <title>Admin Panel - LaporinAja</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease-out;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
        
        [x-cloak] {
            display: none !important;
        }

        /* Main content margin akan mengikuti class dari sidebar admin */
        .admin-sidebar-collapsed ~ main {
            margin-left: 70px;
        }

        .admin-sidebar-expanded ~ main {
            margin-left: 280px;
        }

        /* Transisi smooth untuk main content */
        main {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .admin-sidebar-collapsed ~ main,
            .admin-sidebar-expanded ~ main {
                margin-left: 0 !important;
            }
        }

    </style>
    
    @stack('styles')
</head>

<body class="bg-[#FFFDF5] text-gray-800">
    <div class="flex min-h-screen">
        <!-- Include Sidebar Admin Partial -->
        @include('partials.admin-sidebar')

        <!-- Mobile overlay -->
        <div x-data="{ sidebarOpen: false }">
            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Top Navbar -->
            <div class="bg-white shadow-sm border-b sticky top-0 z-20">
                <div class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 flex justify-between items-center">
                    <!-- Left side - Mobile menu button -->
                    <div class="flex items-center gap-3">
                        <button id="mobileMenuBtn" class="md:hidden inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="hidden md:block">
                            <h1 class="text-lg sm:text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard Admin')</h1>
                            <p class="text-xs sm:text-sm text-gray-500">@yield('page-description', 'Kelola laporan dan pantau aktivitas masyarakat')</p>
                        </div>
                    </div>
                    
                    <!-- Right side - User menu -->
                    <div class="flex items-center gap-2 sm:gap-4">
                        <!-- Notification Bell -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-bell text-lg sm:text-xl"></i>
                            </button>
                            <span class="absolute -top-1 -right-1 w-3 h-3 sm:w-4 sm:h-4 bg-red-500 rounded-full text-white text-[8px] sm:text-[10px] flex items-center justify-center">3</span>

                            <div x-show="open" @click.away="open = false" x-cloak 
                                 class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-lg py-2 z-50 border">
                                <div class="p-3 border-b">
                                    <p class="font-semibold text-gray-800">Notifikasi</p>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <div class="p-3 hover:bg-gray-50 transition cursor-pointer">
                                        <p class="text-sm text-gray-600">Tidak ada notifikasi baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @auth
                            @include('partials.auth-dropdown', [
                                'dashboardRoute' => route('admin.dashboard'),
                                'dashboardLabel' => 'Dashboard Admin',
                                'profileRoute' => route('profile.edit'),
                                'profileLabel' => 'Profile Saya',
                                'settingsRoute' => '#',
                                'settingsLabel' => 'Pengaturan',
                                'metaText' => 'Administrator'
                            ])
                        @endauth
                    </div>
                </div>
                
                <!-- Mobile page title -->
                <div class="block md:hidden px-4 pb-3">
                    <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard Admin')</h1>
                    <p class="text-xs text-gray-500">@yield('page-description', 'Kelola laporan dan pantau aktivitas masyarakat')</p>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 sm:mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm sm:text-base">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 text-lg">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 sm:mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="text-sm sm:text-base">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 text-lg">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 sm:mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span class="text-sm sm:text-base">{{ session('info') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900 text-lg">&times;</button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 sm:mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span class="text-sm sm:text-base">{{ session('warning') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900 text-lg">&times;</button>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>

    <!-- Alpine.js untuk dropdown -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <script>
        // Mobile sidebar toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const sidebarContainer = document.getElementById('adminSidebarContainer');
                if (sidebarContainer) {
                    sidebarContainer.classList.toggle('mobile-open');
                    const overlay = document.getElementById('adminSidebarOverlay');
                    if (overlay) {
                        overlay.classList.toggle('active');
                    }
                    document.body.style.overflow = sidebarContainer.classList.contains('mobile-open') ? 'hidden' : '';
                }
            });
        }
        
        // Animasi fade-in
        const elements = document.querySelectorAll('.fade-in');
        const showOnScroll = () => {
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('show');
                }
            });
        };
        window.addEventListener('scroll', showOnScroll);
        window.addEventListener('load', showOnScroll);
    </script>
    
    @stack('scripts')
</body>
</html>