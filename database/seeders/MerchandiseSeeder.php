<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchandiseSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'T-Shirt Borneo Venture',
                'description' => 'Kaos premium 100% combed cotton dengan desain eksklusif Borneo Venture. Nyaman dipakai untuk hiking maupun daily use.',
                'price' => 120000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800',
                'category' => 'apparel',
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
            ],
            [
                'name' => 'Jaket Outdoor BV',
                'description' => 'Jaket windbreaker water resistant dengan logo bordir Borneo Venture. Ringan, anti angin, dan stylish untuk petualangan apapun.',
                'price' => 350000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=800',
                'category' => 'apparel',
                'sizes' => ['S', 'M', 'L', 'XL'],
            ],
            [
                'name' => 'Topi Adventure',
                'description' => 'Topi snapback premium dengan patch Borneo Venture. Adjustable fit, cocok untuk semua kepala.',
                'price' => 85000,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=800',
                'category' => 'accessories',
                'sizes' => ['One Size'],
            ],
            [
                'name' => 'Tas Daypack 25L',
                'description' => 'Tas ransel outdoor 25 liter dengan frame internal, cocok untuk day trip hingga overnight. Material ripstop dengan rain cover.',
                'price' => 450000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800',
                'category' => 'gear',
                'sizes' => ['One Size'],
            ],
            [
                'name' => 'Botol Tumbler BV',
                'description' => 'Tumbler stainless 600ml vacuum insulated. Jaga minumanmu tetap dingin 24 jam atau panas 12 jam.',
                'price' => 150000,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=800',
                'category' => 'accessories',
                'sizes' => ['One Size'],
            ],
            [
                'name' => 'Hoodie Borneo Edition',
                'description' => 'Hoodie fleece tebal dengan motif khas Dayak Kalimantan. Limited edition, hanya tersedia 100 pcs.',
                'price' => 280000,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1556821840-3a63f15732ce?w=800',
                'category' => 'apparel',
                'sizes' => ['S', 'M', 'L', 'XL'],
            ],
        ];

        foreach ($items as $item) {
            \App\Models\Merchandise::create($item);
        }
    }
}
