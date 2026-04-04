<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>

<body class="bg-[#FFFDF5] text-gray-800">
    <div class="flex min-h-screen">
        <!-- Include Sidebar Admin Partial -->
        @include('partials.admin-sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-72">
            <!-- Top Navbar -->
            <div class="bg-white shadow-sm border-b sticky top-0 z-10">
                <div class="px-8 py-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'Dashboard Admin')</h1>
                        <p class="text-sm text-gray-500">@yield('page-description', 'Kelola laporan dan pantau aktivitas masyarakat')</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button class="text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-bell text-xl"></i>
                            </button>
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-white text-[10px] flex items-center justify-center">3</span>
                        </div>
                        
                        <!-- User Avatar -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>{{ session('info') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-blue-700">&times;</button>
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>

    <script>
        // Animasi fade-in
        const elements = document.querySelectorAll('.fade-in');
        const showOnScroll = () => {
            elements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) el.classList.add('show');
            });
        };
        window.addEventListener('scroll', showOnScroll);
        window.addEventListener('load', showOnScroll);
    </script>
</body>
</html>