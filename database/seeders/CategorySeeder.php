<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
        ['nom' => 'Agriculture Bio', 'description' => 'Livres sur la permaculture et le jardinage.'],
        ['nom' => 'Énergie Renouvelable', 'description' => 'Solaire, éolien et transition.'],
        ['nom' => 'Zéro Déchet', 'description' => 'Réduire son impact au quotidien.'],
    ];

    foreach ($categories as $cat) {
        Category::create($cat);
    }
    }
}
