<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppVueController extends Controller
{
    /**
     * Shows the application dashboard.
     *
     * @return ViewAlias
     */
    public function index()
    {
        return view('app-vue', [
            'auth_user' => Auth::user()
        ]);
    }
}
