<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nom',
        'description'
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }
}
