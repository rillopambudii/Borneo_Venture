<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'trip_id', 'name', 'email', 'whatsapp', 'participants',
        'trip_date', 'total_price', 'status', 'notes', 'booking_code',
    ];

    protected $casts = [
        'trip_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function getTotalPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'Dikonfirmasi',
            'cancelled' => 'Dibatalkan',
            default     => 'Menunggu Konfirmasi',
        };
    }

    /**
     * Tailwind classes for the status badge.
     */
    public function getStatusClassesAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'bg-green-500/20 text-green-300 border-green-500/40',
            'cancelled' => 'bg-red-500/20 text-red-300 border-red-500/40',
            default     => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
        };
    }

    /**
     * Deep-link WhatsApp ke admin BV dengan pesan konfirmasi terisi lengkap.
     */
    public function whatsappConfirmUrl(): string
    {
        $number = config('borneo.whatsapp_number');

        $lines = [
            'Halo Borneo Venture! 🌿',
            'Saya mau konfirmasi booking saya:',
            '',
            "Kode Booking: {$this->booking_code}",
            "Trip: {$this->trip->name}",
            "Lokasi: {$this->trip->location}",
            'Tanggal: ' . $this->trip_date->translatedFormat('l, d F Y'),
            "Jumlah Peserta: {$this->participants} orang",
            'Total: ' . $this->total_price_formatted,
            '',
            "Atas nama: {$this->name}",
        ];

        if ($this->notes) {
            $lines[] = "Catatan: {$this->notes}";
        }

        return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
    }

    /**
     * Tautan "Tambah ke Google Calendar" (event seharian sesuai durasi trip).
     */
    public function googleCalendarUrl(): string
    {
        $start = $this->trip_date->copy();
        $end   = $this->trip_date->copy()->addDays(max(1, (int) $this->trip->duration_days));

        $params = http_build_query([
            'action'   => 'TEMPLATE',
            'text'     => 'Borneo Venture — ' . $this->trip->name,
            'dates'    => $start->format('Ymd') . '/' . $end->format('Ymd'),
            'details'  => "Trip {$this->trip->name} bersama Borneo Venture.\nKode booking: {$this->booking_code}",
            'location' => $this->trip->location,
        ]);

        return 'https://calendar.google.com/calendar/render?' . $params;
    }
}
