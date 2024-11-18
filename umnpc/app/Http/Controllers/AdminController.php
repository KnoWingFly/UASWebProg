<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveUser($id)
    {
    $user = User::findOrFail($id);
    $user->is_approved = true;
    $user = User::where('role', 'member')->get();
    $user->save();

    return redirect()->back()->with('success', 'User approved successfully.');
    }
}
