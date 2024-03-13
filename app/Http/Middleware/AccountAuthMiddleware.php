<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('account')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('account')->user();

        $accountType = $user->__get('account_type');
        $directory = str_replace('/', '', $request->route()->getAction('prefix'));

        $access = false;

        if ($accountType === 'Employer' && $directory === 'employer') {
            $access = true;
        }

        if ($accountType === 'Job Seeker' && $directory === 'job-seeker') {
            $access = true;
        }

        if ($access === false) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
