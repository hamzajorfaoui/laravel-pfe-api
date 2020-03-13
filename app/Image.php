<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    public function actualite()
    {
        return $this->belongsTo('App\Actualite');
    }

    
    protected $uploadtim = '/images/';

   

    public function getFileAttribute($image){
        return $this->uploadtim . $image;
    }
}
