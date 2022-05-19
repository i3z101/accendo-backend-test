<?php

namespace App\Http\Middleware;

use Ahc\Jwt\JWT;
use Ahc\Jwt\JWTException;
use App\Helper\Helper;
use Closure;
use Exception;
use Illuminate\Http\Request;

class AuthorizationMiddleware
{




    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $jwt = new JWT('secret', 'HS256', 3600, 10);
            $token = $request->header("token");
            if(!$token || $token == null) {
                return Helper::returnResponse("You are not authorized", [], 422);
            }
            $decodedToken = $jwt->decode($token);
            if(!$decodedToken) {
                return Helper::returnResponse("You are not authorized", [], 422);
            }
            $request->teacherId = $decodedToken["teacherId"];
            return $next($request);
        }catch(Exception $error) {
            return Helper::returnResponse("You entered an invalid token or expired one", [
                "error" => $error->getMessage()
            ], 500);
        }
    }
}
