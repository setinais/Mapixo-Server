<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $fillable = [
        'latitude', 'longitude'
    ];

    public function oferta_material(){
        return $this->hasOne('App\OfertaMaterial');
    }
}
