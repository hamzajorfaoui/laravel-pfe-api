<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Matiere;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $matieres = Matiere::all();

          return  $matieres;
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
        $matiere = new Matiere;
        $matiere->name = $request->name;
        $matiere->filiere_id= $request->filiere_id;
        $fillier = Filiere::find($request->filiere_id);
        if($fillier == null){
        return response()->json(['error' => "fillier not exist"]);  
        }

        $matiere->save();

        return $matiere;




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return Matiere::find($id);
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
        $matiere = Matiere::find($id);
     
        $matiere->name = $request->name; 
    
        $matiere->filiere_id=$request->filiere_id; 
       
        $matiere->save();
         return  $matiere;
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

    public function matiersbyfilier($id)
    {
         $matieres = Matiere::where('filiere_id',$id)->get();
         return  $matieres;
    }
}
