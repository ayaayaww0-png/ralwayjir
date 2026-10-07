@extends('layouts.app')

@section('title', 'Laporan - Sistem Inventaris Sekolah')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">📊 Laporan</h1>
            <p class="page-subtitle">Pilih jenis laporan yang ingin dilihat.</p>
        </div>
    </div>

    <div class="report-grid">
        {{-- Laporan Stok Barang --}}
        <a href="{{ route('laporan.stok-barang') }}" class="report-card">
            <div class="report-icon blue">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="report-content">
                <h3 class="report-title">Laporan Stok Barang</h3>
                <p class="report-desc">Lihat seluruh stok barang di sekolah</p>
                <div class="report-footer">
                    <span class="report-badge blue">PDF</span>
                    <span class="report-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </a>

        {{-- Laporan Inventaris per Ruangan --}}
        <a href="{{ route('laporan.inventaris-ruangan') }}" class="report-card">
            <div class="report-icon purple">
                <i class="fas fa-building"></i>
            </div>
            <div class="report-content">
                <h3 class="report-title">Laporan Inventaris per Ruangan</h3>
                <p class="report-desc">Lihat stok barang per ruangan & kondisi</p>
                <div class="report-footer">
                    <span class="report-badge purple">PDF</span>
                    <span class="report-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </a>

        {{-- Laporan Barang Masuk --}}
        <a href="{{ route('laporan.barang-masuk') }}" class="report-card">
            <div class="report-icon green">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="report-content">
                <h3 class="report-title">Laporan Barang Masuk</h3>
                <p class="report-desc">Lihat riwayat barang masuk dari supplier</p>
                <div class="report-footer">
                    <span class="report-badge green">PDF</span>
                    <span class="report-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </a>

        {{-- Laporan Barang Keluar --}}
        <a href="{{ route('laporan.barang-keluar') }}" class="report-card">
            <div class="report-icon red">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="report-content">
                <h3 class="report-title">Laporan Barang Keluar</h3>
                <p class="report-desc">Lihat riwayat barang keluar (rusak/hilang)</p>
                <div class="report-footer">
                    <span class="report-badge red">PDF</span>
                    <span class="report-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </a>

        {{-- Laporan Mutasi Barang --}}
        <a href="{{ route('laporan.mutasi-barang') }}" class="report-card">
            <div class="report-icon orange">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="report-content">
                <h3 class="report-title">Laporan Mutasi Barang</h3>
                <p class="report-desc">Lihat riwayat pemindahan barang antar ruangan</p>
                <div class="report-footer">
                    <span class="report-badge orange">PDF</span>
                    <span class="report-arrow"><i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </a>
    </div>

    <style>
        /* ===== PAGE HEADER ===== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(147, 197, 253, 0.2);
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e3a5f;
            margin: 0 0 4px 0;
        }

        .page-subtitle {
            color: #60a5fa;
            font-size: 14px;
            margin: 0;
            font-weight: 400;
        }

        /* ===== REPORT GRID ===== */
        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* ===== REPORT CARD ===== */
        .report-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid rgba(147, 197, 253, 0.2);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.05);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .report-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .report-card:hover::after {
            opacity: 1;
        }

        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.12);
            border-color: #93c5fd;
        }

        .report-card:hover .report-arrow {
            transform: translateX(4px);
        }

        /* ===== REPORT ICON ===== */
        .report-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .report-icon.blue { background: #dbeafe; color: #3b82f6; }
        .report-icon.purple { background: #ede9fe; color: #7c3aed; }
        .report-icon.green { background: #d1fae5; color: #059669; }
        .report-icon.red { background: #fee2e2; color: #ef4444; }
        .report-icon.orange { background: #fef3c7; color: #d97706; }

        /* ===== REPORT CONTENT ===== */
        .report-content {
            flex: 1;
            min-width: 0;
        }

        .report-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e3a5f;
            margin: 0 0 4px 0;
        }

        .report-desc {
            font-size: 13px;
            color: #60a5fa;
            margin: 0 0 8px 0;
            font-weight: 400;
            line-height: 1.4;
        }

        .report-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-badge {
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-badge.blue { background: #dbeafe; color: #1e40af; }
        .report-badge.purple { background: #ede9fe; color: #5b21b6; }
        .report-badge.green { background: #d1fae5; color: #065f46; }
        .report-badge.red { background: #fee2e2; color: #991b1b; }
        .report-badge.orange { background: #fef3c7; color: #92400e; }

        .report-arrow {
            color: #3b82f6;
            font-size: 14px;
            transition: all 0.3s ease;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f0f7ff;
        }

        .report-card:hover .report-arrow {
            background: #dbeafe;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .report-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .report-card {
                padding: 16px 20px;
            }

            .report-icon {
                width: 44px;
                height: 44px;
                font-size: 20px;
            }

            .report-title {
                font-size: 14px;
            }

            .report-desc {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .report-card {
                padding: 14px 16px;
                gap: 12px;
            }

            .report-icon {
                width: 38px;
                height: 38px;
                font-size: 16px;
                border-radius: 10px;
            }

            .report-title {
                font-size: 13px;
            }

            .report-desc {
                font-size: 11px;
            }

            .page-title {
                font-size: 18px;
            }
        }
    </style>
@endsection