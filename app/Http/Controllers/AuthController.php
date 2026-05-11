<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // cek login
        if (!Auth::attempt($credentials)) {

            return back()->with(
                'error',
                'Email atau password salah.'
            );
        }

        // regenerate session
        $request->session()->regenerate();

        // cek role
        if (auth()->user()->role === 'admin') {

            return redirect()
                ->route('admin.dashboard');
        }

        // user biasa
        return redirect()
            ->route('user.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:6'
            ],
        ]);

        // create user
        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => 'user',
        ]);

        // auto login
        Auth::login($user);

        // redirect user dashboard
        return redirect()
            ->route('user.dashboard');
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}