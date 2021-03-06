<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departement;

use App\Filiere;

use App\Http\Controllers\BaseController as BaseController ;
class DepartementController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Departement::get();
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
        $dept = new Departement;
        $dept->name=$request->name;
        $dept->save();
    
        return $dept;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Departement::find($id);
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
        $dept =  Departement::find($id);
        $dept->name=$request->name;
        $dept->save();

        return $dept;
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
    public function nameexist($name)
    {
        $countname = Departement::where('name', $name)->count();

        if ($countname == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }


    public function departementwithfiliers()
    {
        $departements = Departement::with('filiere')->get();

         return $this->sendResponse($departements->toArray(), 'departements');

    }
}
