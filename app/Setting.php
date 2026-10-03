<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];

    public static function read($key, $default = null)
    {
        if (!Schema::hasTable('settings')) {
            return $default;
        }
        $setting = static::find($key);
        return $setting ? $setting->value : $default;
    }

    public static function write($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Whether the camper rental content is shown on the public website (default: shown). */
    public static function camperEnabled()
    {
        return static::read('camper_enabled', '1') === '1';
    }
}
