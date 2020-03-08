<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

use Illuminate\Support\Facades\Storage;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
  
    /** 
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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

        $credentials = request(['email', 'password']);
        //   JWTAuth::factory()->setTTL(1);
        if (!$token = JWTAuth::attempt($credentials)) {

            return response()->json(['error' => 'Email or password does\'t exist'], 401);
        }



        return $this->respondWithToken($token);
    }


    public function signup(Request $request)
    {
        $validator = Validator::make($request -> all(),[
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
           ]);
           if ($validator -> fails()) {
               
               return response()->json(['error' => $validator->errors()]);
               
           }

           
            $user = new User; 
            $user->role_id = $request->get('role_id');              
            
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->save();
            $user->admin()->create([
                'fullname'   => $request->name,
            ]);
           
           
        return $this->login($request);
    }

        public function uplaoder(Request $request)
    {
       Storage::disk('s3')->put('test.txt', 'Hello World');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
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
            'user' =>  JWTAuth::user()->role_id
        ]);
    }
}

