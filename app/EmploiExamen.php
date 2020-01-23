<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploiExamen extends Model
{
    
    
    protected $fillable = [
        'examen' ,'filiere_id'
    ];


    protected $uploadex = '/examens/';

   

    public function getFileAttribute($emploiExamen){
        return $this->uploadex . $emploiExamen;
    }


}
