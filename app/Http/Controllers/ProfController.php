<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prof;
use Validator;
use App\Http\Controllers\BaseController as BaseController ;
class ProfController extends BaseController
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

    public function search(Request $request)
    {
        


             $list = Prof::where('fullname', 'like', '%' . $request->keyword . '%')->get(); 
             return $this->sendResponse($list->toArray(), 'profs');

       
       

        
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
        return response()->json($prof); 

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
        $prof->fullname = $request->fullname;
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

    public function emailexist($email){
       return $this->emailexistance($email);
    }

    protected function emailexistance($email){
        $countemail = Prof::where('email', $email)->count();

        if ($countemail == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }
    public function emailexistUpdate($id , $email){
        $countemail = Prof::where(['email'=> $email ,'id'=>$id])->count();

        if ($countemail == 1) {
            return response()->json(['exist' => false]); 
        }else{
            return $this->emailexistance($email); 
        }
    }


}
