<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmploiExamen;

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
        $examens = EmploiExamen::all();

        return $this->sendResponse($examens->toArray(), 'stores Of user');
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

          $emploiExamen = new EmploiExamen;

        if($file = $request->file('emploiExamen')){
            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiExamen->examen = $name;
            $user->emploiExamens()->save($emploiExamen);

            return response()->json(['succed' => " good"]);

            
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
        $idu=auth('api')->user()->id;

        $user = User::find($idu);
        
        $emploiExamen = EmploiExamen::find($id);

        if($file = $request->file('emploiExamenn')){
            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiExamen->examen = $name;
            $emploiExamen->update();

            return response()->json(['succed' => "updated good"]);

            
        }else {
            return response()->json(['error' => "err up"]);  
            
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
