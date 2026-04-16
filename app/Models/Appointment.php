<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'customer_name',
        'service_id',
        'date_time'
    ];

    protected $casts = [
        'date_time' => 'datetime'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public static function hasConflict($start, $end)
    {
        return self::whereHas('service', function ($q) {})
            ->get()
            ->filter(function ($appointment) use ($start, $end) {
                $existingStart = $appointment->date_time;
                $existingEnd = $appointment->end_time;

                return $start < $existingEnd && $end > $existingStart;
            })
            ->isNotEmpty();
    }

    public function getEndTimeAttribute()
    {
        return $this->date_time->copy()->addMinutes($this->service->duration);
    }

    public static function isWithinBusinessHours($start, $end)
    {
        return $start->format('H:i') >= '08:00' && $end->format('H:i') <= '18:00';
    }
}
