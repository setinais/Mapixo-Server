<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfertaMaterial extends Model
{
    use SoftDeletes;

    public function coleta_oferta(){
        return $this->hasOne('App\ColetaOferta');
    }

    public function classificacao(){
        return $this->belongsTo('App\Classificacao');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function localizacao(){
        return $this->belongsTo('App\Localizacao');
    }

    public function unidade_medida(){
        return $this->belongsTo('App\UnidadeMedida');
    }
}
