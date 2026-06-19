<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $trips = [
            [
                'name' => 'Goa Sangulan',
                'description' => 'Susuri goa karst tersembunyi yang jadi salah satu destinasi favorit Borneo Venture — hampir 100 penjelajah telah menjejakkan kaki di sini. Stalaktit megah, lorong bawah tanah, dan keheningan purba yang belum tersentuh wisata massal.',
                'location' => 'Kutai Kartanegara, Kalimantan Timur',
                'duration' => '1 Hari',
                'duration_days' => 1,
                'price' => 250000,
                'max_participants' => 20,
                'difficulty' => 'Easy',
                'image' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?w=800',
                'includes' => ['Transportasi PP', 'Makan siang', 'Guide lokal', 'Helm & headlamp', 'Dokumentasi'],
            ],
            [
                'name' => 'Desa Kersik',
                'description' => 'Eksplorasi desa pesisir dengan empat dimensi khas BV: alam, budaya, sosial, dan kearifan lokal. Sekitar 70 peserta telah merasakan homestay bareng warga, kuliner lokal, dan keramahan masyarakat yang autentik.',
                'location' => 'Marangkayu, Kutai Kartanegara',
                'duration' => '2 Hari 1 Malam',
                'duration_days' => 2,
                'price' => 450000,
                'max_participants' => 15,
                'difficulty' => 'Easy',
                'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800',
                'includes' => ['Transportasi PP', 'Makan 3x', 'Homestay warga', 'Guide lokal', 'Dokumentasi'],
            ],
            [
                'name' => 'Gua Batu Gelap',
                'description' => 'Petualangan menembus gua gelap dengan formasi batuan menakjubkan — sekitar 80 orang merasakan sensasi pertama mereka di sini. Caving menyusuri lorong sempit, sungai bawah tanah, dan koloni kelelawar di kegelapan total.',
                'location' => 'Kutai Kartanegara, Kalimantan Timur',
                'duration' => '1 Hari',
                'duration_days' => 1,
                'price' => 275000,
                'max_participants' => 18,
                'difficulty' => 'Moderate',
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=800',
                'includes' => ['Transportasi PP', 'Makan siang', 'Guide caving', 'Helm & headlamp', 'Dokumentasi'],
            ],
            [
                'name' => 'Desa Buana Jaya',
                'description' => 'Menyelami kehidupan desa transmigran di pedalaman Kalimantan Timur. Trek ringan menembus kabut pagi, mengenal tradisi & kearifan lokal warga, hingga menikmati sunrise di bukit hijau yang masih perawan.',
                'location' => 'Tenggarong Seberang, Kutai Kartanegara',
                'duration' => '2 Hari 1 Malam',
                'duration_days' => 2,
                'price' => 500000,
                'max_participants' => 15,
                'difficulty' => 'Easy',
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800',
                'includes' => ['Transportasi PP', 'Makan 3x', 'Homestay', 'Guide lokal', 'Dokumentasi'],
            ],
            [
                'name' => 'Desa Manunggal Jaya',
                'description' => 'Ekspedisi budaya & sosial ke desa yang kaya tradisi. Berbaur langsung dengan warga lewat makan bersama, belajar kerajinan tangan, tari adat, dan kearifan lokal yang diwariskan turun-temurun.',
                'location' => 'Tenggarong Seberang, Kutai Kartanegara',
                'duration' => '2 Hari 1 Malam',
                'duration_days' => 2,
                'price' => 500000,
                'max_participants' => 15,
                'difficulty' => 'Easy',
                'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
                'includes' => ['Transportasi PP', 'Makan 3x', 'Homestay warga', 'Workshop budaya', 'Dokumentasi'],
            ],
            [
                'name' => 'Air Terjun Bone Venture',
                'description' => 'Air terjun tersembunyi di kawasan Brambay, Samarinda Utara — ikon alam Borneo Venture. Trek menyusuri hutan tropis menuju curahan air jernih yang menyegarkan, sempurna untuk healing dari hiruk pikuk kota.',
                'location' => 'Brambay, Samarinda Utara',
                'duration' => '1 Hari',
                'duration_days' => 1,
                'price' => 200000,
                'max_participants' => 20,
                'difficulty' => 'Easy',
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=800',
                'includes' => ['Transportasi PP', 'Snack & air mineral', 'Guide lokal', 'Dokumentasi'],
            ],
        ];

        foreach ($trips as $trip) {
            \App\Models\Trip::create($trip);
        }
    }
}
