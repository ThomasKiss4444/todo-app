<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class XssSanitizer
{
    const ALLOWED_TAGS = 'div,b,strong,i,em,u,a,ul,ol,li,p,br,span,img';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input, self::ALLOWED_TAGS);
        });

        $request->merge($input);

        return $next($request);
    }
}
