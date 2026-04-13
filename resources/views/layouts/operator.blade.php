<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#3b82f6">
    <meta name="description" content="Operator Panel - LaporinAja">
    <title>Operator Panel - LaporinAja</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .admin-sidebar-collapsed ~ main {
            margin-left: 70px;
        }

        .admin-sidebar-expanded ~ main {
            margin-left: 280px;
        }

        main {
            transition: margin-left 0.3s ease-in-out;
        }

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
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        @include('partials.operator-sidebar')

        <div x-data="{ sidebarOpen: false }">
            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>
        </div>

        <main class="flex-1 min-w-0">
            <div class="bg-white shadow-sm border-b sticky top-0 z-20">
                <div class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <button id="mobileMenuBtn" class="md:hidden inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="hidden md:block">
                            <h1 class="text-lg sm:text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard Operator')</h1>
                            <p class="text-xs sm:text-sm text-gray-500">@yield('page-description', 'Kelola laporan yang ditugaskan kepada Anda')</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-4">
                        @auth
                            @include('partials.auth-dropdown', [
                                'profileRoute' => route('profile.edit'),
                                'profileLabel' => 'Profile Saya',
                                'settingsRoute' => '#',
                                'settingsLabel' => 'Pengaturan',
                                'metaText' => 'Operator Lapangan'
                            ])
                        @endauth
                    </div>
                </div>
            </div>

            <div class="block md:hidden px-4 pb-3">
                <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard Operator')</h1>
                <p class="text-xs text-gray-500">@yield('page-description', 'Kelola laporan yang ditugaskan kepada Anda')</p>
            </div>

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

                @yield('operator-content')
            </div>
        </main>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
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
