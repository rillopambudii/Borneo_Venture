<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking {{ $booking->booking_code }}</title>
</head>
<body style="margin:0; padding:0; background:#eef2ee; font-family:Arial, Helvetica, sans-serif; color:#1f2d24;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2ee; padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.06);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#0b1a12; padding:32px 32px 28px; text-align:center;">
                            <div style="font-family:Georgia, 'Times New Roman', serif; font-size:22px; font-weight:bold; color:#ffffff; letter-spacing:.5px;">Borneo Venture</div>
                            <div style="font-size:11px; color:#81c784; letter-spacing:3px; text-transform:uppercase; margin-top:4px;">Explore The Untouched</div>
                        </td>
                    </tr>

                    {{-- Hero --}}
                    <tr>
                        <td style="padding:36px 32px 8px; text-align:center;">
                            <div style="display:inline-block; width:64px; height:64px; line-height:64px; background:#2e7d32; border-radius:50%; color:#fff; font-size:30px;">&#10003;</div>
                            <h1 style="margin:18px 0 6px; font-family:Georgia, serif; font-size:26px; color:#0b1a12;">Booking Diterima!</h1>
                            <p style="margin:0; font-size:15px; color:#5a6b60;">
                                Halo <strong style="color:#1f2d24;">{{ $booking->name }}</strong>, terima kasih sudah booking bersama BV. Tinggal satu langkah lagi.
                            </p>
                        </td>
                    </tr>

                    {{-- Booking code --}}
                    <tr>
                        <td style="padding:24px 32px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f6f1; border:1px solid #d6e4d8; border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <div style="font-size:12px; color:#5a6b60; margin-bottom:4px;">Kode Booking</div>
                                        <div style="font-family:'Courier New', monospace; font-size:22px; font-weight:bold; color:#0b1a12; letter-spacing:2px;">{{ $booking->booking_code }}</div>
                                    </td>
                                    <td align="right" style="padding:16px 20px;">
                                        <span style="display:inline-block; background:#fff4d6; color:#9a6b00; font-size:12px; font-weight:bold; padding:6px 12px; border-radius:20px; border:1px solid #f0d690;">{{ $booking->status_label }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Trip details --}}
                    <tr>
                        <td style="padding:16px 32px 8px;">
                            <h2 style="margin:0 0 12px; font-family:Georgia, serif; font-size:18px; color:#0b1a12;">{{ $trip->name }}</h2>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#1f2d24;">
                                <tr>
                                    <td style="padding:8px 0; color:#5a6b60; width:45%;">Lokasi</td>
                                    <td style="padding:8px 0; text-align:right; font-weight:bold;">{{ $trip->location }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#5a6b60; border-top:1px solid #eef2ee;">Tanggal</td>
                                    <td style="padding:8px 0; text-align:right; font-weight:bold; border-top:1px solid #eef2ee;">{{ $booking->trip_date->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#5a6b60; border-top:1px solid #eef2ee;">Durasi</td>
                                    <td style="padding:8px 0; text-align:right; font-weight:bold; border-top:1px solid #eef2ee;">{{ $trip->duration }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#5a6b60; border-top:1px solid #eef2ee;">Jumlah Peserta</td>
                                    <td style="padding:8px 0; text-align:right; font-weight:bold; border-top:1px solid #eef2ee;">{{ $booking->participants }} orang</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0 8px; color:#0b1a12; font-weight:bold; border-top:2px solid #d6e4d8;">Total</td>
                                    <td style="padding:12px 0 8px; text-align:right; font-weight:bold; font-size:18px; color:#2e7d32; border-top:2px solid #d6e4d8;">{{ $booking->total_price_formatted }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- WhatsApp CTA --}}
                    <tr>
                        <td style="padding:20px 32px 8px; text-align:center;">
                            <p style="margin:0 0 16px; font-size:14px; color:#5a6b60;">
                                Booking-mu masih <strong style="color:#9a6b00;">menunggu konfirmasi</strong>. Klik tombol di bawah untuk konfirmasi via WhatsApp — detail sudah otomatis terisi.
                            </p>
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td style="border-radius:12px; background:#25D366;">
                                        <a href="{{ $whatsappUrl }}" target="_blank"
                                           style="display:inline-block; padding:14px 32px; font-size:16px; font-weight:bold; color:#ffffff; text-decoration:none; border-radius:12px;">
                                            Konfirmasi via WhatsApp
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:14px 0 0; font-size:13px;">
                                <a href="{{ $successUrl }}" target="_blank" style="color:#2e7d32; text-decoration:underline;">Lihat halaman booking lengkap &rarr;</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Steps --}}
                    <tr>
                        <td style="padding:24px 32px 8px;">
                            <div style="background:#f1f6f1; border-radius:12px; padding:20px 22px;">
                                <div style="font-size:14px; font-weight:bold; color:#0b1a12; margin-bottom:12px;">Apa selanjutnya?</div>
                                @foreach([
                                    'Konfirmasi via WhatsApp (klik tombol di atas).',
                                    'Tim BV cek ketersediaan & balas konfirmasimu.',
                                    'Info pembayaran dikirim via WhatsApp.',
                                    'Bersiaplah berpetualang! 🌿',
                                ] as $i => $step)
                                <div style="font-size:13px; color:#3a4a40; margin-bottom:8px;">
                                    <strong style="color:#2e7d32;">{{ $i + 1 }}.</strong> {{ $step }}
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:28px 32px; text-align:center; border-top:1px solid #eef2ee; margin-top:16px;">
                            <p style="margin:0 0 6px; font-size:12px; color:#8a978f;">
                                Borneo Venture &middot; Samarinda, Kalimantan Timur
                            </p>
                            <p style="margin:0; font-size:12px; color:#8a978f;">
                                Instagram <a href="https://instagram.com/{{ config('borneo.instagram') }}" style="color:#2e7d32; text-decoration:none;">@{{ config('borneo.instagram') }}</a>
                                &middot; {{ config('borneo.email') }}
                            </p>
                            <p style="margin:12px 0 0; font-size:11px; color:#b5beb8;">
                                Email ini dikirim otomatis karena ada booking dengan email kamu. Jika ini bukan kamu, abaikan saja.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
