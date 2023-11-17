<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth; // Make sure to include this line
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException, JWTException};
use App\Http\Controllers\ApiResponse;
class AdminMid
{
    use ApiResponse;
    /**AApiResponse
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard=null): Response
    {
       
       
        try {
            JWTAuth::parseToken()->authenticate(); 
        } catch (TokenExpiredException $e) {
            return $this->Response('','Token Expired',401);
        } catch (TokenInvalidException $e) {
            return $this->Response('','Token Invalid',401);
        } catch (JWTException $e) {
            return $this->Response('','JWT Exception',401);
        }
        $user=auth($guard)->user();
        if(!$user)
        {
            return $this->Response('','Unauthorized',403);
        }
        auth()->shouldUse('admin');

        return $next($request);
    }
}
