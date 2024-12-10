<?php

// app/Http/Controllers/UserProfileController.php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Make sure to use the base controller
use Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.Profile.index', compact('user'));
    }
}



