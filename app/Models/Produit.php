<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'stock',
        'seuil_alerte',
        'categorie_id',
        'image_url'
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'stock' => 'integer',
        'seuil_alerte' => 'integer',
    ];

    public function categorie()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function isStockFaible()
    {
        return $this->stock <= $this->seuil_alerte;
    }

    public function scopeStockFaible($query)
    {
        return $query->whereRaw('stock <= seuil_alerte');
    }
}
