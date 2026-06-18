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
        'daily_rate',
        'status',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}