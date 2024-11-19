<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_approved = true;
            $user->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'User approved successfully.');
    }
}
