<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    //departements
    protected $table = 'departements';

    public function filiere(){
            return $this->hasMany('App\Filiere','departement_id','id');
    }
}
