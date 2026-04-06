<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="theme-color" content="#3b82f6">
    <meta name="description" content="Dashboard Warga - LaporinAja">
    
    <title>@yield('title', 'Dashboard - LaporinAja')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="bg-[#FFFDF5] text-gray-800">
    @yield('content')

    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>
</html>