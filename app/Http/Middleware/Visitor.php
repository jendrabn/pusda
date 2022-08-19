<?php

namespace App\Http\Middleware;

use App\Models\Statistic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {



        if (!$request->cookie($request->path()) && $request->isMethod('get')) {
            $statistic = Statistic::create([
                'ip' => $request->ip(),
            ]);

            // i day =  time() + 86400
            Cookie::queue(Cookie::make($request->path(), $statistic, 10));
        }

        return $next($request);
    }
}
