<?php

// app/Exports/LaporanExport.php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
     protected $bookings;
     protected $totalPendapatan;

     public function __construct($bookings, $totalPendapatan)
     {
          $this->bookings = $bookings;
          $this->totalPendapatan = $totalPendapatan;
     }

     public function collection()
     {
          return $this->bookings;
     }

     public function headings(): array
     {
          return [
               'No',
               'Tanggal Booking',
               'Customer',
               'Email',
               'No. Telepon',
               'Studio',
               'Lokasi',
               'Jam',
               'Durasi (Jam)',
               'Total Harga',
               'Terbayar',
               'Status'
          ];
     }

     public function map($booking): array
     {
          static $no = 0;
          $no++;

          $totalBayar = $booking->payments()
               ->where('status_pembayaran', 'terverifikasi')
               ->sum('jumlah_bayar');

          return [
               $no,
               \Carbon\Carbon::parse($booking->tanggal_booking)->format('d-m-Y'),
               $booking->user->name,
               $booking->user->email,
               $booking->user->no_telepon ?? '-',
               $booking->studio->nama_studio,
               $booking->studio->lokasi,
               $booking->jam_mulai . ' - ' . $booking->jam_selesai,
               $booking->durasi_jam,
               'Rp ' . number_format($booking->total_harga, 0, ',', '.'),
               'Rp ' . number_format($totalBayar, 0, ',', '.'),
               ucfirst($booking->status_booking)
          ];
     }

     public function styles(Worksheet $sheet)
     {
          // Style header
          $sheet->getStyle('A1:L1')->applyFromArray([
               'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
               ],
               'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0D9488'] // Teal color
               ],
               'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
               ],
               'borders' => [
                    'allBorders' => [
                         'borderStyle' => Border::BORDER_THIN
                    ]
               ]
          ]);

          // Auto width columns
          foreach (range('A', 'L') as $col) {
               $sheet->getColumnDimension($col)->setAutoSize(true);
          }

          // Border untuk semua data
          $highestRow = $sheet->getHighestRow();
          $sheet->getStyle('A1:L' . $highestRow)->applyFromArray([
               'borders' => [
                    'allBorders' => [
                         'borderStyle' => Border::BORDER_THIN,
                         'color' => ['rgb' => 'CCCCCC']
                    ]
               ]
          ]);

          // Tambahkan row total
          $totalRow = $highestRow + 2;
          $sheet->setCellValue('I' . $totalRow, 'TOTAL PENDAPATAN:');
          $sheet->setCellValue('J' . $totalRow, 'Rp ' . number_format($this->totalPendapatan, 0, ',', '.'));

          $sheet->getStyle('I' . $totalRow . ':J' . $totalRow)->applyFromArray([
               'font' => ['bold' => true],
               'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFEDD5'] // Orange light
               ]
          ]);

          return [];
     }

     public function title(): string
     {
          return 'Laporan Booking';
     }
}
