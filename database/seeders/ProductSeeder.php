<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Men's Clothing
            [
                'name' => 'Kaos Polos Hitam',
                'description' => 'Kaos polos berkualitas tinggi bahan cotton combed',
                'price' => 75000,
                'stock' => 50,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Kemeja Formal Putih',
                'description' => 'Kemeja formal untuk kantor dengan bahan katun premium',
                'price' => 150000,
                'stock' => 30,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Celana Jeans Slim Fit',
                'description' => 'Celana jeans dengan potongan slim fit nyaman untuk sehari-hari',
                'price' => 250000,
                'stock' => 25,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Jaket Bomber',
                'description' => 'Jaket bomber dengan bahan berkualitas dan desain modern',
                'price' => 300000,
                'stock' => 20,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Sweater Hoodie',
                'description' => 'Sweater hoodie dengan bahan fleece yang hangat dan nyaman',
                'price' => 180000,
                'stock' => 35,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Celana Chinos',
                'description' => 'Celana chinos dengan bahan berkualitas untuk tampilan kasual',
                'price' => 200000,
                'stock' => 40,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Kaos Lengan Panjang',
                'description' => 'Kaos lengan panjang dengan desain simple dan nyaman dipakai',
                'price' => 85000,
                'stock' => 45,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Jas Formal',
                'description' => 'Jas formal untuk acara resmi dengan potongan klasik',
                'price' => 500000,
                'stock' => 15,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Celana Pendek',
                'description' => 'Celana pendek untuk aktivitas santai di musim panas',
                'price' => 95000,
                'stock' => 60,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Topi Baseball',
                'description' => 'Topi baseball dengan desain sporty dan adjustable',
                'price' => 65000,
                'stock' => 70,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Sepatu Sneakers',
                'description' => 'Sepatu sneakers casual dengan desain modern',
                'price' => 350000,
                'stock' => 25,
                'category' => 'clothing',
                'is_active' => true
            ],
            [
                'name' => 'Sabuk Kulit',
                'description' => 'Sabuk kulit asli dengan gesper berkualitas',
                'price' => 120000,
                'stock' => 40,
                'category' => 'clothing',
                'is_active' => true
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
