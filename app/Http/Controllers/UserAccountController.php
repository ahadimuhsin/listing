<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, //diubah valuenya ke bcrypt lewat mutator di model User
        ]);

        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('login')
        ->with('success', 'Account created! You can login now');
    }
}
