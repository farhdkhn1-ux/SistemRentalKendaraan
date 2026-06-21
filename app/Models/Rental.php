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
        'ktp_file',
        'sim_file',
        'start_date',
        'end_date',
        'total_days',
        'airport_pickup',
        'with_driver',
        'keyless',
        'addon_fees',
        'pickup_location',
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
        'airport_pickup' => 'boolean',
        'with_driver' => 'boolean',
        'keyless' => 'boolean',
        'total_days' => 'integer',
        'late_days' => 'integer',
        'total_cost' => 'decimal:2',
        'addon_fees' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'fee_lost_key' => 'decimal:2',
        'fee_scratch_dent' => 'decimal:2',
        'fee_lost_stnk' => 'decimal:2',
        'fee_lost_etoll' => 'decimal:2',
        'total_final' => 'decimal:2',
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