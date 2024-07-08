<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularHoliday extends Model
{
    use HasFactory;
    protected $fillable = ['day', 'day_index'];

    // ここがリレーションシップに関する部分です
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'regular_holiday_restaurant');
    }
}