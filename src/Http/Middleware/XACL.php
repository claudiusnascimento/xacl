<?php

namespace ClaudiusNascimento\XACL\Http\Middleware;

use Closure;

class XACL
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

        return \XACL::hasPermission($request) ?
                    $next($request) :
                    redirect()->route(\XACL::getRedirectRoute());
    }
}
