<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
}<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
