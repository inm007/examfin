<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nom' => 'Artisanat',
                'description' => 'artisanat traditionnel'
            ],
            [
                'nom' => 'Textiles',
                'description' => 'vêtements traditionnels'
            ],
            [
                'nom' => 'Alimentation',
                'description' => 'Produits alimentaires locaux'
            ],
            [
                'nom' => 'Cosmétiques',
                'description' => 'Produits de beauté naturels'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
