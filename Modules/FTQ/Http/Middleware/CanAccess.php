<?php

namespace Modules\FTQ\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class canAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = DB::connection('ftq')->table('truser_level')->where('user_id', Auth::user()->id)->first();
        if ($user) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
