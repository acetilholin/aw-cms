<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}
