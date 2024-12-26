<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function welcome()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->is_approved) {
                return redirect()->route('not-approved');
            }

            return $user->roles === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.profile');
        }

        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_approved) {
                Auth::logout();
                return redirect()->route('not-approved')
                    ->with('error', 'Akun Anda belum disetujui.');
            }

            return $user->roles === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.profile');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Kredensial yang diberikan tidak cocok.'])
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function notApproved()
    {
        return view('not-approved');
    }

    public function fallback()
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        if (!Auth::user()->is_approved) {
            return redirect()->route('not-approved');
        }

        return redirect()->route('user.profile');
    }
}