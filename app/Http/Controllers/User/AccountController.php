<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ACCOUNT PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();

        $patient = $user->patient;

        return view('user.account.index', compact('user', 'patient'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PAGE
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        $user = Auth::user();

        $patient = $user->patient;

        return view('user.account.edit', compact('user', 'patient'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'gender'     => 'nullable|string',
            'age'        => 'nullable|numeric',
            'birth_date' => 'nullable|date',
            'address'    => 'nullable|string',
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | UPDATE USER
        |--------------------------------------------------------------------------
        */

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE PATIENT
        |--------------------------------------------------------------------------
        */

        if ($user->patient) {

            $user->patient->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'gender'     => $request->gender,
                'age'        => $request->age,
                'birth_date' => $request->birth_date,
                'address'    => $request->address,
            ]);
        }

        return redirect()
            ->route('user.account.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}