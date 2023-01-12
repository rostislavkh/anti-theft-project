<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Security
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
        $is_active = true;

        $path = config('security.url') . '/is-active/' . config('security.slug');

        try {
            $is_active = json_decode(file_get_contents($path)) == false ? false : true;
        } catch (Exception $e) {
            $is_active = true;
        }
        
        if (Route::getCurrentRoute()->getName() != 'security-project' && !$is_active) {
            return redirect()->route('security-project');
        }
        return $next($request);
    }
}
