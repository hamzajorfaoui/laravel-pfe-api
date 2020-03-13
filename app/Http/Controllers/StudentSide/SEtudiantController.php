<?php

namespace App\Http\Controllers\StudentSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filiere;
use App\Matiere;
use App\User;
use App\Actualite;
use App\Http\Resources\ActualiteCollection;
class SEtudiantController extends Controller
{
        public function actualitesbyfillierte(){
         return auth('api')->user()->etudiant;

        
    }
}
