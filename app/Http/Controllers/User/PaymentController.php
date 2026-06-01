<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class PaymentController extends Controller
{
    public function show(Appointment $appointment)
    {
        return view('user.payments.show', compact('appointment'));
    }

    public function pay(Appointment $appointment)
    {
        $appointment->update([
            'payment_status' => 'paid',
            'status' => 'terkonfirmasi',
        ]);

        return redirect()
        ->route('user.queue.index')
        ->with('success', 'Pembayaran berhasil!');
    }

    public function ticket(Appointment $appointment)
    {
        return view('user.ticket', compact('appointment'));
    }

        public function index()
{
    $appointments = \App\Models\Appointment::with('doctor')
        ->where('patient_id', auth()->user()->patient->id)
        ->latest()
        ->get();

    return view('user.payments.index', compact('appointments'));
}
}