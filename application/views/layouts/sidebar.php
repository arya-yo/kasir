<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Aplikasi Kasir</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: width 0.3s ease-in-out, margin-left 0.3s ease-in-out;
            overflow-x: hidden;
            overflow-y: auto;
            touch-action: none;
        }
        
        .sidebar.collapsed {
            width: 0;
            margin-left: -280px;
        }
        
        .sidebar.hidden {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar-header {
            padding: 20px;
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .sidebar-toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s;
            padding: 0;
            width: auto;
            height: auto;
        }
        
        .sidebar-toggle-btn:hover {
            opacity: 1;
        }
        
        .collapse-btn {
            position: fixed;
            top: 20px;
            left: 10px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .collapse-btn:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        
        .collapse-btn.visible {
            display: flex;
        }
        
        .sidebar-menu {
            padding: 20px 0;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 5px;
        }
        
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        .sidebar-menu .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none !important;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar-menu .nav-link i {
            width: 20px;
            margin-right: 10px;
            flex-shrink: 0;
        }
        
        /* Submenu Styles */
        .sidebar-menu .menu-item {
            position: relative;
        }

        .sidebar-menu .menu-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-decoration: none !important;
        }

        .sidebar-menu .menu-toggle::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            transition: transform 0.3s ease;
            margin-left: auto;
            flex-shrink: 0;
        }

        .sidebar-menu .menu-toggle.active::after {
            transform: rotate(-180deg);
        }

        .sidebar-menu .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.4s ease;
            opacity: 0;
        }

        .sidebar-menu .submenu.active {
            max-height: 500px;
            opacity: 1;
        }

        .sidebar-menu .submenu-item {
            color: rgba(255,255,255,0.75);
            padding: 8px 20px 8px 50px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            margin: 2px 0;
            font-size: 0.9rem;
            text-decoration: none !important;
        }

        .sidebar-menu .submenu-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid rgba(255,255,255,0.5);
        }

        .sidebar-menu .submenu-item.active {
            background-color: rgba(255,255,255,0.15);
            color: white;
            border-left: 3px solid white;
        }

        .sidebar-menu .submenu-item i {
            width: 16px;
            margin-right: 10px;
            flex-shrink: 0;
            font-size: 13px;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out, padding-left 0.3s ease-in-out;
        }
        
        .main-content.collapsed {
            margin-left: 0;
            padding-left: 70px;
        }
        
        .main-content.sidebar-hidden {
            margin-left: 0;
        }
        
        .hamburger-btn {
            background: none;
            border: none;
            color: #667eea;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .hamburger-btn:hover {
            background-color: rgba(102, 126, 234, 0.1);
            color: #764ba2;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .content-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .badge-role {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        
        .badge-admin {
            background-color: #dc3545;
            color: white;
        }
        
        .badge-petugas {
            background-color: #28a745;
            color: white;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 992px) {
            .sidebar {
                width: 250px;
            }
            
            .sidebar.collapsed {
                margin-left: -250px;
            }
            
            .main-content {
                margin-left: 250px;
                padding: 15px;
            }
            
            .main-content.collapsed {
                margin-left: 0;
                padding-left: 70px;
            }
            
            .hamburger-btn {
                display: none;
            }
            
            .sidebar-header h4 {
                font-size: 18px;
            }
            
            .sidebar-menu .nav-link {
                padding: 10px 15px;
                margin: 3px 5px;
                font-size: 14px;
            }
            
            .content-card {
                padding: 15px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                position: fixed;
            }
            
            .sidebar.collapsed {
                margin-left: -200px;
            }
            
            .sidebar.hidden {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 12px;
            }
            
            .main-content.collapsed {
                padding-left: 65px;
            }
            
            .content-card {
                padding: 12px;
                border-radius: 8px;
            }
            
            .sidebar-header h4 {
                font-size: 16px;
            }
            
            .sidebar-menu .nav-link {
                padding: 10px 12px;
                margin: 3px 5px;
                font-size: 13px;
            }
            
            .user-info {
                gap: 5px;
                font-size: 13px;
            }
            
            .navbar {
                margin-bottom: 10px;
            }
            
            .navbar-brand {
                font-size: 16px;
            }
        }
        
        @media (max-width: 480px) {
            .sidebar {
                width: 180px;
            }
            
            .sidebar.collapsed {
                margin-left: -180px;
            }
            
            .main-content {
                padding: 8px;
            }
            
            .main-content.collapsed {
                padding-left: 60px;
            }
            
            .content-card {
                padding: 10px;
                border-radius: 6px;
            }
            
            .sidebar-header h4 {
                font-size: 14px;
            }
            
            .sidebar-menu .nav-link {
                padding: 8px 10px;
                margin: 2px 3px;
                font-size: 12px;
            }
            
            .badge-role {
                padding: 3px 6px;
                font-size: 10px;
            }
            
            .user-info {
                flex-direction: column;
                align-items: flex-end;
                gap: 3px;
                font-size: 12px;
            }
            
            .navbar-brand {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Collapse Button (Visible when sidebar is collapsed) -->
    <button class="collapse-btn" id="collapseBtn" onclick="expandSidebar()" title="Buka Sidebar">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-cash-register"></i> KASIR</h4>
            <small>Sistem Manajemen</small>
            <button class="sidebar-toggle-btn" onclick="collapseSidebar()" title="Tutup Sidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <nav class="sidebar-menu">
            <?php 
            $role = $this->session->userdata('role');
            $current_page = isset($current_page) ? $current_page : '';
            ?>
            
            <a href="<?php echo site_url('dashboard'); ?>" class="nav-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>" onclick="closeSidebar()">
                <i class="fas fa-home"></i> Dashboard
            </a>
            
            <?php if ($role == 'admin'): ?>
                <!-- Menu Master Data untuk Admin (Expandable) -->
                <div class="menu-item">
                    <a class="nav-link menu-toggle" role="button" onclick="toggleSubmenu(event)">
                        <span><i class="fas fa-database"></i> Master Data</span>
                    </a>
                    <div class="submenu">
                        <a class="submenu-item <?php echo $current_page == 'user' ? 'active' : ''; ?>" href="<?php echo site_url('user'); ?>" onclick="closeSidebar()">
                            <i class="fas fa-users"></i> Data User
                        </a>
                        <a class="submenu-item <?php echo $current_page == 'produk' ? 'active' : ''; ?>" href="<?php echo site_url('produk'); ?>" onclick="closeSidebar()">
                            <i class="fas fa-box"></i> Data Produk
                        </a>
                    </div>
                </div>
                <a href="<?php echo site_url('pelanggan'); ?>" class="nav-link <?php echo $current_page == 'pelanggan' ? 'active' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-user-friends"></i> Data Pelanggan
                </a>
                <a href="<?php echo site_url('laporan'); ?>" class="nav-link <?php echo $current_page == 'laporan' ? 'active' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-chart-bar"></i> Laporan Penjualan
                </a>
            <?php endif; ?>
            
            <?php if ($role == 'petugas'): ?>
                <a href="<?php echo site_url('penjualan'); ?>" class="nav-link <?php echo $current_page == 'penjualan' ? 'active' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-shopping-cart"></i> Transaksi Penjualan
                </a>
                <a href="<?php echo site_url('pelanggan'); ?>" class="nav-link <?php echo $current_page == 'pelanggan' ? 'active' : ''; ?>" onclick="closeSidebar()">
                    <i class="fas fa-user-friends"></i> Data Pelanggan
                </a>
            <?php endif; ?>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
                <a href="<?php echo site_url('auth/logout'); ?>" class="nav-link" onclick="closeSidebar()">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand mb-0 h1"><?php echo isset($title) ? $title : 'Dashboard'; ?></span>
                <div class="user-info">
                    <span><i class="fas fa-user"></i> <?php echo $this->session->userdata('username'); ?></span>
                    <span class="badge badge-role badge-<?php echo $role == 'admin' ? 'admin' : 'petugas'; ?>">
                        <?php echo ucfirst($role); ?>
                    </span>
                </div>
            </div>
        </nav>
        
        <!-- Content -->
        <div class="content-card">
            <?php $this->load->view($content, isset($data) ? $data : array()); ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function collapseSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            collapseBtn.classList.add('visible');
            
            // Simpan state ke localStorage
            localStorage.setItem('sidebarCollapsed', 'true');
        }
        
        function expandSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('collapsed');
            collapseBtn.classList.remove('visible');
            
            // Simpan state ke localStorage
            localStorage.setItem('sidebarCollapsed', 'false');
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('hidden');
            overlay.classList.toggle('active');
        }
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            // Hanya tutup di mobile
            if (window.innerWidth <= 992) {
                sidebar.classList.add('hidden');
                overlay.classList.remove('active');
            }
        }

        function toggleSubmenu(event) {
            event.preventDefault();
            const menuToggle = event.currentTarget;
            const submenu = menuToggle.nextElementSibling;
            
            // Tutup semua submenu lain
            document.querySelectorAll('.submenu.active').forEach(menu => {
                if (menu !== submenu) {
                    menu.classList.remove('active');
                    menu.previousElementSibling.classList.remove('active');
                }
            });
            
            // Toggle submenu saat ini
            submenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
            
            // Simpan state submenu ke localStorage
            const isActive = submenu.classList.contains('active');
            localStorage.setItem('masterDataSubmenuOpen', isActive ? 'true' : 'false');
        }
        
        // Tutup sidebar saat overlay diklik
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (window.innerWidth > 992) {
                sidebar.classList.remove('hidden');
                overlay.classList.remove('active');
            }
        });
        
        // Restore sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const isMasterOpen = localStorage.getItem('masterDataSubmenuOpen') === 'true';
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const collapseBtn = document.getElementById('collapseBtn');
            
            // Restore collapsed state
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
                collapseBtn.classList.add('visible');
            }
            
            // Restore submenu state
            if (isMasterOpen) {
                const masterMenu = document.querySelector('.menu-item');
                if (masterMenu) {
                    const menuToggle = masterMenu.querySelector('.menu-toggle');
                    const submenu = masterMenu.querySelector('.submenu');
                    if (menuToggle && submenu) {
                        submenu.classList.add('active');
                        menuToggle.classList.add('active');
                    }
                }
            }
        });
    </script>
</body>
</html>

