<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class CpnAuthenticate
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
                return redirect()->guest('company/login');
            }
        }
        $user = Auth::user();
        if($user->user_type_code_abbr !== 'CPN'){
            Auth::logout();
            Flash::error('此帳號並非企業帳號，若要登入企業管理後台，請重新登入對應之企業帳號');
            return redirect()->route('cpn.login');
        }


        return $next($request);
    }
}
