<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // =========================
        // STATISTIK
        // =========================

        $totalPatients = Patient::count();

        $newThisMonth = Patient::newThisMonth()->count();

        $todayVisits = Patient::whereHas('appointments', function ($q) {
            $q->today();
        })->count();

        $satisfactionRate = 89;

        // =========================
        // QUERY
        // =========================

        $query = Patient::query()->orderBy('name');

        // =========================
        // SEARCH
        // =========================

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('patient_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");

            });
        }

        // =========================
        // FILTER GENDER
        // =========================

        if ($request->gender) {

            $query->where('gender', $request->gender);
        }

        // =========================
        // FILTER UMUR
        // =========================

        if ($request->age_range) {

            [$min, $max] = explode('-', $request->age_range);

            $query->whereBetween('age', [$min, $max]);
        }

        // =========================
        // PAGINATION
        // =========================

        $patients = $query
            ->paginate(6)
            ->withQueryString();

        // =========================
        // RETURN VIEW
        // =========================

        return view('admin.patients.index', compact(
            'patients',
            'totalPatients',
            'newThisMonth',
            'todayVisits',
            'satisfactionRate'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.patients.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'email'  => 'nullable|email|unique:patients,email',
            'phone'  => 'required|string|max:20',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'age'    => 'required|integer|min:0|max:150',
        ]);

        // =========================
        // GENERATE CODE
        // =========================

        $lastPatient = Patient::latest('id')->first();

        if ($lastPatient && $lastPatient->patient_code) {

            $lastNum = (int) preg_replace(
                '/[^0-9]/',
                '',
                $lastPatient->patient_code
            );

        } else {

            $lastNum = 1000;
        }

        $newCode = 'P-' . str_pad(
            $lastNum + 1,
            6,
            '0',
            STR_PAD_LEFT
        );

        // =========================
        // CREATE PATIENT
        // =========================

        Patient::create([
            'patient_code' => $newCode,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'gender'       => $request->gender,
            'age'          => $request->age,
            'status'       => 'aktif',
        ]);

        return redirect()
            ->route('admin.patients.index')
            ->with(
                'success',
                'Pasien berhasil didaftarkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Patient $patient)
    {
        $patient->load([
            'appointments.doctor',
            'appointments.room'
        ]);

        return view(
            'admin.patients.show',
            compact('patient')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Patient $patient)
    {
        return view(
            'admin.patients.edit',
            compact('patient')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'phone'  => 'required|string|max:20',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'age'    => 'required|integer|min:0|max:150',
            'status' => 'required|in:aktif,rawat_inap,tidak_aktif',
        ]);

        $patient->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'gender' => $request->gender,
            'age'    => $request->age,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.patients.index')
            ->with(
                'success',
                'Data pasien berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('admin.patients.index')
            ->with(
                'success',
                'Data pasien berhasil dihapus.'
            );
    }
}