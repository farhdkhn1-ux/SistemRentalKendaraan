<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'customer_name',
        'id_number',
        'phone',
        'start_date',
        'end_date',
        'returned_date',
        'total_cost',
        'late_days',
        'late_fee',
        'fee_lost_key',
        'fee_scratch_dent',
        'fee_lost_stnk',
        'fee_lost_etoll',
        'total_final',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'returned_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}