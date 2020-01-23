<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;
use App\EmploiTemp;

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
        $temps = EmploiTemp::all();

        return $this->sendResponse($temps->toArray(), 'stores Of user');
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

        if($file = $request->file('emploiExamen')){
            $name = time() . $file->getClientOriginalName();
            $file->move('examens', $name);
            $emploiTemp->filiere_id = $request->filiere_id;
            $emploiTemp->temp = $name;
            $user->emploiTemps()->save($emploiTemp);

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
        $emploiTemp = EmploiTemp::findOrFail($id);

        
        unlink(public_path() . $emploiTemp->temp);

        $emploiTemp->delete();
    }
}
