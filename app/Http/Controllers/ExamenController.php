<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmploiExamen;
use Illuminate\Support\Facades\Storage;

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
            $emploiExamen->filiere_id = $request->filiere_id;
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

        if($file = $request->file('emploiExamen')){
            unlink(public_path() . $emploiExamen->examen);

            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiExamen->examen = '/examens/'. $name;
             
             $emploiExamen->filiere_id = $request->filiere_id;
             
             $user->emploiExamens()->save($emploiExamen);
         

        

          return response()->json([
            'EmploiExamens',EmploiExamen::all()
            ]);

            
        }else {
            $file = $request->file('emploiExamen');
            return response()->json(['error' =>$file->getClientOriginalName()]);  
            
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
