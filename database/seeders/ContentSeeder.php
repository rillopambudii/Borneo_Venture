<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\ExplorationAspect;
use App\Models\Highlight;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // --- Empat Aspek Eksplorasi ---
        if (ExplorationAspect::count() === 0) {
            $aspects = [
                ['🌿', 'Eksplorasi Alam', 'Air terjun tersembunyi, bukit hijau, dan lanskap perawan Kalimantan yang belum tersentuh wisata massal.', 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=900'],
                ['🎭', 'Eksplorasi Budaya', 'Tradisi, tari adat, kerajinan tangan, hingga kuliner khas masyarakat Dayak dan Banjar.', 'https://images.unsplash.com/photo-1528127269322-539801943592?w=900'],
                ['🤝', 'Eksplorasi Sosial', 'Berbaur langsung dengan warga lewat homestay dan makan bersama — pengalaman yang autentik dan hangat.', 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=900'],
                ['🪶', 'Kearifan Lokal', 'Menyelami kepercayaan, adat, dan nilai-nilai luhur yang diwariskan turun-temurun di setiap desa.', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=900'],
            ];

            foreach ($aspects as $i => [$icon, $title, $desc, $img]) {
                $aspect = ExplorationAspect::create([
                    'icon' => $icon,
                    'title' => $title,
                    'description' => $desc,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]);
                $aspect->images()->create(['path' => $img, 'sort_order' => 1]);
            }
        }

        // --- Eksplorasi Borneo (highlight) ---
        if (Highlight::count() === 0) {
            $highlights = [
                ['Goa Sangulan', 'Kutai Kartanegara', 'Goa karst dengan stalaktit memukau yang sudah dikunjungi ratusan penjelajah bersama BV.', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=900'],
                ['Desa Kersik', 'Kutai Kartanegara', 'Desa pesisir dengan kehidupan nelayan, kuliner laut, dan keramahan warga yang autentik.', 'https://images.unsplash.com/photo-1518684079-3c830dcef090?w=900'],
                ['Air Terjun Bone Venture', 'Brambay, Samarinda Utara', 'Air terjun tersembunyi di rimba Samarinda Utara — segar, jernih, dan jauh dari keramaian.', 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=900'],
            ];

            foreach ($highlights as $i => [$title, $location, $desc, $img]) {
                $highlight = Highlight::create([
                    'title' => $title,
                    'location' => $location,
                    'description' => $desc,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]);
                $highlight->images()->create(['path' => $img, 'sort_order' => 1]);
            }
        }

        // --- Tentang Kami ---
        if (AboutSection::count() === 0) {
            $about = AboutSection::create([
                'eyebrow' => 'Tentang Kami',
                'title' => 'Dari Samarinda ke Pedalaman Kalimantan',
                'body' => "Berawal dari hobi Rojo Octa menjelajahi alam dan budaya, Borneo Venture lahir untuk menjembatani siapa pun yang ingin ke alam tapi terkendala akses atau teman seperjalanan.\n\nLebih dari sekadar tur wisata — BV adalah gerakan untuk menghidupkan perputaran ekonomi nyata di desa, mengenalkan destinasi tersembunyi, dan melestarikan kekayaan Kalimantan bersama masyarakat lokal.",
                'badge_title' => '2024',
                'badge_subtitle' => 'Berdiri 28 Agustus',
                'tags' => ['Trek Hutan', 'Susur Sungai', 'Budaya Dayak', 'Wildlife', 'Camping'],
            ]);
            $about->images()->create(['path' => '/images/tentang-kami.jpg', 'sort_order' => 1]);
        }
    }
}
