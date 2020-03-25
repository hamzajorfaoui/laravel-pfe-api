<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmploiExamen;
use Illuminate\Support\Facades\Storage;
use App\Filiere;
use App\Semestre;

use App\Http\Controllers\BaseController as BaseController ;
class ExamenController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return response()->json([
            'EmploiExamens',EmploiExamen::all()
            ]);
            
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

                    
            //$urll = url('/examens/'.  $name);

       
          $id=auth('api')->user()->id;

          $user = User::find($id);

          $emploiExamen = new EmploiExamen;

        if($file = $request->file('emploiExamen')){
            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiExamen->examen = '/examens/'. $name;
            
            $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "fillier not exist"]);  
        }else{

            $emploiExamen->filiere_id = $request->filiere_id;
        }

        $semester = Semestre::find($request->semester_id);
        if($semester == null){
        return response()->json(['error' => "semester not exist"]);  
        }else{

           $emploiExamen->semester_id = $request->semester_id;
        }

            $user->emploiExamens()->save($emploiExamen);

            

            return response()->json([
            'EmploiExamens',EmploiExamen::all()
            ]);

            
        }else {
            return response()->json(['error' => "err"]);  
            
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
        $emploiExamen = EmploiExamen::find($id);
        return $this->sendResponse($emploiExamen, 'emploiExamen');
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
       

         
    }





    public function modifiy(Request $request, $id)
    {
        $idu=auth('api')->user()->id;

        $user = User::find($idu);
        
        $emploiExamen = EmploiExamen::find($id);
        if ( $emploiExamen != null) {
        if($file = $request->file('emploiExamen')){
            unlink(public_path() . $emploiExamen->examen);

            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiExamen->examen = '/examens/'. $name;
             
            
        }
        if ($request->filiere_id != null ) {
        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "fillier not exist"]);  
        }else{

            $emploiExamen->filiere_id = $request->filiere_id;
        }
        }

         if ($request->semester_id != null) {
        $semester = Semestre::find($request->semester_id);
        if($semester == null){
        return response()->json(['error' => "semester not exist"]);  
        }else{

           $emploiExamen->semester_id = $request->semester_id;
        }
        }


         $user->emploiExamens()->save($emploiExamen);
         return response()->json([
            'EmploiExamens',EmploiExamen::all()
            ]);
}else {
    return response()->json(['error' => "Emplois du examens not found"]); 
}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emploiExamen = EmploiExamen::findOrFail($id);

        
        unlink(public_path() . $emploiExamen->examen);

        $emploiExamen->delete();
    }
}
