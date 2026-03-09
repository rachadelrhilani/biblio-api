<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Exemplaire;
use App\Models\Livre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat = Category::first();

        $livre = Livre::create([
            'titre' => 'Le Guide du Compost',
            'auteur' => 'Jean Durable',
            'category_id' => $cat->id,
            'vues' => 150
        ]);

        Exemplaire::create(['livre_id' => $livre->id, 'etat_physique' => 'neuf', 'est_disponible' => true]);
        Exemplaire::create(['livre_id' => $livre->id, 'etat_physique' => 'bon', 'est_disponible' => true]);
        Exemplaire::create(['livre_id' => $livre->id, 'etat_physique' => 'degradé', 'est_disponible' => false]);
    }
}
