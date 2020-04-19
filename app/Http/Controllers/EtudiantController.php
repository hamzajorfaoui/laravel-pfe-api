<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etudiant;
use App\Filiere;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Mail;
use App\Verification;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Http\Resources\ProfileCollection;
use App\Http\Controllers\BaseController as BaseController ;
class EtudiantController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Etudiant::get();
    }

    public function etudbyfiliere($filiere_id)
    {
        return Etudiant::WHERE('filiere_id',$filiere_id)
                              ->get();
    }
    public function search(Request $request)
    {
        if ($request->column == 'cin' || $request->column == 'cne' || $request->column == 'fullname'   ) {


             $list = Etudiant::where($request->column , 'like', '%' . $request->keyword . '%')->get(); 
             return $this->sendResponse($list->toArray(), 'etudiants');

        }else {

             return response()->json(['error' => ""]);  
            
        }
       

        
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
        $etudiant = new Etudiant;
        $etudiant->fullname = $request->fullname;
        $etudiant->cin	    = $request->cin;
        $etudiant->cne      = $request->cne;
        $user = new User;
        
        $user->email = $request->cne .'@ests.com';
        $user->password = Str::random(8);

        $user->role_id = 3;  
        $filiere = Filiere::find($request->filiere_id);
        if($filiere == null){
        return response()->json(['error' => "fillier not exist"]);  
        }else{
        $etudiant->filiere_id=$request->filiere_id;
         $user->save();
        $user->etudiant()->save($etudiant);
        return $etudiant;  
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
        return Etudiant::find($id);
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

     

    $etudiant = Etudiant::where('user_id', $id);
    if($request->fullname != null){
         $etudiant->fullname = $request->fullname;  
    }
     if($request->cin != null){
        $etudiant->cin	    = $request->cin; 
     }
     if($request->cne != null){
        $etudiant->cne      = $request->cne;
     }
     $filiere = Filiere::find($request->filiere_id);
    //  if($request->filiere_id != null){
    //     $filiere = Filiere::find($request->filiere_id);
    //     if($filiere == null){
    //     return response()->json(['error' => "departement not exist"]);  
    //     }
    //  }
         $etudiant->save();
         return $this->sendResponse($etudiant, 'etudiant updated');

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

    public function cneexiste($cne)
    {
        $etuds = Etudiant::where('cne', $cne)->count();

        if ($etuds == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }

    public function cinexiste($cin)
    {
        $etuds = Etudiant::where('cin', $cin)->count();

        if ($etuds == 0) {
            return response()->json(['exist' => false]); 
        }else{
            return response()->json(['exist' => true]); 
        }
    }
    
    
    public function etudiantwithcompte($id){
        
         $etudiant = Etudiant::with('user')->find($id);
          $user = User::find($etudiant->user_id);

          if($user->email_verified_at == null){

            $etudiant['user']['pwd'] =  $user->password ;
           
            return $etudiant;
          }else{
            $etudiant['user']['pwd'] = null ;
           
            return $etudiant;
          }

         
        
    }



    public function login(Request $request)
    {

 
        $validator = Validator::make($request -> all(),[
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
           ]);
           if ($validator -> fails()) {
               # code...
               return response()->json(['error' => $validator->errors()]);
          
               
           }
         

          if (strpos($request->email, '@ests.com') !== false) {
                           






            $user = User::where('email','=',$request->email)
                        ->where('password','=',$request->password)
                        ->where('role_id','=',3)
                        ->first();
            if ($user == null) {
            return response()->json(['error' => 'Email or password does\'t exist'], 401);
            }else {
                

                return response()->json(['etudiant' => $user] );
            }

        }else {
        $request['role_id'] =  3 ;
        $credentials = request(['email', 'password','role_id']);

        JWTAuth::factory()->setTTL(60*24*30);
        if (!$token = JWTAuth::attempt($credentials)) {

            return response()->json(['error' => 'Email or password does\'t exist'], 401);
        }
        
        return $this->respondWithToken($token);
            
        }    

    }

        public function me()
    {
        
        return response()->json(auth()->user()->etudiant);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        return response()->json([
            'access_token' => $token,           
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
            'user' =>  auth()->user()
        ]);
    }


    protected function sendcodetoemail(Request $request)
    {

        $iduser = $request->id;
        $user = User::find($iduser);
        $verification_code = Str::random(5);         
        $verf = new Verification;
        $verf->code = $verification_code;
        $verf->email =  $request->email;


        if ($user != null) {

        $verftest = Verification::where('user_id','=',$iduser);
        if( $verftest != null){

            $verftest->delete();
        }

        $user->verifications()->save($verf);

        $to_name = $user->etudiant->fullname;
        $to_email = $request->email;

         $cmpt = User::where('email',$to_email)->count();

         if ($cmpt == 0) {
              Mail::send('emails.mail', ['name' => $to_name, 'verification_code' => $verification_code], function($message) use ($to_name, $to_email) {
             $message->to($to_email)
                     ->subject('Artisans Web Testing Mail');
             $message->from('estsupp@gmail.com');
          });

           return 'email verfication sended';
         }else {
            return 'email deja existe';
         }
        

    
        
        }else {
             return 'user not found';
            
        }
         

    }

    protected function verfiyemail(Request $request)
    {
        $iduser = $request->id;
        $code = $request->code;
        $user = User::find($iduser);
        $verf = Verification::where('user_id',$user->id)->first();

       if ($verf == null) {
        return response()->json(['err' => "err"] );
        }
        if ($verf->code == $code ) {
            return response()->json(['is_verfied' => true] );
        }else {
            return response()->json(['is_verfied' => false] );
        }

 
    }

    public function upetudiant(Request $request)
    {
        
        $iduser = $request->id;
        $user = User::find($iduser);
        $verftest = Verification::where('user_id','=',$iduser)->first();

        $user->email = $verftest->email;
        $request['email'] =  $user->email ;
        $user->password = bcrypt($request->password);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        
        $verftest = Verification::where('user_id','=',$iduser);
        if( $verftest != null){

            $verftest->delete();
        }

        return $this->login($request);
  
 
    }

     protected function myprofile()
    {

        $id = auth('api')->user()->id;
        $etudiant = Etudiant::where('user_id',$id)->get();
        return  ProfileCollection::collection($etudiant) ;
   
 
    }





}
