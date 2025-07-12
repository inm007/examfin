<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commande;
use App\Models\Client;
use App\Models\Produit;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les clients et produits
        $clients = Client::all();
        $produits = Produit::all();

        if ($clients->isEmpty() || $produits->isEmpty()) {
            return;
        }

        // Créer quelques commandes
        $commandes = [
            [
                'client_id' => $clients->first()->id,
                'date_commande' => now()->subDays(5),
                'statut' => 'Validée'
            ],
            [
                'client_id' => $clients->get(1)->id,
                'date_commande' => now()->subDays(3),
                'statut' => 'En attente'
            ],
            [
                'client_id' => $clients->get(2)->id,
                'date_commande' => now()->subDays(1),
                'statut' => 'Livrée'
            ]
        ];

        foreach ($commandes as $commandeData) {
            $commande = Commande::create($commandeData);

            // Ajouter des produits à chaque commande
            $produit = $produits->random();
            $quantite = rand(1, 3);
            
            $commande->produits()->attach($produit->id, [
                'quantite' => $quantite,
                'prix_unitaire' => $produit->prix
            ]);
        }
    }
}
