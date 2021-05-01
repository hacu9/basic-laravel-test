<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrivateResource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $resource_name
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $resource_name)
    {
        if($request->{$resource_name}->is_published || $request->user()->id == $request->{$resource_name}->user_id){
            return $next($request);
        }

        abort(403, 'Invalid Request');
    }
}
