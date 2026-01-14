<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Aplikasi Kasir</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90' fill='%233b82f6'><tspan>₪</tspan></text></svg>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#2563eb',
                    },
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-out',
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'scale-in': 'scaleIn 0.2s ease-out',
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        },
                        slideOut: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    
    <style>
        .sidebar-menu::-webkit-scrollbar { width: 6px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 3px; }
        .sidebar-menu::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.5); }
        .menu-toggle::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        .menu-toggle.active::after { transform: rotate(-180deg); }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar Overlay -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-[999] transition-opacity duration-300" id="sidebarOverlay"></div>
    
    <!-- Collapse Button -->
    <button class="hidden fixed top-5 left-2.5 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 text-white text-2xl rounded-lg z-[999] items-center justify-center shadow-lg hover:translate-x-1 hover:shadow-xl transition-all duration-300" id="collapseBtn" onclick="expandSidebar()" title="Buka Sidebar">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="fixed top-0 left-0 h-screen w-[280px] bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg z-[1000] transition-all duration-300 ease-in-out overflow-hidden" id="sidebar">
        <?php 
        $role = $this->session->userdata('role');
        $current_page = isset($current_page) ? $current_page : '';
        ?>
        <div class="p-5 text-white border-b border-white/10 relative">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h4 class="m-0 font-semibold text-xl animate-fade-in"><i class="fas fa-cash-register"></i> KASIR</h4>
                    <small class="text-white/80 text-xs">Sistem Manajemen</small>
                </div>
                <button class="bg-transparent border-none text-white text-xl cursor-pointer opacity-80 hover:opacity-100 transition-opacity duration-300" onclick="collapseSidebar()" title="Tutup Sidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <div class="pt-3 border-t border-white/10 mt-3">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium truncate"><?php echo $this->session->userdata('username'); ?></div>
                        <div class="text-xs text-white/70"><?php echo ucfirst($role); ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="py-5 max-h-[calc(100vh-120px)] overflow-y-auto overflow-x-hidden pr-1">
            
            <a href="<?php echo site_url('dashboard'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 border-l-4 border-transparent <?php echo $current_page == 'dashboard' ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : ''; ?>" onclick="closeSidebar()">
                <i class="fas fa-home w-5 mr-2.5 flex-shrink-0"></i> Dashboard
            </a>
            
            <?php if ($role == 'admin'): ?>
                <div class="relative">
                    <a class="flex items-center justify-between text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 cursor-pointer menu-toggle" role="button" onclick="toggleSubmenu(event)">
                        <span class="flex items-center"><i class="fas fa-database w-5 mr-2.5 flex-shrink-0"></i> Master Data</span>
                    </a>
                    <div class="max-h-0 overflow-hidden transition-all duration-400 opacity-0 submenu">
                        <a class="flex items-center text-white/75 py-2 px-5 pl-12 my-0.5 text-sm transition-all duration-300 border-l-3 border-transparent hover:bg-white/10 hover:text-white hover:border-white/50 hover:shadow-md hover:scale-105 hover:-translate-y-0.5 <?php echo $current_page == 'user' ? 'bg-white/20 text-white shadow-md border-white' : ''; ?>" href="<?php echo site_url('user'); ?>" onclick="closeSidebar()">
                            <i class="fas fa-users w-4 mr-2.5 flex-shrink-0 text-xs"></i> Data User
                        </a>
                        <a class="flex items-center text-white/75 py-2 px-5 pl-12 my-0.5 text-sm transition-all duration-300 border-l-3 border-transparent hover:bg-white/10 hover:text-white hover:border-white/50 hover:shadow-md hover:scale-105 hover:-translate-y-0.5 <?php echo $current_page == 'produk' ? 'bg-white/20 text-white shadow-md border-white' : ''; ?>" href="<?php echo site_url('produk'); ?>" onclick="closeSidebar()">
                            <i class="fas fa-box w-4 mr-2.5 flex-shrink-0 text-xs"></i> Data Produk
                        </a>
                    </div>
                </div>
                <a href="<?php echo site_url('pelanggan'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 border-l-4 border-transparent <?php echo $current_page == 'pelanggan' ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-user-friends w-5 mr-2.5 flex-shrink-0"></i> Riwayat Data Pelanggan
                </a>
                <a href="<?php echo site_url('laporan'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 border-l-4 border-transparent <?php echo $current_page == 'laporan' ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-chart-bar w-5 mr-2.5 flex-shrink-0"></i> Laporan Penjualan
                </a>
            <?php endif; ?>
            
            <?php if ($role == 'petugas'): ?>
                <a href="<?php echo site_url('penjualan'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 border-l-4 border-transparent <?php echo $current_page == 'penjualan' ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-shopping-cart w-5 mr-2.5 flex-shrink-0"></i> Transaksi Penjualan
                </a>
                <a href="<?php echo site_url('pelanggan'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1 border-l-4 border-transparent <?php echo $current_page == 'pelanggan' ? 'bg-white/20 text-white shadow-lg border-l-4 border-white' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-user-friends w-5 mr-2.5 flex-shrink-0"></i> Riwayat Data Pelanggan
                </a>
            <?php endif; ?>
            
            <div class="mt-8 pt-5 border-t border-white/10 mb-5">
                <a href="<?php echo site_url('auth/logout'); ?>" class="flex items-center text-white/80 py-3 px-5 mx-2.5 my-1.5 rounded-lg transition-all duration-300 hover:bg-white/10 hover:text-white hover:shadow-lg hover:scale-105 hover:-translate-y-1" onclick="closeSidebar()">
                    <i class="fas fa-sign-out-alt w-5 mr-2.5 flex-shrink-0"></i> Logout
                </a>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="ml-[280px] p-5 transition-all duration-300 ease-in-out animate-fade-in" id="mainContent">
        <!-- Hamburger Button for Mobile -->
                <button class="lg:hidden fixed top-5 right-5 z-50 text-blue-600 text-2xl p-2 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-300 bg-white shadow-md" id="hamburgerBtn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Content -->
        <div class="bg-white rounded-lg p-6 shadow-sm animate-scale-in">
            <?php $this->load->view($content, isset($data) ? $data : array()); ?>
        </div>
    </div>
    
    <script>
        function collapseSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            sidebar.classList.add('-translate-x-full');
            sidebar.style.width = '0';
            mainContent.classList.remove('ml-[280px]');
            mainContent.classList.add('ml-0', 'pl-[70px]');
            collapseBtn.classList.remove('hidden');
            
            localStorage.setItem('sidebarCollapsed', 'true');
        }
        
        function expandSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            sidebar.classList.remove('-translate-x-full');
            sidebar.style.width = '280px';
            mainContent.classList.remove('ml-0', 'pl-[70px]');
            mainContent.classList.add('ml-[280px]');
            collapseBtn.classList.add('hidden');
            
            localStorage.setItem('sidebarCollapsed', 'false');
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        function closeSidebar() {
            if (window.innerWidth <= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        function toggleSubmenu(event) {
            event.preventDefault();
            const menuToggle = event.currentTarget;
            const submenu = menuToggle.nextElementSibling;
            
            document.querySelectorAll('.submenu.active').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('active', 'max-h-[500px]', 'opacity-100');
                    menu.previousElementSibling.classList.remove('active');
                }
            });
            
            submenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
            if (submenu.classList.contains('active')) {
                submenu.classList.add('max-h-[500px]', 'opacity-100');
            } else {
                submenu.classList.remove('max-h-[500px]', 'opacity-100');
            }
            
            localStorage.setItem('masterDataSubmenuOpen', submenu.classList.contains('active') ? 'true' : 'false');
        }
        
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);
        
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const isMasterOpen = localStorage.getItem('masterDataSubmenuOpen') === 'true';
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            if (isCollapsed) {
                sidebar.classList.add('-translate-x-full');
                sidebar.style.width = '0';
                mainContent.classList.remove('ml-[280px]');
                mainContent.classList.add('ml-0', 'pl-[70px]');
                collapseBtn.classList.remove('hidden');
            }
            
            if (isMasterOpen) {
                const masterMenu = document.querySelector('.menu-toggle');
                if (masterMenu) {
                    const submenu = masterMenu.nextElementSibling;
                    if (submenu) {
                        submenu.classList.add('active', 'max-h-[500px]', 'opacity-100');
                        masterMenu.classList.add('active');
                    }
                }
            }
        });
    </script>
</body>
</html>

