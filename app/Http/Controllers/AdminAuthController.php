<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (!Auth::user()->hasRole('admin')) {
                Auth::logout();
                return back()->withErrors(['message' => 'Do not have admin access.']);
            }
            $request->session()->regenerate();
            return redirect()->route('users.index');
        }
        return back()->withErrors(['message' => 'invalid email or password']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
