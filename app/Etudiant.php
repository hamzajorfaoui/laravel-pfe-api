<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    //etudiants
    protected $table = 'etudiants';

    public function filiere(){
        return $this->belongsTo('App\Filiere');
    }
}
