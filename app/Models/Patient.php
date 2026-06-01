<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_code',
        'name',
        'email',
        'phone',
        'gender',
        'age',
        'birth_date',
        'address',
        'last_visit',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_visit' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Relasi ke user login
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Umur otomatis dari tanggal lahir
    public function getCalculatedAgeAttribute()
    {
        if (!$this->birth_date) {
            return '-';
        }

        return Carbon::parse($this->birth_date)->age;
    }

    // Inisial nama
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);

        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return $initials;
    }

    // Warna avatar otomatis
    public function getAvatarColorAttribute(): string
    {
        $colors = [
            'A' => 'bg-blue-500',
            'B' => 'bg-green-500',
            'C' => 'bg-purple-500',
            'D' => 'bg-red-500',
            'E' => 'bg-yellow-500',
            'F' => 'bg-pink-500',
            'G' => 'bg-indigo-500',
            'H' => 'bg-teal-500',
            'I' => 'bg-orange-500',
            'J' => 'bg-cyan-500',
            'K' => 'bg-lime-500',
            'L' => 'bg-amber-500',
            'M' => 'bg-rose-500',
            'N' => 'bg-violet-500',
            'O' => 'bg-sky-500',
            'P' => 'bg-emerald-500',
            'Q' => 'bg-fuchsia-500',
            'R' => 'bg-blue-400',
            'S' => 'bg-green-400',
            'T' => 'bg-orange-400',
            'U' => 'bg-purple-400',
            'V' => 'bg-red-400',
            'W' => 'bg-teal-400',
            'X' => 'bg-yellow-400',
            'Y' => 'bg-pink-400',
            'Z' => 'bg-indigo-400',
        ];

        $firstLetter = strtoupper(substr($this->name, 0, 1));

        return $colors[$firstLetter] ?? 'bg-gray-500';
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Pasien aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    // Pasien baru bulan ini
    public function scopeNewThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }
}