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

class KIBbExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    /**
     * @return Enumerable
     */
    public function collection(): Enumerable
    {
        $kategori = Kategori::where('nama_kategori', 'KIB B (Peralatan & Mesin)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)
            ->with('inventarisRuangan.ruangan')
            ->get();

        $data = [];
        $no = 1;
        $totalNilai = 0;

        foreach ($barangs as $barang) {
            if ($barang->inventarisRuangan->count() > 0) {
                foreach ($barang->inventarisRuangan as $inv) {
                    $total = $inv->stok_baik + $inv->stok_rusak + $inv->stok_hilang;
                    $nilai = $barang->harga * $total;
                    $totalNilai += $nilai;

                    $data[] = [
                        $no++,
                        $barang->kode_barang,
                        $barang->nama_barang,
                        $barang->merk ?? '-',
                        $barang->no_seri ?? '-',
                        $inv->ruangan->nama_ruangan ?? '-',
                        $inv->stok_baik,
                        $inv->stok_rusak,
                        $inv->stok_hilang,
                        $total,
                        $barang->harga,
                        $nilai,
                    ];
                }
            } else {
                $data[] = [
                    $no++,
                    $barang->kode_barang,
                    $barang->nama_barang,
                    $barang->merk ?? '-',
                    $barang->no_seri ?? '-',
                    '-',
                    0,
                    0,
                    0,
                    0,
                    $barang->harga,
                    0,
                ];
            }
        }

        // Baris total
        $data[] = ['', '', '', '', '', '', '', '', '', '', 'TOTAL', $totalNilai];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE BARANG',
            'NAMA BARANG',
            'MERK',
            'NO. SERI',
            'RUANGAN',
            'BAIK',
            'RUSAK',
            'HILANG',
            'TOTAL',
            'HARGA (Rp)',
            'TOTAL NILAI (Rp)',
        ];
    }

    public function title(): string
    {
        return 'KIB B - Peralatan & Mesin';
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}