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
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes'            => 'nullable',
        ]);

        $patient = auth()->user()->patient;

        $time = $request->appointment_time;

        /*
        |--------------------------------------------------------------------------
        | JAM OPERASIONAL
        |--------------------------------------------------------------------------
        */
        if ($time < '08:00' || $time > '16:00') {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                        'Janji temu hanya bisa dari jam 08:00 - 16:00.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | MAX SLOT DOKTER
        |--------------------------------------------------------------------------
        */
        $maxSlot = 3;

        $totalAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->count();

        if ($totalAppointment >= $maxSlot) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment_time' =>
                        'Slot dokter pada jam tersebut sudah penuh.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NOMOR ANTRIAN
        |--------------------------------------------------------------------------
        */
        $lastQueue = Appointment::whereDate(
            'appointment_date',
            $request->appointment_date
        )->count();

        $queueNumber = $lastQueue + 1;

        /*
        |--------------------------------------------------------------------------
        | KODE BOOKING
        |--------------------------------------------------------------------------
        */
        $bookingCode = 'RS-' . strtoupper(Str::random(6));

        /*
        |--------------------------------------------------------------------------
        | APPOINTMENT CODE
        |--------------------------------------------------------------------------
        */
        $appointmentCode = 'APT-' . now()->format('YmdHis');

        /*
        |--------------------------------------------------------------------------
        | SIMPAN APPOINTMENT
        |--------------------------------------------------------------------------
        */
        $appointment = Appointment::create([

            'appointment_code' => $appointmentCode,

            'patient_id'       => $patient->id,
            'doctor_id'        => $request->doctor_id,

            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,

            'notes'            => $request->notes,

            'status'           => 'menunggu',
            'payment_status'   => 'pending',

            'queue_number'     => $queueNumber,
            'booking_code'     => $bookingCode,

            'fee'              => 150000,
        ]);

        session()->forget('appointments_seen');

        return redirect()->route(
            'user.payments.show',
            $appointment->id
        );
    }

    /**
     * TIKET
     */
    public function ticket(Appointment $appointment)
    {
        return view('user.queue.ticket', compact('appointment'));
    }
}