<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\ApiResponse;


class StudentMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use ApiResponse;
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
        auth()->shouldUse('student');
        return $next($request);
    }
    }

