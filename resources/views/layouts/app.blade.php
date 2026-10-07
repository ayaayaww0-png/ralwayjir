<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Inventaris SMKN 2 Padang Panjang')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f7ff;
            min-height: 100vh;
        }

        /* ===== SIDEBAR STYLES - SOLID SOFT BLUE ===== */
        .sidebar {
            width: 270px;
            background: #dbeafe;
            color: #1e3a5f;
            min-height: 100vh;
            padding: 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1040;
            box-shadow: 4px 0 20px rgba(59, 130, 246, 0.08);
            border-right: 1px solid rgba(147, 197, 253, 0.3);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(191, 219, 254, 0.3);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }

        /* ===== DECORATIVE PATTERN ===== */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%233b82f6' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ===== BRAND ===== */
        .sidebar .brand {
            padding: 28px 20px 20px;
            border-bottom: 1px solid rgba(147, 197, 253, 0.3);
            margin-bottom: 8px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .sidebar .brand .logo-wrapper {
            display: inline-block;
            padding: 4px;
            background: #bfdbfe;
            border-radius: 50%;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
            transition: all 0.3s ease;
        }

        .sidebar .brand .logo-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
        }

        .sidebar .brand .logo {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            background: white;
        }

        .sidebar .brand h2 {
            font-size: 20px;
            font-weight: 800;
            color: #1e3a5f;
            margin-bottom: 2px;
            letter-spacing: 0.3px;
        }

        .sidebar .brand span {
            font-size: 12px;
            color: #3b82f6;
            display: block;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        /* ===== MENU LABEL ===== */
        .sidebar .menu-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #3b82f6;
            padding: 12px 24px 6px;
            letter-spacing: 1px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .sidebar .menu-label i {
            color: #60a5fa;
        }

        /* ===== MENU ITEMS - WITH BOX ===== */
        .sidebar .menu-item {
            display: flex;
            align-items: center;
            padding: 11px 20px;
            margin: 4px 12px;
            background: #bfdbfe;
            color: #1e3a5f;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 10px;
            border: 1px solid rgba(147, 197, 253, 0.3);
            position: relative;
            z-index: 1;
            box-shadow: 0 1px 3px rgba(59, 130, 246, 0.05);
        }

        .sidebar .menu-item:hover {
            background: #93c5fd;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
            border-color: #60a5fa;
        }

        .sidebar .menu-item.active {
            background: #93c5fd;
            border-color: #60a5fa;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.15);
            border-left: 3px solid #3b82f6;
        }

        .sidebar .menu-item .icon {
            margin-right: 14px;
            font-size: 17px;
            width: 24px;
            text-align: center;
            color: #3b82f6;
            transition: all 0.3s ease;
        }

        .sidebar .menu-item:hover .icon {
            color: #1e3a5f;
            transform: scale(1.1);
        }

        .sidebar .menu-item.active .icon {
            color: #1e3a5f;
        }

        .sidebar .menu-item .badge-menu {
            margin-left: auto;
            background: #60a5fa;
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            color: white;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.2);
        }

        /* ===== NAVBAR DROPDOWN (untuk BARANG) ===== */
        .nav-item.dropdown .dropdown-menu {
            background: #dbeafe !important;
            border: 1px solid rgba(147, 197, 253, 0.3) !important;
            border-radius: 10px !important;
            padding: 8px 0 !important;
            margin-left: 12px !important;
            min-width: 200px !important;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1) !important;
        }

        .nav-item.dropdown .dropdown-menu .dropdown-item {
            padding: 8px 20px !important;
            color: #1e3a5f !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }

        .nav-item.dropdown .dropdown-menu .dropdown-item:hover {
            background: #93c5fd !important;
            transform: translateX(4px) !important;
        }

        .nav-item.dropdown .dropdown-menu .dropdown-item .icon {
            margin-right: 10px !important;
            font-size: 16px !important;
            color: #3b82f6 !important;
        }

        .nav-item.dropdown .dropdown-menu .dropdown-item:hover .icon {
            color: #1e3a5f !important;
        }

        .nav-item.dropdown .dropdown-toggle::after {
            margin-left: 8px !important;
            vertical-align: middle !important;
        }

        /* ===== LOGOUT - PINK BOX ===== */
        .sidebar .menu-item.logout {
            margin-top: 8px;
            background: #fce4ec;
            border-color: #f8bbd0;
            color: #c62828;
        }

        .sidebar .menu-item.logout .icon {
            color: #ef5350;
        }

        .sidebar .menu-item.logout:hover {
            background: #f8bbd0;
            border-color: #ef5350;
            color: #b71c1c;
            box-shadow: 0 4px 12px rgba(239, 83, 80, 0.2);
        }

        .sidebar .menu-item.logout:hover .icon {
            color: #c62828;
        }

        .sidebar .menu-item.logout .badge-menu {
            background: #ef5350;
            box-shadow: 0 2px 8px rgba(239, 83, 80, 0.3);
        }

        /* ===== SIDEBAR FOOTER ===== */
        .sidebar-footer {
            padding: 16px 24px;
            margin-top: auto;
            border-top: 1px solid rgba(147, 197, 253, 0.2);
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .sidebar-footer .version {
            font-size: 11px;
            color: #60a5fa;
            margin: 0;
            font-weight: 500;
        }

        .sidebar-footer .version i {
            color: #3b82f6;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            flex: 1;
            padding: 24px 32px 32px;
            min-height: 100vh;
            background: #f0f7ff;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: white;
            padding: 16px 28px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
            border: 1px solid rgba(147, 197, 253, 0.15);
        }

        .navbar-custom .greeting h1 {
            font-size: 22px;
            color: #1e3a5f;
            font-weight: 700;
        }

        .navbar-custom .greeting h1 i {
            color: #3b82f6;
        }

        .navbar-custom .greeting p {
            font-size: 14px;
            color: #60a5fa;
            margin-top: 2px;
        }

        .navbar-custom .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-custom .user-info .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #93c5fd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }

        .navbar-custom .user-info .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
        }

        .navbar-custom .user-info .user-detail {
            text-align: right;
        }

        .navbar-custom .user-info .user-detail .name {
            font-weight: 600;
            color: #1e3a5f;
            font-size: 15px;
        }

        .navbar-custom .user-info .user-detail .role {
            font-size: 12px;
            color: #60a5fa;
        }

        /* ===== BADGE ROLE ===== */
        .badge-role {
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-admin {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-guru {
            background: #fef3c7;
            color: #b45309;
        }

        .badge-kepsek {
            background: #dbeafe;
            color: #1e40af;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            background: white;
            padding: 28px 32px;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(59, 130, 246, 0.06);
            border: 1px solid rgba(147, 197, 253, 0.15);
        }

        /* ===== SIDEBAR TOGGLE ===== */
        .sidebar-toggle {
            display: none;
            background: white;
            color: #1e3a5f;
            border: 1px solid rgba(147, 197, 253, 0.3);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.06);
        }

        .sidebar-toggle:hover {
            background: #dbeafe;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .sidebar-toggle i {
            color: #3b82f6;
        }

        /* ===== OVERLAY ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 58, 95, 0.3);
            z-index: 1039;
            backdrop-filter: blur(3px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px 20px 24px;
            }

            .navbar-custom {
                flex-direction: column;
                align-items: stretch;
                padding: 16px 20px;
            }

            .navbar-custom .user-info {
                justify-content: flex-end;
            }

            .sidebar-toggle {
                display: inline-block;
            }

            .page-content {
                padding: 20px 16px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 12px 12px 20px;
            }

            .navbar-custom .greeting h1 {
                font-size: 18px;
            }

            .page-content {
                padding: 16px 12px;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-content {
            animation: fadeInUp 0.5s ease;
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR OVERLAY ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar" id="sidebar">

        <div class="brand">
            <div class="logo-wrapper">
                <img class="logo" src="{{ asset('images/logo-sekolah.png') }}" alt="Logo SMKN 2">
            </div>
            <h2>SMKN 2</h2>
            <span><i class="fas fa-boxes me-1"></i> Sistem Inventaris Barang Sekolah</span>
        </div>

        {{-- MENU UTAMA --}}
        <div class="menu-label"><i class="fas fa-th-large me-2"></i> Dashboard</div>
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-th-large"></i></span> Dashboard
            <span class="badge-menu">Main</span>
        </a>

        {{-- ========================================= --}}
        {{-- ===== ADMIN (FULL AKSES) ===== --}}
        {{-- ========================================= --}}
        @if(Auth::user()->role == 'admin')
            <div class="menu-label"><i class="fas fa-database me-2"></i> Master Data</div>
            <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-tags"></i></span> Kategori
            </a>
            <a href="{{ route('supplier.index') }}" class="menu-item {{ request()->routeIs('supplier*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-store"></i></span> Supplier
            </a>
            <a href="{{ route('ruangan.index') }}" class="menu-item {{ request()->routeIs('ruangan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-building"></i></span> Ruangan
            </a>

            {{-- ===== MENU BARANG DROPDOWN ===== --}}
            <div class="menu-label"><i class="fas fa-boxes me-2"></i> Barang</div>
            <div class="nav-item dropdown" style="padding: 0 12px;">
                <a class="nav-link dropdown-toggle menu-item" href="#" id="barangDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: #bfdbfe; border: 1px solid rgba(147,197,253,0.3); border-radius: 10px; padding: 11px 20px; color: #1e3a5f; font-weight: 500; display: flex; align-items: center; text-decoration: none;">
                    <span class="icon"><i class="fas fa-boxes"></i></span> BARANG
                </a>
                <ul class="dropdown-menu" aria-labelledby="barangDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_a.index') }}">
                            <span class="icon"><i class="fas fa-mountain"></i></span> KIB A (Tanah)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_b.index') }}">
                            <span class="icon"><i class="fas fa-laptop"></i></span> KIB B (Peralatan & Mesin)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_c.index') }}">
                            <span class="icon"><i class="fas fa-building"></i></span> KIB C (Gedung & Bangunan)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('barang-habis-pakai.index') }}">
                            <span class="icon"><i class="fas fa-box-open"></i></span> Barang Habis Pakai
                        </a>
                    </li>
                </ul>
            </div>

            <div class="menu-label"><i class="fas fa-exchange-alt me-2"></i> Inventaris & Transaksi</div>
            <a href="{{ route('inventaris.index') }}" class="menu-item {{ request()->routeIs('inventaris*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span> KONDISI
            </a>
            <a href="{{ route('barang-masuk.index') }}" class="menu-item {{ request()->routeIs('barang-masuk*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-arrow-down"></i></span> Barang Masuk
                <span class="badge-menu">+</span>
            </a>
            <a href="{{ route('barang-keluar.index') }}" class="menu-item {{ request()->routeIs('barang-keluar*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-arrow-up"></i></span> Barang Keluar
                <span class="badge-menu">-</span>
            </a>
            <a href="{{ route('mutasi-barang.index') }}" class="menu-item {{ request()->routeIs('mutasi-barang*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-exchange-alt"></i></span> Mutasi Barang
            </a>

            <div class="menu-label"><i class="fas fa-file-alt me-2"></i> Laporan</div>
            <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-file-alt"></i></span> Laporan
                <span class="badge-menu">PDF</span>
            </a>

            {{-- KONTAK --}}
            <div class="menu-label"><i class="fas fa-address-book me-2"></i> Lainnya</div>
            <a href="{{ route('kontak.index') }}" class="menu-item {{ request()->routeIs('kontak*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-address-book"></i></span> Kontak
            </a>
        @endif

        {{-- ========================================= --}}
        {{-- ===== KEPSEK ===== --}}
        {{-- ========================================= --}}
        @if(Auth::user()->role == 'kepsek')
            <div class="menu-label"><i class="fas fa-eye me-2"></i> Data Inventaris</div>
            <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-tags"></i></span> Kategori
            </a>
            <a href="{{ route('supplier.index') }}" class="menu-item {{ request()->routeIs('supplier*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-store"></i></span> Supplier
            </a>
            <a href="{{ route('ruangan.index') }}" class="menu-item {{ request()->routeIs('ruangan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-building"></i></span> Ruangan
            </a>

            {{-- ===== MENU BARANG DROPDOWN (KEPSEK) ===== --}}
            <div class="menu-label"><i class="fas fa-boxes me-2"></i> Barang</div>
            <div class="nav-item dropdown" style="padding: 0 12px;">
                <a class="nav-link dropdown-toggle menu-item" href="#" id="barangDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: #bfdbfe; border: 1px solid rgba(147,197,253,0.3); border-radius: 10px; padding: 11px 20px; color: #1e3a5f; font-weight: 500; display: flex; align-items: center; text-decoration: none;">
                    <span class="icon"><i class="fas fa-boxes"></i></span> BARANG
                </a>
                <ul class="dropdown-menu" aria-labelledby="barangDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_a.index') }}">
                            <span class="icon"><i class="fas fa-mountain"></i></span> KIB A (Tanah)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_b.index') }}">
                            <span class="icon"><i class="fas fa-laptop"></i></span> KIB B (Peralatan & Mesin)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('kib_c.index') }}">
                            <span class="icon"><i class="fas fa-building"></i></span> KIB C (Gedung & Bangunan)
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('barang-habis-pakai.index') }}">
                            <span class="icon"><i class="fas fa-box-open"></i></span> Barang Habis Pakai
                        </a>
                    </li>
                </ul>
            </div>

            <a href="{{ route('inventaris.index') }}" class="menu-item {{ request()->routeIs('inventaris*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-clipboard-list"></i></span> Inventaris
            </a>
            <a href="{{ route('barang-masuk.index') }}" class="menu-item {{ request()->routeIs('barang-masuk*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-arrow-down"></i></span> Barang Masuk
            </a>
            <a href="{{ route('barang-keluar.index') }}" class="menu-item {{ request()->routeIs('barang-keluar*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-arrow-up"></i></span> Barang Keluar
            </a>
            <a href="{{ route('mutasi-barang.index') }}" class="menu-item {{ request()->routeIs('mutasi-barang*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-exchange-alt"></i></span> Mutasi Barang
            </a>

            <div class="menu-label"><i class="fas fa-file-alt me-2"></i> Laporan</div>
            <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-file-alt"></i></span> Laporan
                <span class="badge-menu">PDF</span>
            </a>

            {{-- KONTAK --}}
            <div class="menu-label"><i class="fas fa-address-book me-2"></i> Lainnya</div>
            <a href="{{ route('kontak.index') }}" class="menu-item {{ request()->routeIs('kontak*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-address-book"></i></span> Kontak
            </a>
        @endif

        {{-- ========================================= --}}
        {{-- ===== GURU (HANYA DASHBOARD + KONTAK) ===== --}}
        {{-- ========================================= --}}
        @if(Auth::user()->role == 'guru')
            <div class="menu-label"><i class="fas fa-address-book me-2"></i> Lainnya</div>
            <a href="{{ route('kontak.index') }}" class="menu-item {{ request()->routeIs('kontak*') ? 'active' : '' }}">
                <span class="icon"><i class="fas fa-address-book"></i></span> Kontak
            </a>
        @endif

        {{-- LOGOUT - PINK BOX --}}
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0; margin-top: 8px;">
            @csrf
            <button type="submit" class="menu-item logout" style="background: #fce4ec; border: 1px solid #f8bbd0; width: calc(100% - 24px); margin: 8px 12px 0; text-align: left; cursor: pointer; font-size: 14px; font-family: inherit; padding: 11px 20px; color: #c62828; border-radius: 10px; display: flex; align-items: center;">
                <span class="icon" style="margin-right: 14px; font-size: 17px; width: 24px; text-align: center; color: #ef5350;"><i class="fas fa-sign-out-alt"></i></span>
                Logout
                <span class="badge-menu" style="margin-left: auto; background: #ef5350; padding: 2px 12px; border-radius: 12px; font-size: 10px; font-weight: 700; color: white; box-shadow: 0 2px 8px rgba(239, 83, 80, 0.3);">Exit</span>
            </button>
        </form>

        <!-- Footer Sidebar -->
        <div class="sidebar-footer">
            <p class="version">
                SMKN 2
            </p>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">

        <!-- ===== TOGGLE SIDEBAR ===== -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- ===== NAVBAR ===== -->
        <nav class="navbar-custom">
            <div class="greeting">
                <h1>
                    <i class="fas fa-wave-square"></i>
                    Halo, {{ Auth::user()->nama_lengkap ?? 'Admin' }}! 👋
                </h1>
                <p><i class="far fa-calendar-alt me-1"></i> {{ date('l, d F Y') }}</p>
            </div>
            <div class="user-info">
                <div class="user-detail">
                    <div class="name">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</div>

                    <div class="role">
                        <span class="badge-role
                            @if(Auth::user()->role == 'admin') badge-admin
                            @elseif(Auth::user()->role == 'guru') badge-guru
                            @else badge-kepsek @endif">
                            <i class="fas
                                @if(Auth::user()->role == 'admin') fa-shield-alt
                                @elseif(Auth::user()->role == 'guru') fa-chalkboard-teacher
                                @else fa-user-tie @endif me-1">
                            </i>
                            {{ strtoupper(Auth::user()->role ?? '') }}
                        </span>
                    </div>
                </div>
                <div class="avatar">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                </div>
            </div>
        </nav>

        <!-- ===== PAGE CONTENT ===== -->
        <div class="page-content">
            @yield('content')
        </div>

    </div>

    <!-- ===== BOOTSTRAP & SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                    toggleSidebar();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>

</body>
</html>