<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of members.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $members = \App\Models\User::where('role', 'member')->get(); // Adjust query as needed

        return view('members.index', compact('members'));
    }
}
