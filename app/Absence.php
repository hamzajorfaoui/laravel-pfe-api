<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = [
        'id',
        'jour',
'semaine',
'etudiant_id',
'semester_id',
    ];
    

}
