<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
    'appointment_code',
    'patient_id',
    'doctor_id',
    'room_id',
    'appointment_date',
    'appointment_time',
    'status',
    'notes',
    'fee',

    'payment_status',
    'booking_code',
    'queue_number',
];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'fee' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    // Relasi ke pasien
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relasi ke dokter
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    // Relasi ke ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Jadwal hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    // Filter status
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'semua') {
            return $query->where('status', $status);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Label status
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'      => 'Menunggu',
            'terkonfirmasi' => 'Terkonfirmasi',
            'proses'        => 'Proses',
            'selesai'       => 'Selesai',
            'dibatalkan'    => 'Dibatalkan',
            default         => ucfirst($this->status),
        };
    }

    // Badge class
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {

            'menunggu' =>
                'bg-yellow-100 text-yellow-700 border border-yellow-200',

            'terkonfirmasi' =>
                'bg-green-100 text-green-700 border border-green-200',

            'proses' =>
                'bg-blue-100 text-blue-700 border border-blue-200',

            'selesai' =>
                'bg-gray-100 text-gray-700 border border-gray-200',

            'dibatalkan' =>
                'bg-red-100 text-red-700 border border-red-200',

            default =>
                'bg-gray-100 text-gray-600 border border-gray-200',
        };
    }

    // Dot status
    public function getStatusDotAttribute(): string
    {
        return match ($this->status) {

            'menunggu'      => 'bg-yellow-400',
            'terkonfirmasi' => 'bg-green-500',
            'proses'        => 'bg-blue-500',
            'selesai'       => 'bg-gray-400',
            'dibatalkan'    => 'bg-red-500',

            default         => 'bg-gray-400',
        };
    }

    // Format biaya
    public function getFormattedFeeAttribute(): string
    {
        return 'Rp ' . number_format($this->fee ?? 0, 0, ',', '.');
    }

    // Format tanggal
    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date
            ? $this->appointment_date->format('d M Y')
            : '-';
    }
}