<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Filiere extends Model
{
    protected $table = 'filieres';

    public function departement(){
            return $this->belongsTo('App\Departement');
    }
    public function etudiant(){
        return $this->hasMany('App\Etudiant');
    }
    public function annonce(){
        return $this->hasMany('App\Annonce' , 'filiere_id' , 'id');
    }
        public function matiere(){
        return $this->hasMany('App\Matiere' , 'matiere_id' , 'id');
    }
    public function actualite()
    {
        return $this->belongsToMany('App\Actualite','actualite_filiers', 'filiere_id', 'actualite_id');
    }
}


