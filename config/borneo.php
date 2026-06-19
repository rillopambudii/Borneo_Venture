<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nomor WhatsApp Admin Borneo Venture
    |--------------------------------------------------------------------------
    |
    | Format internasional tanpa tanda "+" atau "0" di depan.
    | Contoh: nomor 0812-3456-7890 ditulis menjadi "6281234567890".
    | Ubah nilai BV_WHATSAPP_NUMBER di file .env.
    |
    */
    'whatsapp_number' => env('BV_WHATSAPP_NUMBER', '6281234567890'),

    'instagram' => env('BV_INSTAGRAM', 'borneo.venture'),

    'email' => env('BV_EMAIL', 'borneoventure@gmail.com'),
];
