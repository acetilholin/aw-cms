<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'fullname', 'email', 'phone', 'date_from', 'date_to',
        'days', 'price', 'message', 'extras'
    ];
}
