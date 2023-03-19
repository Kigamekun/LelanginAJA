<?php


namespace App\Http\Middleware;

use Closure;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class apiAuth extends EnsureFrontendRequestsAreStateful
{
    public function handle($request, Closure $next, ...$guards)
    {
        $response = parent::handle($request, $next, ...$guards);

        if ($response->status() == 401) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        return $response;
    }
}
