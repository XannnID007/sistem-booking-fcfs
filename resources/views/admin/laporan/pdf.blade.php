<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Booking Studio Musik</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0D9488;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #0D9488;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #666;
            font-size: 16px;
            font-weight: normal;
        }

        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .info-section p {
            margin: 5px 0;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #0D9488;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        tr:hover {
            background: #e8f5f4;
        }

        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-dibayar {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-selesai {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-dibatalkan {
            background: #FEE2E2;
            color: #991B1B;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            background: #FFEDD5;
            border-left: 4px solid #F97316;
            border-radius: 5px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 12px;
        }

        .summary-total {
            font-size: 16px;
            font-weight: bold;
            color: #0D9488;
            border-top: 2px solid #F97316;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>STUDIO MUSIK BOOKING</h1>
        <h2>Laporan Booking & Pendapatan</h2>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d F Y H:i') }} WIB</p>
        @if ($filters['tanggal_dari'] || $filters['tanggal_sampai'])
            <p><strong>Periode:</strong>
                {{ $filters['tanggal_dari'] ? \Carbon\Carbon::parse($filters['tanggal_dari'])->format('d M Y') : 'Awal' }}
                s/d
                {{ $filters['tanggal_sampai'] ? \Carbon\Carbon::parse($filters['tanggal_sampai'])->format('d M Y') : 'Akhir' }}
            </p>
        @endif
        @if ($filters['status'])
            <p><strong>Status:</strong> {{ ucfirst($filters['status']) }}</p>
        @endif
        <p><strong>Total Data:</strong> {{ $bookings->count() }} booking</p>
    </div>

    <!-- Table -->
    @if ($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 10%;">Tanggal</th>
                    <th style="width: 15%;">Customer</th>
                    <th style="width: 15%;">Studio</th>
                    <th style="width: 12%;">Jam</th>
                    <th style="width: 8%;">Durasi</th>
                    <th style="width: 12%;">Total</th>
                    <th style="width: 12%;">Terbayar</th>
                    <th style="width: 11%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $index => $booking)
                    @php
                        $totalBayar = $booking
                            ->payments()
                            ->where('status_pembayaran', 'terverifikasi')
                            ->sum('jumlah_bayar');
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $booking->user->name }}</strong><br>
                            <small>{{ $booking->user->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $booking->studio->nama_studio }}</strong><br>
                            <small>{{ Str::limit($booking->studio->lokasi, 25) }}</small>
                        </td>
                        <td>{{ $booking->jam_mulai }}<br>{{ $booking->jam_selesai }}</td>
                        <td style="text-align: center;">{{ $booking->durasi_jam }} jam</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                        <td style="text-align: right; color: #059669;">Rp {{ number_format($totalBayar, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($booking->status_booking == 'pending')
                                <span class="status status-pending">Pending</span>
                            @elseif($booking->status_booking == 'dibayar')
                                <span class="status status-dibayar">Dibayar</span>
                            @elseif($booking->status_booking == 'selesai')
                                <span class="status status-selesai">Selesai</span>
                            @else
                                <span class="status status-dibatalkan">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Total Booking:</span>
                <strong>{{ $bookings->count() }} transaksi</strong>
            </div>
            <div class="summary-row">
                <span>Booking Selesai:</span>
                <strong>{{ $bookings->where('status_booking', 'selesai')->count() }} booking</strong>
            </div>
            <div class="summary-row summary-total">
                <span>TOTAL PENDAPATAN:</span>
                <span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data booking untuk periode yang dipilih.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dicetak otomatis oleh sistem Studio Musik Booking</p>
        <p>© {{ date('Y') }} Studio Musik. All rights reserved.</p>
    </div>

</body>

</html>
