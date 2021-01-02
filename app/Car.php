<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['title', 'subtitle', 'link', 'price', 'description', 'new', 'image', 'call_for_price'];
}
