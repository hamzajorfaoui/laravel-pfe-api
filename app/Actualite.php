<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    public function filiers()
    {
        return $this->belongsToMany('App\Filiere','actualite_filiers', 'actualite_id', 'filiere_id');
    }
}
