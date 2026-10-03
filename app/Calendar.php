<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = ['season_id', 'date_from', 'date_to', 'price'];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
