<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory as View;
use Illuminate\Auth\AuthManager as Auth;
use Illuminate\Validation\Factory as Validator;

class LoginController extends Controller
{
    public function __construct(
        protected View $view,
        protected Auth $auth,
        protected Validator $validator
    ) {}

    /**
     * Login page
     */
    public function login()
    {
        if ($this->auth->check())
        {
            return redirect('/');
        }

        return $this->view->make('login');
    }

    /**
     * Perform user sign in
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        if ($this->auth->attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Perform user sign out
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->auth->logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}