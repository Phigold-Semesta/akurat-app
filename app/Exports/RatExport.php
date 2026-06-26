<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RatExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return DB::table('rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->select('koperasi.nama_koperasi', 'rat.tahun_buku', 'rat.tgl_rat', 'rat.status_verifikasi')
            ->get();
    }

    public function headings(): array
    {
        return [
            ["LAPORAN RAPAT ANGGOTA TAHUNAN (RAT) KOPERASI"], 
            ["Nama Koperasi", "Tahun Buku", "Tanggal RAT", "Status"]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Mengatur tinggi baris judul agar tidak terlihat sempit
        $sheet->getRowDimension(1)->setRowHeight(30);
        
        // 2. Merge dan Styling Judul Utama
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. Styling Header Tabel (Baris ke-2)
        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'], // Emerald 600
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // 4. Memberikan Border pada seluruh data tabel
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A2:D' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}