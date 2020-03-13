<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 use SoftDeletes;
class EmploiTemp extends Model
{
   
    
    protected $fillable = [
        'temp','filiere_id'
    ];

    protected $uploadtm = '/temps/';

   

    public function getFileAttribute($emploiTemp){
        return $this->uploadtm . $emploiTemp;
    }
}
