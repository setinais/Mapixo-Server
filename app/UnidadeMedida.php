<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    public function oferta_material(){
        return $this->hasOne('App\OfertaMaterial');
    }
}
