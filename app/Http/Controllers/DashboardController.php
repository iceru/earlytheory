<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('user')) {
            return view('dashboard');
        } elseif (Auth::user()->hasRole('administrator')){
            return view('admin.dashboard');
        }
    }
}
