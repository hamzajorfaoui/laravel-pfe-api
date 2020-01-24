<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    //etudiants
    protected $table = 'etudiants';
    protected $hidden = [
        'filiere_id'
    ];

  

    public function filiere(){
        return $this->belongsTo('App\Filiere','filiere_id');
    }

     public function toArray() {
        
        $data = parent::toArray();

        if ($this->filiere ) {
           $data =  $data +  ['filiere' =>$this->filiere->name];
           $data =  $data +  ['departement' =>$this->filiere->departement->name];


        } else {
            $data =  $data +  ['filiere' =>null];
            $data  =  $data +  ['departement' =>null];
        }

        

        return $data;
    }
}
