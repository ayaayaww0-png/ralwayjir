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

class KIBcExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    /**
     * @return Enumerable
     */
    public function collection(): Enumerable
    {
        $kategori = Kategori::where('nama_kategori', 'KIB C (Gedung & Bangunan)')->first();
        $barangs = Barang::where('id_kategori', $kategori->id_kategori ?? 0)
            ->with('kibCGedung')
            ->get();

        $data = [];
        $no = 1;
        $totalHarga = 0;

        foreach ($barangs as $barang) {
            $gedung = $barang->kibCGedung;
            $totalHarga += $barang->harga;

            $data[] = [
                $no++,
                $barang->kode_barang,
                $barang->nama_barang,
                $gedung->register ?? '-',
                $gedung->kondisi_bangunan ?? '-',
                $gedung->bertingkat ?? '-',
                $gedung->beton ?? '-',
                $gedung->luas_lantai ?? 0,
                $gedung->tahun_pembangunan ?? '-',
                $gedung->lokasi_alamat ?? '-',
                $gedung->tanggal_dokumen ?? '-',
                $gedung->nomor_dokumen ?? '-',
                $gedung->luas_tanah ?? 0,
                $gedung->status_tanah ?? '-',
                $gedung->kode_tanah ?? '-',
                $gedung->asal_usul ?? '-',
                $barang->harga,
            ];
        }

        // Baris total
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'TOTAL', $totalHarga];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NO',
            'KODE BARANG',
            'NAMA GEDUNG',
            'REGISTER',
            'KONDISI',
            'BERTINGKAT',
            'BETON',
            'LUAS LANTAI (M2)',
            'TAHUN',
            'LOKASI',
            'TGL DOKUMEN',
            'NO DOKUMEN',
            'LUAS TANAH (M2)',
            'STATUS TANAH',
            'KODE TANAH',
            'ASAL USUL',
            'HARGA (Rp)',
        ];
    }

    public function title(): string
    {
        return 'KIB C - Gedung & Bangunan';
    }

    public function styles(Worksheet $sheet): ?array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}