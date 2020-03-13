<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//*******************||   Authentification    ||***********************
Route::post('signup', 'AuthController@signup');
Route::post('uplaoder', 'AuthController@uplaoder');
Route::post('login', 'AuthController@login');
Route::post('etudiant/login', 'EtudiantController@login');
Route::post('etudiant/sendcodetoemail', 'EtudiantController@sendcodetoemail');
Route::post('etudiant/verfiyemail', 'EtudiantController@verfiyemail');
Route::post('etudiant/upetudiant', 'EtudiantController@upetudiant');
    

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('refresh','AuthController@refresh');

    Route::get('data/getData/{filiere_id}','AnnoncesController@getData');
    Route::get('etudiant/etudbyfiliere/{filiere_id}','EtudiantController@etudbyfiliere');

    Route::get('annonce/annoncesbyfillier/{id_fil}','AnnoncesController@annoncesbyfillier');

    Route::get('etudiant/cneexiste/{cne}','EtudiantController@cneexiste');
    Route::get('etudiant/cinexiste/{cin}','EtudiantController@cinexiste');
    Route::get('etudiantwithcompte/{id}','EtudiantController@etudiantwithcompte');

    Route::get('etudiant/search','EtudiantController@search');
     
    Route::get('prof/search','ProfController@search');

    Route::get('prof/profemail/{email}','ProfController@emailexist');
    Route::get('prof/profemail/{id}/{email}','ProfController@emailexistUpdate');

    Route::get('dept/deptname/{name}','DepartementController@nameexist');

    Route::resources(['prof'=> 'ProfController',
                      'dept'=> 'DepartementController',
                      'filiere'=> 'FillereController',
                      'etudiant'=>'EtudiantController'
                     ]);

    Route::resources([
    
    'temps'=> 'TempController',
    'annonce'=>'AnnoncesController',
    'matiere' => 'MatiereController',
    'examen'=> 'ExamenController',
    'actualite' => 'ActualiteController'

    ]);

     Route::post('examen/modify/{id}','ExamenController@modifiy');
     Route::post('temps/modify/{id}','TempController@modifiy');

    Route::get('filier/matieres/{id}','MatiereController@matiersbyfilier');
    
    Route::get('departements','DepartementController@departementwithfiliers');

    Route::get('me','AuthController@me');

});
Route::group(['middleware' => ['jwt.etudiant']], function() {

   Route::post('etudiant/etudiantest', '@etudiantest');
   Route::get('etud_actualite/byfillier', 'ActualiteController@actualitesbyfillier');
   Route::get('etud_annonce/byfillier', 'AnnoncesController@anoncesbyfillier');
   Route::get('etud_myprofile', 'EtudiantController@myprofile');
   
});