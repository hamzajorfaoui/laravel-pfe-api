<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etudiant;
use App\Filiere;

use App\Http\Controllers\BaseController as BaseController ;
class EtudiantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Etudiant::get();
    }

    public function etudbyfiliere($filiere_id)
    {
        return Etudiant::WHERE('filiere_id',$filiere_id)
                              ->get();
    }
    public function search(Request $request)
    {
        if ($request->column == 'cin' || $request->column == 'cne' || $request->column == 'fullname'   ) {


             $list = Etudiant::where($request->column , 'like', '%' . $request->keyword . '%')->get(); 
             return $this->sendResponse($list->toArray(), 'etudiants');

        }else {

             return response()->json(['error' => ""]);  
            
        }
       

        
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
        $etudiant = new Etudiant;
        $etudiant->fullname = $request->fullname;
        $etudiant->cin	    = $request->cin;
        $etudiant->cne      = $request->cne;

        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "departement not exist"]);  
        }
        $filiere->etudiant()->save($etudiant);
        return response()->json(['succed' => "all is good"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Etudiant::find($id);
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
        //
    }


}
