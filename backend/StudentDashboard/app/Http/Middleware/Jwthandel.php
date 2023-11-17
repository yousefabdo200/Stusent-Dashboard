<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth; // Make sure to include this line
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException, JWTException};

class Jwthandel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard=null): Response
    {
        auth()->shouldUse($guard);
        try {
            JWTAuth::parseToken()->authenticate();    
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token Expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token Invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'JWT Exception'], 401);
        }
    
        return $next($request);
    }
}
