<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_code',
        'name',
        'title',
        'specialist_id',
        'str_number',
        'sip_number',
        'phone',
        'email',
        'avatar',
        'schedule_days',
        'schedule_start',
        'schedule_end',
        'rating',
        'total_reviews',
        'status',
        'is_active',
    ];

    protected $casts = [
        'schedule_days' => 'array',
        'rating' => 'float',
        'is_active' => 'boolean',
    ];

    // Relasi ke Specialist
    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    // Relasi ke Appointment
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Accessor: nama lengkap dengan gelar (Dr. Rina Wati, Sp.PD)
    public function getFullNameAttribute(): string
    {
        $title = $this->title ? ', ' . $this->title : '';
        return 'Dr. ' . $this->name . $title;
    }

    // Accessor: inisial nama untuk avatar
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    // Accessor: jadwal hari dalam format "Sen–Jum"
    public function getScheduleRangeAttribute(): string
    {
        if (!$this->schedule_days || count($this->schedule_days) === 0) {
            return '-';
        }
        $days = $this->schedule_days;
        if (count($days) === 1) return $days[0];
        return $days[0] . '–' . end($days);
    }

    // Scope: hanya dokter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Hitung total pasien hari ini
    public function getTodayPatientsAttribute(): int
    {
        return $this->appointments()
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['dibatalkan'])
            ->count();
    }

    // Hitung slot tersisa hari ini (anggap max 10 per hari)
    public function getTodaySlotsAttribute(): int
    {
        $used = $this->appointments()
            ->whereDate('appointment_date', today())
            ->whereNotIn('status', ['dibatalkan'])
            ->count();
        return max(0, 10 - $used);
    }

    // Render bintang rating
    public function getStarsAttribute(): array
    {
        $full = floor($this->rating);
        $half = ($this->rating - $full) >= 0.5 ? 1 : 0;
        $empty = 5 - $full - $half;
        return ['full' => $full, 'half' => $half, 'empty' => $empty];
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->avg('rating'), 1);
    }

}