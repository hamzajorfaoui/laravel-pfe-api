<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Prof extends Model
{
    protected $table = 'profs';
    use SoftDeletes;
}
 