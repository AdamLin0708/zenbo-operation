<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('teacher/login');
            }
        }
        $user = Auth::user();
        if($user->user_type_code_abbr !== 'TCH'){
            Auth::logout();
            Flash::error('此帳號並非講師帳號，若要登入講師管理後台，請重新登入對應之講師帳號');
            return redirect()->route('tch.login');
        }

        return $next($request);
    }
}
