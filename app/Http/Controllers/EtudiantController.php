<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etudiant;
use App\Filiere;
use App\User;
use Illuminate\Support\Str;

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
        $user = new User;
        
        $user->email = $request->cne .'@ests.com';
        $user->password = Str::random(8);

        $user->role_id = $request->get('role_id');  
        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "departement not exist"]);  
        }else{
        $etudiant->filiere_id=$request->filiere_id;
         $user->save();
        $user->etudiant()->save($etudiant);
        return $etudiant;  
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

     

    $etudiant = Etudiant::where('user_id', $id);
    if($request->fullname != null){
         $etudiant->fullname = $request->fullname;  
    }
     if($request->cin != null){
        $etudiant->cin	    = $request->cin; 
     }
     if($request->cne != null){
        $etudiant->cne      = $request->cne;
     }
     $filiere = Filiere::find($request->filiere_id);
    //  if($request->filiere_id != null){
    //     $filiere = Filiere::find($request->filiere_id);
    //     if($filiere == null){
    //     return response()->json(['error' => "departement not exist"]);  
    //     }
    //  }
         $etudiant->save();
         return $this->sendResponse($etudiant, 'etudiant updated');

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

    public function cneexiste($cne)
    {
        $etuds = Etudiant::where('cne', $cne)->count();

        if ($etuds == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }

    public function cinexiste($cin)
    {
        $etuds = Etudiant::where('cin', $cin)->count();

        if ($etuds == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }
    
    
    public function etudiantwithcompte($id){
        
         $etudiant = User::with('etudiant')->find($id);
         return $this->sendResponse($etudiant, 'etudiant');
        
    }



}
