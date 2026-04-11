<style>
    /* Sidebar Admin Container */
    .admin-sidebar-container {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        z-index: 40;
        transition: all 0.3s ease-in-out;
    }
    
    /* Sidebar collapsed state (sempit) */
    .admin-sidebar-collapsed {
        width: 70px;
    }
    
    /* Sidebar expanded state (lebar) */
    .admin-sidebar-expanded {
        width: 280px;
    }
    
    /* Trigger area for hover */
    .admin-sidebar-trigger {
        position: fixed;
        left: 0;
        top: 0;
        width: 15px;
        height: 100%;
        z-index: 45;
        cursor: pointer;
    }
    
    /* Sidebar content */
    .admin-sidebar-content {
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        height: 100%;
        overflow-y: auto;
        transition: all 0.3s ease-in-out;
    }
    
    /* Hide text when collapsed */
    .admin-sidebar-collapsed .admin-sidebar-text {
        display: none;
    }
    
    /* Show text when expanded */
    .admin-sidebar-expanded .admin-sidebar-text {
        display: inline;
    }
    
    /* Sidebar link styling */
    .admin-sidebar-link {
        white-space: nowrap;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    /* Tooltip for collapsed mode */
    .admin-sidebar-tooltip {
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .admin-sidebar-link:hover .admin-sidebar-tooltip {
        opacity: 1;
        visibility: visible;
    }
    
    /* Custom scrollbar */
    .admin-sidebar-content::-webkit-scrollbar {
        width: 4px;
    }
    
    .admin-sidebar-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .admin-sidebar-content::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    /* Logo styling */
    .admin-sidebar-collapsed .admin-logo-text {
        display: none;
    }
    
    .admin-sidebar-expanded .admin-logo-text {
        display: block;
    }
    
    /* Pin button */
    .admin-pin-btn {
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        opacity: 0;
    }
    
    .admin-sidebar-expanded .admin-pin-btn {
        opacity: 1;
    }
    
    .admin-pin-btn:hover {
        background: #f1f5f9;
        transform: scale(1.1);
    }
    
    /* User info */
    .admin-sidebar-collapsed .admin-user-details {
        display: none;
    }
    
    .admin-sidebar-expanded .admin-user-details {
        display: block;
    }
    
    /* Badge styling for collapsed mode */
    .admin-badge {
        transition: all 0.3s ease;
    }
    
    .admin-sidebar-collapsed .admin-badge {
        display: none;
    }
    
    .admin-sidebar-expanded .admin-badge {
        display: inline-block;
    }
    
    /* Dropdown styling */
    .admin-submenu {
        margin-left: 2rem;
        border-left: 1px solid #e2e8f0;
        padding-left: 0.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .admin-submenu .admin-sidebar-link {
        padding-left: 0.75rem;
    }
    
    .admin-dropdown-icon {
        transition: transform 0.2s ease;
    }
    
    .admin-dropdown-icon.rotated {
        transform: rotate(180deg);
    }
    
    /* Active state untuk submenu items */
    .admin-submenu .admin-sidebar-link.active {
        background-color: #eff6ff;
        color: #2563eb;
    }
    
    /* Saat sidebar collapsed */
    .admin-sidebar-collapsed .admin-submenu {
        display: none !important;
    }
    
    .admin-sidebar-collapsed .admin-dropdown-icon {
        display: none;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .admin-sidebar-container {
            transform: translateX(-100%);
            z-index: 50;
        }
        
        .admin-sidebar-container.mobile-open {
            transform: translateX(0);
        }
        
        .admin-sidebar-trigger {
            display: none;
        }
        
        .admin-sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
            display: none;
        }
        
        .admin-sidebar-overlay.active {
            display: block;
        }
    }
</style>

<div class="admin-sidebar-container" id="adminSidebarContainer">
    <!-- Trigger area -->
    <div class="admin-sidebar-trigger" id="adminSidebarTrigger"></div>
    
    <!-- Pin button -->
    <div class="admin-pin-btn" id="adminPinBtn" onclick="toggleAdminSidebarPin()">
        <i class="fas fa-thumbtack"></i>
    </div>
    
    <!-- Sidebar Content -->
    <div class="admin-sidebar-content">
        <div class="p-4">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-2 shadow-lg">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 admin-logo-text">Admin Panel</h2>
                <p class="text-xs text-gray-500 admin-logo-text">LaporinAja</p>
            </div>
            
            <!-- Mobile close button -->
            <div class="flex justify-end lg:hidden mb-4">
                <button onclick="closeAdminMobileSidebar()" class="text-gray-500 hover:text-gray-700 p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="admin-sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200 group relative">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="admin-sidebar-text">Dashboard</span>
                    <span class="admin-sidebar-tooltip">Dashboard</span>
                </a>
                
                <div class="relative">
    <button type="button"
        onclick="toggleStatusDropdown()"
        class="admin-sidebar-link px-3 py-2 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200 group relative cursor-pointer"
        id="kelolaStatusToggle">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-5 h-5">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
        </svg>
        <span class="admin-sidebar-text flex-1">Kontrol Layanan</span>
        <i class="fas fa-chevron-down text-xs transition-transform duration-200 admin-dropdown-icon" id="kelolaStatusChevron"></i>
        <span class="admin-sidebar-tooltip">Kontrol Layanan</span>
    </button>
    
    <!-- Submenu -->
    <div id="kelolaStatusSubmenu" class="admin-submenu ml-7 mt-1 space-y-1 hidden">
        <a href="{{ route('admin.balas-warga') }}" 
           class="admin-sidebar-link px-3 py-2 rounded-xl text-gray-600 hover:bg-blue-50 transition-all duration-200 text-sm">
            <i class="fas fa-reply-all w-4"></i>
            <span class="admin-sidebar-text">Balas Warga</span>
        </a>
        
        <a href="{{ route('admin.operator.index') }}" 
           class="admin-sidebar-link px-3 py-2 rounded-xl text-gray-600 hover:bg-blue-50 transition-all duration-200 text-sm">
            <i class="fas fa-hard-hat w-4"></i>
            <span class="admin-sidebar-text">Kelola Operator</span>
        </a>
        
        <a href="{{ route('admin.kelola-status') }}" 
           class="admin-sidebar-link px-3 py-2 rounded-xl text-gray-600 hover:bg-blue-50 transition-all duration-200 text-sm">
            <i class="fas fa-tasks w-4"></i>
            <span class="admin-sidebar-text">Kelola Status</span>
        </a>
    </div>
</div>
                
                <!-- Kelola Relawan Dropdown -->
                <div class="relative">
                    <button type="button"
                        onclick="toggleRelawanDropdown()"
                        class="admin-sidebar-link px-3 py-2 rounded-xl text-gray-700 hover:bg-blue-50 transition-all duration-200 group relative cursor-pointer"
                        id="kelolaRelawanToggle">
                        <i class="fas fa-list w-5"></i>
                        <span class="admin-sidebar-text flex-1">Kontrol Layanan</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 admin-dropdown-icon" id="kelolaRelawanChevron"></i>
                        <span class="admin-sidebar-tooltip">Kontrol Layanan</span>
                    </button>
                    
                    <!-- Submenu -->
                    <div id="kelolaRelawanSubmenu" class="admin-submenu ml-7 mt-1 space-y-1 hidden">
                        <a href="{{ route('admin.relawan.index') }}" 
                           class="admin-sidebar-link px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.relawan.index') ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                            <i class="fas fa-hands-helping w-4"></i>
                            <span>Kelola Relawan</span>
                        </a>
                        <a href="{{ route('admin.daerah-butuh-relawan.index') }}" 
                   class="admin-sidebar-link px-3 py-2 rounded-xl {{ request()->routeIs('admin.daerah-butuh-relawan.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-blue-50' }} transition-all duration-200 group relative">
                    <i class="fas fa-map-marked-alt w-5"></i>
                    <span class="admin-sidebar-text">Daerah Butuh Relawan</span>
                        </a>
                    </div>
                </div>
                
                <!-- Kelola Daerah Butuh Relawan -->
                
                    <span class="admin-sidebar-tooltip">Daerah Butuh Relawan</span>
                </a>
            </nav>
            
            <!-- Divider -->
            <div class="border-t my-6"></div>
            
            <!-- Version Info -->
            <div class="mt-8 pt-4 border-t text-center">
                <p class="text-xs text-gray-400 admin-logo-text">Admin Panel v1.0</p>
                <p class="text-xs text-gray-400 admin-logo-text">LaporinAja &copy; 2026</p>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Overlay -->
<div class="admin-sidebar-overlay" id="adminSidebarOverlay" onclick="closeAdminMobileSidebar()"></div>

<script>
    let adminIsPinned = false;
    let adminHoverTimeout;
    let adminIsHovering = false;
    
    const adminSidebarContainer = document.getElementById('adminSidebarContainer');
    const adminPinBtn = document.getElementById('adminPinBtn');
    
    function expandAdminSidebar() {
        if (!adminIsPinned && window.innerWidth > 768) {
            clearTimeout(adminHoverTimeout);
            adminSidebarContainer.classList.remove('admin-sidebar-collapsed');
            adminSidebarContainer.classList.add('admin-sidebar-expanded');
            adminIsHovering = true;
        }
    }
    
    function collapseAdminSidebar() {
        if (!adminIsPinned && window.innerWidth > 768) {
            adminHoverTimeout = setTimeout(() => {
                if (!adminIsHovering) {
                    adminSidebarContainer.classList.remove('admin-sidebar-expanded');
                    adminSidebarContainer.classList.add('admin-sidebar-collapsed');
                }
            }, 100);
        }
        adminIsHovering = false;
    }
    
    function toggleAdminSidebarPin() {
        adminIsPinned = !adminIsPinned;
        
        if (adminIsPinned) {
            adminSidebarContainer.classList.remove('admin-sidebar-collapsed');
            adminSidebarContainer.classList.add('admin-sidebar-expanded');
            adminPinBtn.innerHTML = '<i class="fas fa-thumbtack"></i>';
            adminPinBtn.style.backgroundColor = '#3b82f6';
            adminPinBtn.style.borderColor = '#3b82f6';
            adminPinBtn.querySelector('i').style.color = 'white';
        } else {
            adminSidebarContainer.classList.remove('admin-sidebar-expanded');
            adminSidebarContainer.classList.add('admin-sidebar-collapsed');
            adminPinBtn.innerHTML = '<i class="fas fa-thumbtack"></i>';
            adminPinBtn.style.backgroundColor = 'white';
            adminPinBtn.style.borderColor = '#e2e8f0';
            adminPinBtn.querySelector('i').style.color = '#64748b';
        }
    }
    
    function toggleStatusDropdown() {
        const submenu = document.getElementById('kelolaStatusSubmenu');
        const icon = document.getElementById('kelolaStatusChevron');
        
        if (!submenu || !icon) return;
        
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotated');
        
        // Close other dropdowns if needed
        const allDropdowns = document.querySelectorAll('.relative .admin-submenu');
        allDropdowns.forEach(dropdown => {
            if (dropdown !== submenu && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                const otherIcon = dropdown.closest('.relative').querySelector('.admin-dropdown-icon');
                if (otherIcon) otherIcon.classList.remove('rotated');
            }
        });
    }
    
    function toggleRelawanDropdown() {
        const submenu = document.getElementById('kelolaRelawanSubmenu');
        const icon = document.getElementById('kelolaRelawanChevron');
        
        if (!submenu || !icon) return;
        
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotated');
        
        // Close other dropdowns if needed
        const allDropdowns = document.querySelectorAll('.relative .admin-submenu');
        allDropdowns.forEach(dropdown => {
            if (dropdown !== submenu && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                const otherIcon = dropdown.closest('.relative').querySelector('.admin-dropdown-icon');
                if (otherIcon) otherIcon.classList.remove('rotated');
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial sidebar state
        if (window.innerWidth > 768) {
            adminSidebarContainer.classList.add('admin-sidebar-collapsed');
        }
        
        // Setup trigger area
        const triggerArea = document.querySelector('.admin-sidebar-trigger');
        if (triggerArea) {
            triggerArea.addEventListener('mouseenter', expandAdminSidebar);
        }
        
        // Setup sidebar hover events
        adminSidebarContainer.addEventListener('mouseenter', function() {
            adminIsHovering = true;
            if (window.innerWidth > 768) expandAdminSidebar();
        });
        
        adminSidebarContainer.addEventListener('mouseleave', function() {
            adminIsHovering = false;
            if (window.innerWidth > 768) collapseAdminSidebar();
        });
        
        // Keep dropdown open based on active route
        const currentUrl = window.location.href;
        const dropdowns = document.querySelectorAll('.relative');
        
        dropdowns.forEach(dropdown => {
            const submenu = dropdown.querySelector('.admin-submenu');
            if (submenu) {
                const links = submenu.querySelectorAll('a');
                let isActive = false;
                
                links.forEach(link => {
                    if (link.href === currentUrl) {
                        isActive = true;
                        link.classList.add('active');
                    }
                });
                
                if (isActive) {
                    submenu.classList.remove('hidden');
                    const icon = dropdown.querySelector('.admin-dropdown-icon');
                    if (icon) icon.classList.add('rotated');
                }
            }
        });
    });
    
    function openAdminMobileSidebar() {
        adminSidebarContainer.classList.add('mobile-open');
        document.getElementById('adminSidebarOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeAdminMobileSidebar() {
        adminSidebarContainer.classList.remove('mobile-open');
        document.getElementById('adminSidebarOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeAdminMobileSidebar();
            if (!adminIsPinned) {
                adminSidebarContainer.classList.add('admin-sidebar-collapsed');
                adminSidebarContainer.classList.remove('admin-sidebar-expanded');
            }
        }
    });
</script>