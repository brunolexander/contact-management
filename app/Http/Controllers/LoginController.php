<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\Factory as View;

class LoginController extends Controller
{
    public function __construct(
        protected View $view
    ) {}

    public function login()
    {
        return $this->view->make('login');
    }
}
