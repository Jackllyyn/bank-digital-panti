<?php

namespace App\Helpers;

use App\Models\IdentitasPanti;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportHeaderHelper
{
    /**
     * Mengembalikan array baris untuk header/kop surat laporan Excel
     */
    public static function getKopSuratLines(string $title): array
    {
        $identitas = IdentitasPanti::firstOrFail(); // atau first() kalau boleh null

        $lines = [];

        // Baris 1 - Nama Yayasan
        $lines[] = [
            'text' => strtoupper($identitas->nama_yayasan ?? 'YAYASAN ...'),
            'font_size' => 16,
            'bold' => true,
        ];

        // Baris 2 - Nama Panti
        $lines[] = [
            'text' => strtoupper($identitas->nama_panti ?? 'PANTI ASUHAN ...'),
            'font_size' => 14,
            'bold' => true,
        ];

        // Baris 3 - Alamat
        $lines[] = [
            'text' => $identitas->alamat ?? '',
            'font_size' => 11,
            'bold' => false,
        ];

        // Baris 4 - Kontak
        $kontak = [];
        if ($identitas->telepon) $kontak[] = "Telp: {$identitas->telepon}";
        if ($identitas->email) $kontak[] = "Email: {$identitas->email}";
        $kontakStr = implode(' | ', $kontak);

        $lines[] = [
            'text' => $kontakStr,
            'font_size' => 11,
            'bold' => false,
        ];

        // Baris kosong pemisah
        $lines[] = ['text' => '', 'font_size' => 11, 'bold' => false];

        // Baris judul laporan
        $lines[] = [
            'text' => strtoupper($title),
            'font_size' => 13,
            'bold' => true,
        ];

        // Baris kosong sebelum tabel
        $lines[] = ['text' => '', 'font_size' => 11, 'bold' => false];

        return $lines;
    }

    /**
     * Menerapkan style kop surat ke sheet Excel
     */
    public static function applyKopSuratStyle($sheet, int $lastHeaderRow, string $lastColumn = 'G')
    {
        // Merge semua baris header
        for ($row = 1; $row <= $lastHeaderRow; $row++) {
            $sheet->mergeCells("A{$row}:{$lastColumn}{$row}");
        }

        // Center alignment
        $sheet->getStyle("A1:{$lastColumn}{$lastHeaderRow}")
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER)
              ->setVertical(Alignment::VERTICAL_CENTER);

        // Set row height biar rapi
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(20);
        $sheet->getRowDimension(6)->setRowHeight(25); // judul laporan

        // Styling font per baris
        $lines = self::getKopSuratLines(''); // hanya untuk ambil config
        $currentRow = 1;
        foreach ($lines as $line) {
            $style = [
                'font' => [
                    'bold' => $line['bold'],
                    'size' => $line['font_size'],
                ],
            ];
            $sheet->getStyle("A{$currentRow}")->applyFromArray($style);
            $currentRow++;
        }

        // Garis tebal pemisah bawah kop surat
        $sheet->getStyle("A{$lastHeaderRow}:{$lastColumn}{$lastHeaderRow}")
              ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
    }
}