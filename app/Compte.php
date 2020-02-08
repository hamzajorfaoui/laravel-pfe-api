<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    public function etudiant(){
        return $this->belongsTo('App\Etudiant','etudiant_id');
    }
}
