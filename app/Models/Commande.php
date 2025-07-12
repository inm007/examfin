<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'client_id',
        'date_commande',
        'statut'
    ];

    protected $casts = [
        'date_commande' => 'datetime',
    ];

    protected $with = ['client', 'produits'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
