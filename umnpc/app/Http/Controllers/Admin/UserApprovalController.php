<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->get();
        return view('admin.user-approval', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.user-approval')->with('success', 'User approved successfully!');
    }
}

