<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Departement;
use App\Http\Resources\FiliereCollection;
class FillereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return FiliereCollection::collection(Filiere::get());
    //   return Departement::find(1)->filiere()->get();
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
        $filiere = new Filiere;
        $filiere->name = $request->name;
        $filiere->departement_id=$request->dept_id;
        $dept = Departement::find($request->dept_id);
        if($dept == null){
        return response()->json(['error' => "departement not exist"]);  
        }

        $filiere->save();
        return  FiliereCollection::collection(Filiere::where('id',$filiere->id)->get());  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $filiere = Filiere::find($id);
        if($request->name != null){
           $filiere->name = $request->name; 
        }
        if($request->dept_id != null){
           $filiere->departement_id=$request->dept_id; 
        } 
        $filiere->save();

        return FiliereCollection::collection(Filiere::where('id',$filiere->id)->get());;

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
