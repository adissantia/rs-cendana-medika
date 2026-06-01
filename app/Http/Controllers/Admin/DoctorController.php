<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialist;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // =====================
        // STATISTIK
        // =====================
        $totalDoctors      = Doctor::count();
        $activeDoctors     = Doctor::where('status', 'online')->count();
        $specialistsCount  = Specialist::count();
        $avgRating         = round(Rating::avg('rating') ?? 0, 1);

        // =====================
        // QUERY
        // =====================
        $query = Doctor::with(['specialist', 'ratings']);

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('doctor_code', 'like', "%{$search}%")
                  ->orWhereHas('specialist', function ($s) use ($search) {
                      $s->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // FILTER SPECIALIST
        if ($request->filled('specialist_id')) {
            $query->where('specialist_id', $request->specialist_id);
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $doctors = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $specialists = Specialist::orderBy('name')->get();

        return view('admin.doctors.index', compact(
            'doctors',
            'specialists',
            'totalDoctors',
            'activeDoctors',
            'specialistsCount',
            'avgRating'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $specialists = Specialist::orderBy('name')->get();
        return view('admin.doctors.create', compact('specialists'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'specialist_id' => 'required|exists:specialists,id',
            'phone'         => 'nullable|string|max:20',
            'avatar'        => 'nullable|image|max:2048',
        ]);

        // =====================
        // GENERATE KODE DOKTER
        // =====================
        $lastDoctor = Doctor::orderByDesc('id')->first();
        $lastNumber = $lastDoctor
            ? (int) substr($lastDoctor->doctor_code, 4)
            : 0;

        $doctorCode = 'DOK-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // =====================
        // UPLOAD AVATAR
        // =====================
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')
                ->store('doctors', 'public');
        }

        Doctor::create([
            'doctor_code'   => $doctorCode,
            'name'          => $request->name,
            'specialist_id' => $request->specialist_id,
            'phone'         => $request->phone,
            'avatar'        => $avatarPath,
            'status'        => 'online',
            'is_active'     => true,
        ]);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Doctor $doctor)
    {
        $doctor->load(['specialist', 'appointments.patient', 'ratings']);
        return view('admin.doctors.show', compact('doctor'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Doctor $doctor)
    {
        $specialists = Specialist::orderBy('name')->get();
        return view('admin.doctors.edit', compact('doctor', 'specialists'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'specialist_id' => 'required|exists:specialists,id',
            'phone'         => 'nullable|string|max:20',
            'status'        => 'required|in:online,offline,cuti',
            'avatar'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name',
            'specialist_id',
            'phone',
            'status',
        ]);

        // =====================
        // UPDATE AVATAR
        // =====================
        if ($request->hasFile('avatar')) {
            if ($doctor->avatar) {
                Storage::disk('public')->delete($doctor->avatar);
            }

            $data['avatar'] = $request->file('avatar')
                ->store('doctors', 'public');
        }

        $doctor->update($data);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Doctor $doctor)
    {
        if ($doctor->avatar) {
            Storage::disk('public')->delete($doctor->avatar);
        }

        $doctor->delete();

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}