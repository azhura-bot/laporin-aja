<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#3b82f6">
    <meta name="description" content="Platform Pengaduan Masyarakat - LaporinAja">
    
    <title>@yield('title', 'Dashboard - LaporinAja')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        [x-cloak] {
            display: none !important;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom focus ring */
        *:focus {
            outline: none;
            ring: 2px solid #3b82f6;
        }
        
        /* Better button tap highlight on mobile */
        button, a {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Fade animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }
        
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    
    @stack('styles')
</head>

<body class="bg-gray-50 overflow-x-hidden">
    @yield('content')

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Fade animation script -->
    <script>
        const fadeElements = document.querySelectorAll('.fade-in');
        const showFadeOnScroll = () => {
            fadeElements.forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 100) {
                    el.classList.add('show');
                }
            });
        };
        window.addEventListener('scroll', showFadeOnScroll);
        window.addEventListener('load', showFadeOnScroll);
    </script>
    
    @stack('scripts')
</body>
</html>