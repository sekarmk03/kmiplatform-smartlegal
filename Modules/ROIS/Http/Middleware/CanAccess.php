<?php

namespace Modules\ROIS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = DB::connection('roonline')->table('truser_level')->where('user_id', Auth::user()->id)->first();
        if ($user) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
