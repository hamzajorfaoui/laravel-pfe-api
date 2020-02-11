<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Annonce;
use App\Filiere;
use App\Matiere;
use App\Prof;
use App\TypeAnnonce;
use App\Http\Controllers\BaseController as BaseController ;
class AnnoncesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annonces = Annonce::all();

        return $this->sendResponse($annonces->toArray(), 'stores Of user');
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

        $id=auth('api')->user()->id;

        $user = User::find($id);

        $annonce = new Annonce;
        $annonce->date_prevue         = $request->date_prevue;
        $annonce->date_auralieu	      = $request->date_auralieu;
        $annonce->salle               = $request->salle;
        //id user
        $annonce->user_id             = $id;

        $annonce->typeannonce_id      = $request->typeannonce_id;
        $annonce->matiere_id          = $request->matiere_id;
        $annonce->prof_id             = $request->prof_id;
        $annonce->filiere_id          = $request->filiere_id;
        

        $mat = Matiere::find($request->matiere_id);
        $prof = Prof::find($request->prof_id);
        $type = TypeAnnonce::find($request->typeannonce_id);
        $filiere = Filiere::find($request->filiere_id);
 

        if($mat == null || $type == null || $prof == null || $filiere == null){
        return response()->json(['error' => "something not exist"]);  
        }
        else {
            $user->annonces()->save($annonce);
            return $this->sendResponse($annonce, 'annonce is saved');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $annonce = Annonce::find($id);
        return $this->sendResponse($annonce, 'emploiExamen');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);

        


        $emploiTemp->delete();
    }

    public function getData($id)
    {
         
         $matieres = Matiere::where('filiere_id',$id)->get();;
         $profs = Prof::all();
         $types = TypeAnnonce::all();



       return response()->json([
       'matieres' => $matieres,
       'profs' => $profs,
       'types' => $types
       ]);  
        
 
    }

    public function annoncesbyfillier(){

    }
}
