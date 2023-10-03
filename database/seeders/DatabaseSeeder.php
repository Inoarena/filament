<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Brand::create([
            'name'=>'hostgator',
            'slug'=>'hostgator',
            'url'=>'hostgator.com',
            'primary_hex'=>'#h674CC4',
            'is_visible'=>'1',
            'description'=>'hostinger',
        ]);
        Product::create([
            'image' => 'sem imagem',
            'name' => 'mala a2s',
            'brand_id' => 1,
            'sku' => 'hjkdgkdh',
            'slug' => 'menos',
            'is_visible' => 1,
            'is_featured' => 1,
            'price' => '0.00',
            'quantity' => "2",
            'description' => "vps",
            'published_at' => "2023-10-03 10:51:52",
            
        ]);
    }
}
