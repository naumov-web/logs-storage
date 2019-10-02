<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{

    /**
     * Render login form
     *
     * @return View
     */
    public function form() : View
    {
        return view('login.login');
    }

    /**
     * Authorize user
     *
     * @param Request $request
     * @return RedirectResponseAlias|Redirector
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect(route('projects.list'));
        }

        flash('Неверный email или пароль!')->error();
        return response()->view('login.login', [], 401);
    }

    /**
     * Logout user
     *
     * @return RedirectResponseAlias|Redirector
     */
    public function logout()
    {
        Auth::logout();

        return redirect(route('login.form'));
    }
}
