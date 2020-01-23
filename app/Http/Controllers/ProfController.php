<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prof;
use Validator;
class ProfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           return Prof::get();
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
        $validator = Validator::make($request -> all(),[
        'email' => 'required|string|email|max:255|unique:profs',
        'fullname' => 'required'
       ]);
       if ($validator -> fails()) {          
           return response()->json(['error' => $validator->errors()]);   
       }

        $prof = new Prof;
        $prof->fullname=$request->fullname;
        $prof->email=$request->email;
        // $prof->password=$request->password;
        $prof->save();
        return response()->json(['succed' => "all is good"]); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Prof::find($id);
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
        $prof = Prof::find($id);
        $prof->email = $request->email;
        $prof->save();

        return $prof;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prof = Prof::find($id);
        $prof->delete();

        return response()->json(['succed' => "deleted succesfully"]); 
    }
}