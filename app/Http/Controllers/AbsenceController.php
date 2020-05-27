<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etudiant;
use App\Semestre;
use App\Absence;
class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $absence = new Absence;
        $absence->jour           = $request->jour ;
        $absence->semaine         = $request->semaine;
        if(!$request->seance) {
            return response()->json(['error' => "seances required"]);  
        }  
        $seances	      = $request->seance; 
        $semestre = Semestre::find($request->semestre_id);
        $etudiant = Etudiant::find($request->etudiant_id); 
        if( $etudiant == null || $semestre == null ){

            return response()->json(['error' => "something not exist"]);  
        }
  
        foreach ($seances as $seance) {
        $absence->seance = $seance;
        

        $absenceer = Absence::where('etudiant_id',$etudiant->id)
        ->where('jour',$request->jour)
        ->where('seance',$seance)
        ->where('semaine',$request->semaine)
        ->where('semester_id',$request->semestre_id)
        ->first();

        if( $absenceer == null  ){
            
       
            $absence->semester_id	      = $request->semestre_id; 
            $absence->etudiant_id	      = $request->etudiant_id; 
            $absence->save();
            
           
        
        }
            
            
            
        }

        $absences = Absence::where('etudiant_id',$etudiant->id)
        ->where('jour',$request->jour)
        ->where('semaine',$request->semaine)
        ->where('semester_id',$request->semestre_id)
        ->get();

        $se = array();
        foreach($absences as $absence){
           
           
            array_push($se,$absence->seance);
            
        }
        return response()->json($se); 

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $etudiant = Etudiant::find($id);   
        if( $etudiant == null){
        return response()->json(['error' => "something not exist"]);  
        }else{
            $absences = Absence::where('etudiant_id',$etudiant->id)->get();
        
        return $absences;
        }
        
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
        $absence = Absence::find($id);   
        if($absence == null){
            return response()->json(['error' => " not exist"]);
        }else{
            $absence->delete();
            return response()->json(['succes' => " deleted"]);
        }
    }
    
    public function absences(Request $request){
        $etudiant = Etudiant::find($request->etudiant_id); 
        if( $etudiant == null){
            return response()->json(['error' => "something not exist"]);  
        }
        else{
        $nb_seance = Absence::selectRaw('semester_id,etudiant_id,semaine,jour,count(*) nb_absence')
        ->where('etudiant_id',$etudiant->id)
        ->groupBy('jour')->get();
        
        
        
        
        
        
        return $nb_seance;  
        }
    }



    public function absencesofday(Request $request){
        $etudiant = Etudiant::find($request->etudiant_id); 
        if( $etudiant == null){
            return response()->json(['error' => "something not exist"]);  
        }
        else{
        $absences = Absence::where('etudiant_id',$etudiant->id)
        ->where('jour',$request->jour)
        ->where('semaine',$request->semaine)
        ->where('semester_id',$request->semestre_id)
        ->get();

        $se = array();
        foreach($absences as $absence){
           
           
            array_push($se,$absence->seance);
            
        }
        return response()->json($se);  
        }
    }
    


}