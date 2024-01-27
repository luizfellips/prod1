<?php
 
namespace App\Http\Middleware;

use \Closure;
use App\Http\Request;
use App\Http\Response;

class Maintenance {
    /**
     * @param Request $request
     * @param Closure $next
     * 
     * @return Response
     */
    public function handle($request, $next) {
        if(getenv('MAINTENANCE') === 'true') {
            throw new \Exception ("Currently under maintenance. Try again later", 200);
        }
        return $next($request);
    }
}