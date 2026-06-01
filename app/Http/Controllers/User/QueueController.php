<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class QueueController extends Controller
{
    /**
     * LIST JANJI
     */
    public function index()
{
    $appointments = Appointment::with([
            'doctor.specialist',
            'patient',
            'rating'
        ])
        ->where('patient_id', auth()->user()->patient->id)
        ->latest()
        ->get();

    return view('user.queue.index', compact('appointments'));
}
    /**
     * FORM BUAT JANJI
     */
    public function create()
    {
        $doctors = Doctor::with('specialist')
            ->where('status', 'online')
            ->get();

        return view('user.queue.create', compact('doctors'));
    }

    /**
     * SIMPAN JANJI
     */
    public function store(Request $request)
{
    $request->validate([
        'doctor_id' => 'required',
        'appointment_date' => 'required',
        'appointment_time' => 'required',
        'notes' => 'nullable',
    ]);

    $patient = auth()->user()->patient;

    // nomor antrian harian
    $lastQueue = Appointment::whereDate(
        'appointment_date',
        $request->appointment_date
    )->count();

    $queueNumber = $lastQueue + 1;

    // kode booking
    $bookingCode = 'RS-' . strtoupper(Str::random(6));

    $appointment = Appointment::create([
        'patient_id' => $patient->id,
        'doctor_id' => $request->doctor_id,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,
        'appointment_code' => 'APT-' . strtoupper(Str::random(8)),
        'notes' => $request->notes,
        'status' => 'menunggu',
        'payment_status' => 'pending',
        'queue_number' => $queueNumber,
        'booking_code' => $bookingCode,
        'fee' => 150000,
    ]);

    session()->forget('appointments_seen');    
    return redirect()->route(
        'user.payments.show',
        $appointment->id
    );
}

public function ticket(Appointment $appointment)
{
    return view('user.queue.ticket', compact('appointment'));
}

public function ticketPdf($appointment)
{
    $appointment = \App\Models\Appointment::with([
        'doctor',
        'patient'
    ])->findOrFail($appointment);

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'user.queue.ticket-pdf',
        compact('appointment')
    );

    return $pdf->download('tiket-appointment.pdf');
}

}