<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produit;
use App\Models\Category;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les catégories
        $artisanat = Category::where('nom', 'Artisanat')->first();
        $textiles = Category::where('nom', 'Textiles')->first();
        $alimentation = Category::where('nom', 'Alimentation')->first();

        $produits = [
            [
                'nom' => 'Thiéboudienne Traditionnel',
                'description' => 'Riz au poisson traditionnel sénégalais, préparé avec des légumes locaux et des épices authentiques. Plat national du Sénégal.',
                'prix' => 2500.00,
                'stock' => 50,
                'seuil_alerte' => 10,
                'categorie_id' => $alimentation ? $alimentation->id : null,
                'image_url' => null
            ],
            [
                'nom' => 'Boubou Wolof',
                'description' => 'Vêtement traditionnel sénégalais en coton, brodé à la main avec des motifs géométriques traditionnels. Parfait pour les cérémonies.',
                'prix' => 15000.00,
                'stock' => 15,
                'seuil_alerte' => 5,
                'categorie_id' => $textiles ? $textiles->id : null,
                'image_url' => null
            ],
            [
                'nom' => 'Masque Cérémoniel',
                'description' => 'Masque traditionnel sculpté dans le bois, utilisé lors des cérémonies traditionnelles. Artisanat local authentique.',
                'prix' => 7500.00,
                'stock' => 8,
                'seuil_alerte' => 3,
                'categorie_id' => $artisanat ? $artisanat->id : null,
                'image_url' => null
            ]
        ];

        foreach ($produits as $produit) {
            Produit::create($produit);
        }
    }
}
