<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $allowedOrigins = ['https://regionloreto.gob.pe'];

    public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->header('origin');
        if( in_array($origin, $this->allowedOrigins)){
            return $next($request);
        }
        
        response()->json(['status'=> 'error', 'message' => 'Not Allowed'], 403);
    }
}
