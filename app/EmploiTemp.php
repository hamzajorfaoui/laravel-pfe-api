<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmploiTemp extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'temp','filiere_id'
    ];

    protected $uploadtm = '/temps/';

   

    public function getFileAttribute($emploiTemp){
        return $this->uploadtm . $emploiTemp;
    }
}
