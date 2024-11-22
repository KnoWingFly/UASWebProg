<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userdash extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }
}