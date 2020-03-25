<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planing extends Model
{
                protected $fillable = [
       'id', 'date_debut', 'date_semester', 'date_fin'
    ];
    protected $hidden = [
        'updated_at', 'created_at',
    ];


}
