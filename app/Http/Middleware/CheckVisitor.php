<?php

namespace App\Http\Middleware;

use App\Models\Statistic;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;

class CheckVisitor
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
        $agent = new Agent();
        $platform = $agent->platform();
        $browser = $agent->browser();

        if (!$request->cookie('visitor')) {
            $visitor =  Statistic::create([
                'ip' => $request->ip(),
                'os' => "{$platform} v.{$agent->version($platform)}",
                'browser' => "{$agent->browser()} v.{$agent->version($browser)}"
            ]);

            // i day =  time() + 86400
            Cookie::queue(Cookie::make('visitor', $visitor, 60));
        }

        return $next($request);
    }
}
