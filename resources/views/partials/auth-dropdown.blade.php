@php
    $dashboardRoute = $dashboardRoute ?? null;
    $dashboardLabel = $dashboardLabel ?? 'Dashboard';
    $profileRoute = $profileRoute ?? route('profile.edit');
    $profileLabel = $profileLabel ?? 'Profile';
    $settingsRoute = $settingsRoute ?? null;
    $settingsLabel = $settingsLabel ?? 'Pengaturan';
    $metaText = $metaText ?? (Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna');
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-3 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-full transition duration-300 focus:outline-none">
        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold shadow-md">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-500">{{ $metaText }}</p>
        </div>
        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
    </button>

    <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
        <div class="px-4 py-3 border-b bg-gray-50 rounded-t-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 text-sm">
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>

        @if($dashboardRoute)
            <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition text-sm">
                <i class="fas fa-tachometer-alt w-4 text-gray-400"></i>
                {{ $dashboardLabel }}
            </a>
        @endif

        <a href="{{ $profileRoute }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition text-sm">
            <i class="fas fa-user-circle w-4 text-gray-400"></i>
            {{ $profileLabel }}
        </a>

        @if($settingsRoute)
            <a href="{{ $settingsRoute }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-gray-50 transition text-sm">
                <i class="fas fa-cog w-4 text-gray-400"></i>
                {{ $settingsLabel }}
            </a>
        @endif

        <div class="border-t my-1"></div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                <i class="fas fa-sign-out-alt w-4"></i>
                Logout
            </button>
        </form>
    </div>
</div>
