<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Http\Controllers\BaseController as BaseController ;

class ProfMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        try {
            
            $user = JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->JWTresponse('Token is Invalid');
               
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
             
             /*  $refreshed = JWTAuth::refresh(JWTAuth::getToken());
               
               $user = JWTAuth::setToken($refreshed)->toUser();
                
                ///header('Authorization: Bearer ' . $refreshed);

              $response = $next($request);*/
             return  $this->JWTresponse('Authorization Token TokenExpiredException');
                
            }else{
                return $this->JWTresponse('Authorization Token not found');
              
            }
        }
         if ( JWTAuth::user()->role_id == 2) {
             return $next($request);
         }
         else {
             return $this->JWTresponse('u are not prof');
         }

       
    }



    public function JWTresponse($error , $code = 401){
        $response = [
            'success' => false ,
            'message' => $error
        ];
      
        return response()->json($response , $code);
        
    }


}
