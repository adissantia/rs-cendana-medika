<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display register page
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle register
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required'],
            'age' => ['required', 'numeric'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE USER
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATE PATIENT CODE
        |--------------------------------------------------------------------------
        */

        $lastPatient = Patient::latest('id')->first();

        $lastNumber = 0;

        if ($lastPatient && $lastPatient->patient_code) {
            $lastNumber = (int) str_replace('P-', '', $lastPatient->patient_code);
        }

        $patientCode = 'P-' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

        /*
        |--------------------------------------------------------------------------
        | CREATE PATIENT
        |--------------------------------------------------------------------------
        */

        Patient::create([
            'user_id'       => $user->id,
            'patient_code'  => $patientCode,
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'gender'        => $request->gender,
            'age'           => $request->age,
            'birth_date'    => $request->birth_date,
            'specialist_id' => null,
            'address'       => $request->address,
            'last_visit'    => null,
            'status'        => 'aktif',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        event(new Registered($user));

        Auth::login($user);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()->route('user.dashboard');
    }
}