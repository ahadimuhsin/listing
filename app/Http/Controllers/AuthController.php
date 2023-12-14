<?php

namespace App\Http\Controllers;

use Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (!Auth::attempt($login, true)) {
            throw ValidationException::withMessages(
                ['email' => 'Email or password is not correct']
            );
        }

        $request->session()->regenerate();
        return redirect()->intended('/listing');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index');
    }
}
