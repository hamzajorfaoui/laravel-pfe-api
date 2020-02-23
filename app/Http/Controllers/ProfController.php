<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prof;
use App\User;
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
       
        'fullname' => 'required'
       ]);
       if ($validator -> fails()) {          
           return response()->json(['error' => $validator->errors()]);   
       }

  
        $user = new User; 
        $user->role_id = $request->get('role_id');              
            
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();
        $prof = $user->prof()->create([
                'fullname'   => $request->fullname,
                'departement_id'   => $request->departement_id,
         ]);




        return response()->json([$user,$prof]); 

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


        

        $user = User::find($id);
        $prof=$user->prof;
        $user->email = $request->email;
        $user->password = $request->password;
        $prof->fullname = $request->fullname;
        $prof->departement_id = $request->departement_id;
        $prof->phone = $request->phone;
        $user->prof()->save($prof);

        return User::with('prof')->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['succed' => "deleted succesfully"]); 
    }

    public function emailexist($email){
       return $this->emailexistance($email);
    }

    protected function emailexistance($email){
        $countemail = User::where('email', $email)->count();

        if ($countemail == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }
    public function emailexistUpdate($id , $email){
        $countemail = User::where(['email'=> $email ,'id'=>$id])->count();

        if ($countemail == 1) {
            return response()->json(['exist' => false]); 
        }else{
            return $this->emailexistance($email); 
        }
    }


}
