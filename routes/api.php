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
Route::post('login', 'AuthController@login');


Route::group(['middleware' => ['jwt.verify']], function() {
    
    Route::get('etudiant/etudbyfiliere/{filiere_id}','EtudiantController@etudbyfiliere');

    Route::resources(['prof'=> 'ProfController',
                      'dept'=> 'DepartementController',
                      'filiere'=> 'FillereController',
                      'etudiant'=>'EtudiantController'
                     ]);

     Route::resources(['examen'=> 'ExamenController',
                       'temps'=> 'TempController',
                     ]);
});