<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploiExamen extends Model
{
    
    
    protected $fillable = [
        'examen', 
    ];


    protected $uploadex = '/examens/';

   

    public function getFileAttribute($emploiExamen){
        return $this->uploadex . $emploiExamen;
    }


}
