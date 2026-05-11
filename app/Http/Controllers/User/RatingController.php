<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create(Appointment $appointment)
    {
        return view('user.rating.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        Rating::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => $appointment->doctor_id,
            'patient_id' => $appointment->patient_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        $appointment->update([
            'status' => 'selesai'
        ]);

        return redirect()
            ->route('user.queue.index')
            ->with('success', 'Rating berhasil dikirim.');
    }
}