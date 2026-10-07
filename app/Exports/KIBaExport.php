<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Enumerable;

class KIBaExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection(): Enumerable
    {
        $kategori = Kategori::where('nama_kategori', 'KIB A (Tanah)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)->get();

        $data = [];
        $no = 1;
        $totalHarga = 0;

        foreach ($barangs as $barang) {
            $totalHarga += $barang->harga;
            $data[] = [
                $no++,
                $barang->kode_barang,
                $barang->nama_barang,
                $barang->register ?? '-',
                $barang->luas ?? 0,
                $barang->tahun ?? '-',
                $barang->lokasi ?? '-',
                $barang->status_tanah ?? '-',
                $barang->kode_tanah ?? '-',
                $barang->asal_usul ?? '-',
                $barang->harga,
            ];
        }

        $data[] = ['', '', '', '', '', '', '', '', '', 'TOTAL', $totalHarga];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NO', 'KODE BARANG', 'NAMA TANAH', 'REGISTER', 'LUAS (M2)',
            'TAHUN', 'LOKASI', 'STATUS TANAH', 'KODE TANAH', 'ASAL USUL', 'HARGA (Rp)',
        ];
    }

    public function title(): string
    {
        return 'KIB A - Tanah';
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}