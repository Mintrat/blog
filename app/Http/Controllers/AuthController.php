<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('pages.register');
    }

    public function loginForm()
    {
        return view('pages.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::add($request->all());
        $user->generatePassword($request->get('password'));
        return redirect('/login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $loggedIn = Auth::attempt(
            [
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ]
        );
        if ($loggedIn) {
            return redirect('/');
        }

        return redirect()->back()->with('status', 'Incorrect login or password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
