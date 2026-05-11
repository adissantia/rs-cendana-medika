<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;

class HomeController extends Controller
{
    /**
     * DASHBOARD USER
     */
    public function index()
    {
        $doctors = Doctor::with('specialist')
            ->where('status', 'online')
            ->latest()
            ->get();

        $myQueues = Appointment::with('doctor')
            ->where('patient_id', auth()->user()->patient->id)
            ->latest()
            ->get();

        return view('user.dashboard', compact(
            'doctors',
            'myQueues'
        ));
    }

    /**
     * DETAIL DOKTER
     */
    public function showDoctor(Doctor $doctor)
    {
        $doctor->load([
            'specialist',
            'ratings.patient'
        ]);

        return view('user.doctors.show', compact('doctor'));
    }
}