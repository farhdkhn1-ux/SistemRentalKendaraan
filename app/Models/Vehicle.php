<?php

namespace App\Models;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $plate_number
 * @property string $brand
 * @property string $model
 * @property string $type
 * @property int|string $year
 * @property string $color
 * @property float|int $daily_rate
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|Rental[] $rentals
 */
class Vehicle extends Model
{
    protected $fillable = [
        'plate_number',
        'brand',
        'model',
        'type',
        'year',
        'color',
        'transmission',
        'luggage_capacity',
        'pick_up_location',
        'features',
        'photo',
        'daily_rate',
        'seasonal_price',
        'seasonal_start',
        'seasonal_end',
        'status',
        'stnk_expiration',
        'insurance_expiration',
        'service_schedule',
    ];

    protected $casts = [
        'stnk_expiration' => 'date',
        'insurance_expiration' => 'date',
        'service_schedule' => 'date',
        'seasonal_start' => 'date',
        'seasonal_end' => 'date',
        'daily_rate' => 'decimal:2',
        'seasonal_price' => 'decimal:2',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function getFeaturesListAttribute()
    {
        return $this->features ? array_map('trim', explode(',', $this->features)) : [];
    }

    /**
     * Get active rate for a specific date
     */
    public function getRateForDate($date)
    {
        $targetDate = \Carbon\Carbon::parse($date);
        
        if ($this->seasonal_price && $this->seasonal_start && $this->seasonal_end) {
            $start = \Carbon\Carbon::parse($this->seasonal_start);
            $end = \Carbon\Carbon::parse($this->seasonal_end);
            
            if ($targetDate->betweenIncluded($start, $end)) {
                return $this->seasonal_price;
            }
        }
        
        return $this->daily_rate;
    }

    /**
     * Get active rate for today
     */
    public function getCurrentRateAttribute()
    {
        return $this->getRateForDate(now());
    }
}