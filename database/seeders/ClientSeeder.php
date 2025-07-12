<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'nom' => 'alioune sall',
                'email' => 'alioune.sall@email.com',
                'telephone' => '+221 77 123 45 67',
                'adresse' => 'Rue de la Corniche, Dakar, Sénégal'
            ],
            [
                'nom' => 'Mamadou Diallo',
                'email' => 'mamadou.diallo@email.com',
                'telephone' => '+221 76 234 56 78',
                'adresse' => 'Avenue Georges Bush, Dakar, Sénégal'
            ],
            [
                'nom' => 'pape moussa',
                'email' => 'pape.moussa@email.com',
                'telephone' => '+221 78 345 67 89',
                'adresse' => 'Quartier Almadies, Dakar, Sénégal'
            ],
            [
                'nom' => 'abdel manzo',
                'email' => 'abdel.manzo@email.com',
                'telephone' => '+221 77 456 78 90',
                'adresse' => 'Zone 4, Dakar, Sénégal'
            ],
            [
                'nom' => 'Mariama Ba',
                'email' => 'mariama.ba@email.com',
                'telephone' => '+221 76 567 89 01',
                'adresse' => 'Plateau, Dakar, Sénégal'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
