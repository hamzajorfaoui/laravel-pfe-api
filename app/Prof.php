<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Prof extends Model
{
    protected $table = 'profs';
    use SoftDeletes;
     protected $fillable = [
        'fullname', 'departement_id', 'phone'
    ];

        public function user()
    {
        return $this->belongsTo('App\User');
    }
}
 