<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planing;

class PlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
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
       $plan  = new Planing;

       $plan->date_debut = $request->date_debut;
       $plan->date_semester =$request->date_semester;
       $plan->date_fin=$request->date_fin;

        $plan->save();

        return $plan;

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Planing::find($id);
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
       $plan =   Planing::find($id);
 
     
      
       if ($request->date_debut != null) {
         $plan->date_debut = $request->date_debut;
       }
       if ($request->date_semester != null) {
          $plan->date_semester =$request->date_semester;
       }
       if ($request->date_fin != null) {
         $plan->date_fin=$request->date_fin;
       }

        $plan->save();
         return $plan;
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
