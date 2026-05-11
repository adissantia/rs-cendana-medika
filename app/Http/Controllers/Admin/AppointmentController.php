<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        session([
            'last_seen_appointments' => now()
        ]);

        $query = Appointment::with([
            'patient',
            'doctor.specialist',
            'room'
        ]);

        // Search pasien
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter dokter
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter periode
        if ($request->period === 'today') {
            $query->whereDate('appointment_date', today());
            $currentDate = now()->translatedFormat('d F Y');
        } elseif ($request->period === 'week') {
            $query->whereBetween('appointment_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]);
            $currentDate = 'Minggu Ini';
        } else {
            $currentDate = 'Semua Jadwal';
        }

        $appointments = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $totalToday = Appointment::count();
        $confirmed  = Appointment::where('status', 'terkonfirmasi')->count();
        $waiting    = Appointment::where('status', 'menunggu')->count();
        $cancelled  = Appointment::where('status', 'dibatalkan')->count();

        $doctors = Doctor::with('specialist')->orderBy('name')->get();

        return view('admin.appointments.index', compact(
            'appointments',
            'doctors',
            'totalToday',
            'confirmed',
            'waiting',
            'cancelled',
            'currentDate'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();

        $doctors = Doctor::with('specialist')
            ->where('status', 'online')
            ->orderBy('name')
            ->get();

        $rooms = Room::where('is_active', true)->get();

        return view('admin.appointments.create', compact(
            'patients',
            'doctors',
            'rooms'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'room_id'          => 'nullable|exists:rooms,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'fee'              => 'required|numeric|min:0',
            'payment_status'   => 'required|in:pending,paid',
            'notes'            => 'nullable|string|max:500',
        ]);

        $time = $request->appointment_time;

        // Jam operasional RS
        if ($time < '08:00' || $time > '16:00') {

        return back()
        ->withInput()
        ->withErrors([
            'appointment_time' =>
                'Janji temu hanya bisa dari jam 08:00 - 16:00.'
        ]);
    }
    // Maksimal pasien per jam
$maxSlot = 3;

// Hitung appointment dokter di jam yang sama
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

        Appointment::create([
            'appointment_code' => 'APT-' . now()->format('YmdHis'),
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'room_id'          => $request->room_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => 'menunggu',
            'payment_status'   => $request->payment_status,
            'fee'              => $request->fee,
            'notes'            => $request->notes,
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Jadwal temu berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Appointment $appointment)
    {
        $appointment->load([
            'patient',
            'doctor.specialist',
            'room'
        ]);

        return view('admin.appointments.show', compact('appointment'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('name')->get();

        $doctors = Doctor::with('specialist')
            ->where('status', 'online')
            ->orderBy('name')
            ->get();

        $rooms = Room::where('is_active', true)->get();

        return view('admin.appointments.edit', compact(
            'appointment',
            'patients',
            'doctors',
            'rooms'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status'           => 'required',
            'payment_status'   => 'required|in:pending,paid',
            'fee'              => 'required|numeric|min:0',
            'notes'            => 'nullable|string|max:500',
        ]);

        $appointment->update([
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status'           => $request->status,
            'payment_status'   => $request->payment_status,
            'fee'              => $request->fee,
            'notes'            => $request->notes,
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Jadwal temu berhasil dihapus.');
    }
}