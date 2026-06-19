<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Diterima ' . $this->booking->booking_code . ' — Borneo Venture',
            replyTo: [config('borneo.email')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation',
            with: [
                'booking'     => $this->booking,
                'trip'        => $this->booking->trip,
                'whatsappUrl' => $this->booking->whatsappConfirmUrl(),
                'successUrl'  => route('booking.success', $this->booking->booking_code),
            ],
        );
    }
}
