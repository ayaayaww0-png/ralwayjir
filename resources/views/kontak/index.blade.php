@extends('layouts.app')

@section('title', 'Daftar Kontak')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="color: #0f2b4a; font-size: 22px; margin-bottom: 4px;">just call me 📞</h1>
            <p style="color: #6b7a8f; font-size: 14px;">Data kontak siswa/siswi.</p>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="background: #f1f4f9;">
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">No</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Nama</th>
                    <th style="padding: 12px 15px; text-align: left; border-bottom: 2px solid #dce3ed;">Nomor Telepon</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kontaks as $index => $kontak)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 10px 15px; font-weight: 500;">{{ $kontak['nama'] }}</td>
                        <td style="padding: 10px 15px;">
                            <a href="tel:{{ str_replace('-', '', $kontak['telepon']) }}" 
                               style="color: #1a4a7a; text-decoration: none;">
                                {{ $kontak['telepon'] }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 40px; text-align: center; color: #6b7a8f;">
                            📭 Tidak ada data kontak.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 15px; color: #6b7a8f; font-size: 14px;">
        Total Kontak: {{ count($kontaks) }}
    </div>
@endsection