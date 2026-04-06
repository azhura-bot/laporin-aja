<style>
    /* Sidebar Container */
    .sidebar-container {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 40;
        transition: all 0.3s ease-in-out;
    }
    
    /* Sidebar dalam keadaan collapsed (menyempit) */
    .sidebar-collapsed {
        width: 70px;
    }
    
    /* Sidebar saat hover (melebar) */
    .sidebar-expanded {
        width: 280px;
    }
    
    /* Trigger area untuk hover (area sensitif di pinggir kiri) */
    .sidebar-trigger {
        position: fixed;
        left: 0;
        top: 0;
        width: 15px;
        height: 100%;
        z-index: 45;
        cursor: pointer;
    }
    
    /* Konten sidebar */
    .sidebar-content {
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        overflow-y: auto;
        transition: all 0.3s ease-in-out;
    }
    
    /* Sembunyikan teks saat collapsed */
    .sidebar-collapsed .sidebar-text {
        display: none;
        opacity: 0;
    }
    
    /* Tampilkan teks saat expanded */
    .sidebar-expanded .sidebar-text {
        display: inline;
        opacity: 1;
    }
    
    /* Atur icon dan teks */
    .sidebar-link {
        white-space: nowrap;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    /* Tooltip untuk collapsed mode */
    .sidebar-tooltip {
        position: fixed;
        left: 80px;
        background: #1f2937;
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 50;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        pointer-events: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .sidebar-link:hover .sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    /* Custom scrollbar */
    .sidebar-content::-webkit-scrollbar {
        width: 4px;
    }
    
    .sidebar-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .sidebar-content::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Logo styling */
    .logo-icon {
        transition: all 0.3s ease;
    }
    
    .sidebar-collapsed .logo-text {
        display: none;
    }
    
    .sidebar-expanded .logo-text {
        display: block;
    }
    
    /* Tombol pin (optional) */
    .pin-btn {
        position: absolute;
        right: -12px;
        top: 20px;
        width: 24px;
        height: 24px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 46;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .sidebar-expanded .pin-btn {
        opacity: 1;
    }
    
    .pin-btn:hover {
        background: #f1f5f9;
        transform: scale(1.1);
    }
    
    /* User info di sidebar */
    .user-info {
        transition: all 0.3s ease;
    }
    
    .sidebar-collapsed .user-details {
        display: none;
    }
    
    .sidebar-expanded .user-details {
        display: block;
    }
    
    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .sidebar-container {
            transform: translateX(-100%);
            z-index: 50;
        }
        
        .sidebar-container.mobile-open {
            transform: translateX(0);
        }
        
        .sidebar-trigger {
            display: none;
        }
        
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 45;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>

<div class="sidebar-container" id="sidebarContainer"
     @mouseenter="expandSidebar()"
     @mouseleave="collapseSidebar()">
    
    <!-- Trigger area (area sensitif di pinggir kiri) -->
    <div class="sidebar-trigger" id="sidebarTrigger"></div>
    
    <!-- Tombol pin/lock -->
    <div class="pin-btn" id="pinBtn" onclick="toggleSidebarPin()">
        <i class="fas fa-thumbtack"></i>
    </div>
    
    <!-- Sidebar Content -->
    <div class="sidebar-content" id="sidebarContent">
        <div class="p-4">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="bg-blue-600 w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-2 shadow-lg logo-icon">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 logo-text">LaporinAja</h2>
                <p class="text-xs text-gray-500 logo-text">Platform Pengaduan</p>
            </div>
            
            <!-- Close button untuk mobile -->
            <div class="flex justify-end lg:hidden mb-4">
                <button onclick="closeMobileSidebar()" class="text-gray-500 hover:text-gray-700 p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-tachometer-alt w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Dashboard</span>
                    <span class="sidebar-tooltip">Dashboard</span>
                </a>
                
                <!-- Laporkan Masalah -->
                <a href="{{ route('laporan.create') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('laporan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-plus-circle w-5 {{ request()->routeIs('laporan.create') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Laporkan Masalah</span>
                    <span class="sidebar-tooltip">Laporkan Masalah</span>
                </a>
                
                <!-- Pantau Aduan -->
                <a href="{{ route('laporan.index') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('laporan.index') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-eye w-5 {{ request()->routeIs('laporan.index') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Pantau Aduan</span>
                    <span class="sidebar-tooltip">Pantau Aduan</span>
                </a>
                
                <!-- Gabung Relawan -->
                <a href="{{ route('relawan.create') }}" 
                   class="sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('relawan.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition group relative">
                    <i class="fas fa-hands-helping w-5 {{ request()->routeIs('relawan.create') ? 'text-white' : 'text-gray-400' }}"></i>
                    <span class="sidebar-text">Gabung Relawan</span>
                    <span class="sidebar-tooltip">Gabung Relawan</span>
                </a>
            </nav>
        </div>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

<script>
    let isPinned = false;
    let hoverTimeout;
    let isHovering = false;
    
    const sidebarContainer = document.getElementById('sidebarContainer');
    const pinBtn = document.getElementById('pinBtn');
    
    // Fungsi untuk expand sidebar
    function expandSidebar() {
        if (!isPinned && window.innerWidth > 768) {
            clearTimeout(hoverTimeout);
            sidebarContainer.classList.remove('sidebar-collapsed');
            sidebarContainer.classList.add('sidebar-expanded');
            isHovering = true;
        }
    }
    
    // Fungsi untuk collapse sidebar
    function collapseSidebar() {
        if (!isPinned && window.innerWidth > 768) {
            hoverTimeout = setTimeout(() => {
                if (!isHovering) {
                    sidebarContainer.classList.remove('sidebar-expanded');
                    sidebarContainer.classList.add('sidebar-collapsed');
                }
            }, 100);
        }
        isHovering = false;
    }
    
    // Fungsi untuk toggle pin (lock sidebar)
    function toggleSidebarPin() {
        isPinned = !isPinned;
        
        if (isPinned) {
            // Locked - sidebar tetap expanded
            sidebarContainer.classList.remove('sidebar-collapsed');
            sidebarContainer.classList.add('sidebar-expanded');
            pinBtn.innerHTML = '<i class="fas fa-thumbtack"></i>';
            pinBtn.style.backgroundColor = '#3b82f6';
            pinBtn.style.borderColor = '#3b82f6';
            pinBtn.querySelector('i').style.color = 'white';
        } else {
            // Unlocked - sidebar bisa auto hide
            sidebarContainer.classList.remove('sidebar-expanded');
            sidebarContainer.classList.add('sidebar-collapsed');
            pinBtn.innerHTML = '<i class="fas fa-thumbtack"></i>';
            pinBtn.style.backgroundColor = 'white';
            pinBtn.style.borderColor = '#e2e8f0';
            pinBtn.querySelector('i').style.color = '#64748b';
        }
    }
    
    // Inisialisasi sidebar dalam keadaan collapsed
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth > 768) {
            sidebarContainer.classList.add('sidebar-collapsed');
        }
        
        // Event listener untuk trigger area
        const triggerArea = document.querySelector('.sidebar-trigger');
        if (triggerArea) {
            triggerArea.addEventListener('mouseenter', expandSidebar);
        }
        
        // Mouse enter/leave untuk sidebar container
        sidebarContainer.addEventListener('mouseenter', function() {
            isHovering = true;
            if (window.innerWidth > 768) expandSidebar();
        });
        
        sidebarContainer.addEventListener('mouseleave', function() {
            isHovering = false;
            if (window.innerWidth > 768) collapseSidebar();
        });
    });
    
    // Fungsi untuk mobile
    function openMobileSidebar() {
        sidebarContainer.classList.add('mobile-open');
        document.getElementById('sidebarOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMobileSidebar() {
        sidebarContainer.classList.remove('mobile-open');
        document.getElementById('sidebarOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileSidebar();
            if (!isPinned) {
                sidebarContainer.classList.add('sidebar-collapsed');
                sidebarContainer.classList.remove('sidebar-expanded');
            }
        }
    });
    
    // Tombol untuk mobile (opsional, bisa ditambahkan di navbar)
    // Tambahkan button dengan id="mobileMenuBtn" di navbar untuk membuka sidebar di mobile
</script>