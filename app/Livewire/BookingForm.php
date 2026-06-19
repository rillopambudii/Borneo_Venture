<?php

namespace App\Livewire;

use App\Mail\BookingConfirmation;
use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BookingForm extends Component
{
    public ?Trip $selectedTrip = null;
    public int $tripId = 0;
    public string $name = '';
    public string $email = '';
    public string $whatsapp = '';
    public int $participants = 1;
    public string $tripDate = '';
    public string $notes = '';

    protected function rules(): array
    {
        return [
            'tripId'       => 'required|exists:trips,id',
            'name'         => 'required|min:3|max:100',
            'email'        => 'required|email',
            'whatsapp'     => 'required|regex:/^[0-9+\-\s]{9,15}$/',
            'participants' => 'required|integer|min:1|max:20',
            'tripDate'     => 'required|date|after:today',
            'notes'        => 'nullable|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'tripId.required'       => 'Pilih trip terlebih dahulu.',
            'name.required'         => 'Nama wajib diisi.',
            'name.min'              => 'Nama minimal 3 karakter.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'whatsapp.required'     => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex'        => 'Nomor WhatsApp tidak valid.',
            'participants.required' => 'Jumlah peserta wajib diisi.',
            'participants.min'      => 'Minimal 1 peserta.',
            'tripDate.required'     => 'Tanggal trip wajib diisi.',
            'tripDate.after'        => 'Tanggal harus setelah hari ini.',
        ];
    }

    public function updatedTripId(int $value): void
    {
        $this->selectedTrip = $value ? Trip::find($value) : null;
        $this->participants = 1;
    }

    public function updatedParticipants(): void
    {
        $max = $this->selectedTrip?->max_participants ?? 20;
        $this->participants = max(1, min($max, (int) $this->participants));
    }

    public function incrementParticipants(): void
    {
        $max = $this->selectedTrip?->max_participants ?? 20;
        $this->participants = min($max, $this->participants + 1);
    }

    public function decrementParticipants(): void
    {
        $this->participants = max(1, $this->participants - 1);
    }

    #[Computed]
    public function totalPrice(): float
    {
        if (! $this->selectedTrip) {
            return 0;
        }
        return (float) $this->selectedTrip->price * max(1, $this->participants);
    }

    public function submit()
    {
        $this->validate();

        $code = 'BV-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $booking = Booking::create([
            'trip_id'      => $this->tripId,
            'name'         => $this->name,
            'email'        => $this->email,
            'whatsapp'     => $this->whatsapp,
            'participants' => $this->participants,
            'trip_date'    => $this->tripDate,
            'total_price'  => $this->totalPrice,
            'notes'        => $this->notes,
            'booking_code' => $code,
        ]);

        // Email otomatis ke customer (+ salinan ke admin BV). Kegagalan kirim
        // tidak boleh membatalkan booking — cukup dicatat di log.
        try {
            $mail = Mail::to($booking->email);
            if ($adminEmail = config('borneo.email')) {
                $mail->bcc($adminEmail);
            }
            $mail->send(new BookingConfirmation($booking->load('trip')));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email konfirmasi booking ' . $code . ': ' . $e->getMessage());
        }

        return $this->redirect(route('booking.success', $code), navigate: false);
    }

    public function render()
    {
        $trips = Trip::where('is_active', true)->get();
        return view('livewire.booking-form', ['trips' => $trips]);
    }
}
