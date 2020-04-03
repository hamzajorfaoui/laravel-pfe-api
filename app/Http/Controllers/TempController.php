<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;
use App\EmploiTemp;
use App\Filiere;
use App\Semestre;
use App\Http\Resources\TempCollection;
use App\Http\Controllers\BaseController as BaseController ;
class TempController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TempCollection::collection(EmploiTemp::get());
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

          $emploiTemp = new EmploiTemp;

        if($file = $request->file('emploitemp')){
            $name = time() . $file->getClientOriginalName();
            $file->move('temps', $name);
            
            
        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "fillier not exist"]);  
        }else{

            $emploiTemp->filiere_id = $request->filiere_id;
        }

        $semester = Semestre::find($request->semester_id);
        if($semester == null){
        return response()->json(['error' => "semester not exist"]);  
        }else{

           $emploiTemp->semester_id = $request->semester_id;
        }


            $emploiTemp->temp ='/temps/'. $name;
            $user->emploiTemps()->save($emploiTemp);

             return TempCollection::collection(EmploiTemp::get());

        }else {
            return response()->json(['error' => "err"]);  
            
        }
    }


    public function modifiy(Request $request, $id)
    {
        $idu=auth('api')->user()->id;

        $user = User::find($idu);
      
        $emploiTemp = EmploiTemp::find($id);

        if ( $emploiTemp != null) {
            
        
         
        if($file = $request->file('emploitemp')){
            unlink(public_path() . $emploiTemp->temp);

            $name = time() . $file->gebtClientOriginalName();
            $file->move('temps', $name);
            $emploiTemp->temp ='/temps/'. $name;
                
            
        }

        if ($request->filiere_id != null ) {
        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "fillier not exist"]);  
        }else{

            $emploiTemp->filiere_id = $request->filiere_id;
        }
        }

         if ($request->semester_id != null) {
        $semester = Semestre::find($request->semester_id);
        if($semester == null){
        return response()->json(['error' => "semester not exist"]);  
        }else{

           $emploiTemp->semester_id = $request->semester_id;
        }
        }
       

         $user->emploiTemps()->save($emploiTemp);
         return TempCollection::collection(EmploiTemp::get());

}else {
    return response()->json(['error' => "Emplois du temps not found"]);  
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
        $emploiTemp = EmploiTemp::find($id);
        return $this->sendResponse($emploiTemp, 'emploiExamen');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        
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
        $emploiTemp = EmploiTemp::findOrFail($id);

        
        unlink(public_path() . $emploiTemp->temp);

        $emploiTemp->delete();
    }
}
