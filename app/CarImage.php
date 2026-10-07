<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    protected $fillable = ['car_id', 'path', 'is_cover'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
