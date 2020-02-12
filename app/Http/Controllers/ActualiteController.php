<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Matiere;
use App\User;
use App\Actualite;
use App\Http\Resources\ActualiteCollection;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    
        


        $actualites = Actualite::all();
        return ActualiteCollection::collection($actualites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //user
        $idu=auth('api')->user()->id;
        $user = User::find($idu);

        
        //actualite
        $actualite = new Actualite;
        $actualite->title = $request->title;
        $actualite->contenu = $request->contenu;
         $user->actualites()->save($actualite);

        //table id filiiers


        $filiers_id = $request->filiers_id;

     
        foreach ($filiers_id as $id) {

            $filiere = Filiere::find($id);

             $actualite->filiers()->save($filiere);
            
        }
        return $actualite;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
        return $actualite = Actualite::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actualite = Actualite::find($id);
        $actualite->title = $request->title;
        $actualite->contenu = $request->contenu;
        $actualite->save();

         return $actualite ;

    }
    public function actualitesbyfillier($id_fil){

        // $actualities = Actualite::with('filiere_id',$id_fil)->get();
        // return ActualiteCollection::collection($actualities);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
