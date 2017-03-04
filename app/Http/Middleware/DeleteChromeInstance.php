<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\ScrapperController;

class DeleteChromeInstance
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
         return $next($request);
     }

     public function terminate($request, $response)
     {
         ScrapperController::closeAll();
     }
}
