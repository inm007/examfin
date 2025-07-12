<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse'
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
