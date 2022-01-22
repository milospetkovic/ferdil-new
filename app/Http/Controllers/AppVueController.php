<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Http\Request;

class AppVueController extends Controller
{
    /**
     * Shows the application dashboard.
     *
     * @return ViewAlias
     */
    public function index()
    {
        return view('app-vue');
    }
}
