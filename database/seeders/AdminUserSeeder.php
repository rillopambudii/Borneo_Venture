<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the admin account used to manage the gallery.
     * Credentials can be overridden via ADMIN_EMAIL / ADMIN_PASSWORD in .env.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@borneoventure.com')],
            [
                'name' => 'Admin Borneo Venture',
                'password' => env('ADMIN_PASSWORD', 'borneo-admin'),
            ],
        );
    }
}
