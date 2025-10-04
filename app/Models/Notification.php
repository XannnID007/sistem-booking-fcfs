<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'url',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Relationship dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope untuk notifikasi yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if notification is read
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Static Methods untuk membuat notifikasi
     */

    /**
     * Notifikasi untuk Admin - Booking Baru
     */
    public static function createBookingNotification($adminId, $booking)
    {
        return self::create([
            'user_id' => $adminId,
            'type' => 'booking',
            'title' => 'Booking Baru',
            'message' => "Booking baru dari {$booking->user->name} untuk studio {$booking->studio->nama_studio}",
            'url' => route('admin.booking.show', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Admin - Pembayaran Baru (Pending)
     */
    public static function createPaymentNotification($adminId, $payment)
    {
        $booking = $payment->booking;
        return self::create([
            'user_id' => $adminId,
            'type' => 'payment',
            'title' => 'Pembayaran Menunggu Verifikasi',
            'message' => "Pembayaran Rp " . number_format($payment->jumlah_bayar, 0, ',', '.') . " dari {$booking->user->name} menunggu verifikasi",
            'url' => route('admin.payment.index'),
        ]);
    }

    /**
     * Notifikasi untuk Customer - Pembayaran Terverifikasi
     */
    public static function createPaymentVerifiedNotification($customerId, $payment)
    {
        $booking = $payment->booking;
        return self::create([
            'user_id' => $customerId,
            'type' => 'payment',
            'title' => 'Pembayaran Terverifikasi',
            'message' => "Pembayaran Anda sebesar Rp " . number_format($payment->jumlah_bayar, 0, ',', '.') . " untuk booking {$booking->studio->nama_studio} telah diverifikasi",
            'url' => route('customer.booking.show', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Customer - Pembayaran Ditolak
     */
    public static function createPaymentRejectedNotification($customerId, $payment)
    {
        $booking = $payment->booking;
        $reason = $payment->catatan_admin ?? 'Tidak ada keterangan';

        return self::create([
            'user_id' => $customerId,
            'type' => 'payment',
            'title' => 'Pembayaran Ditolak',
            'message' => "Pembayaran Anda ditolak. Alasan: {$reason}",
            'url' => route('customer.booking.show', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Customer - Booking Selesai
     */
    public static function createBookingCompletedNotification($customerId, $booking)
    {
        return self::create([
            'user_id' => $customerId,
            'type' => 'booking',
            'title' => 'Booking Selesai',
            'message' => "Booking Anda untuk studio {$booking->studio->nama_studio} telah selesai. Terima kasih!",
            'url' => route('customer.booking.history.detail', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Customer - Reminder Booking Hari Ini
     */
    public static function createBookingReminderNotification($customerId, $booking)
    {
        return self::create([
            'user_id' => $customerId,
            'type' => 'booking',
            'title' => 'Reminder Booking',
            'message' => "Booking Anda di {$booking->studio->nama_studio} hari ini pukul {$booking->jam_mulai}. Jangan lupa!",
            'url' => route('customer.booking.show', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Customer - Booking Dibatalkan
     */
    public static function createBookingCancelledNotification($customerId, $booking)
    {
        return self::create([
            'user_id' => $customerId,
            'type' => 'booking',
            'title' => 'Booking Dibatalkan',
            'message' => "Booking Anda untuk studio {$booking->studio->nama_studio} telah dibatalkan",
            'url' => route('customer.booking.history.detail', $booking->id),
        ]);
    }

    /**
     * Notifikasi untuk Admin - Booking Dibatalkan oleh Customer
     */
    public static function createAdminBookingCancelledNotification($adminId, $booking)
    {
        return self::create([
            'user_id' => $adminId,
            'type' => 'booking',
            'title' => 'Booking Dibatalkan',
            'message' => "{$booking->user->name} membatalkan booking untuk studio {$booking->studio->nama_studio}",
            'url' => route('admin.booking.show', $booking->id),
        ]);
    }

    /**
     * Notifikasi System untuk semua user (Broadcast)
     */
    public static function createSystemNotification($userIds, $title, $message, $url = null)
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'type' => 'system',
                'title' => $title,
                'message' => $message,
                'url' => $url,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return self::insert($notifications);
    }

    /**
     * Helper: Kirim notifikasi ke semua admin
     */
    public static function notifyAllAdmins($title, $message, $url = null)
    {
        $admins = User::where('role', 'admin')->pluck('id');
        return self::createSystemNotification($admins, $title, $message, $url);
    }

    /**
     * Helper: Hapus notifikasi lama (cleanup)
     * Hapus notifikasi yang sudah dibaca lebih dari 30 hari
     */
    public static function deleteOldNotifications()
    {
        return self::where('read_at', '<', now()->subDays(30))->delete();
    }
}
