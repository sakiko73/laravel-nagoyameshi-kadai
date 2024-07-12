<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Restaurant extends Model
{
    use HasFactory,Sortable;

    protected $fillable = [
        'name',
        'image',
        'description',
        'lowest_price',
        'highest_price',
        'postal_code',
        'address',
        'opening_time',
        'closing_time',
        'seating_capacity',
    ];

    public $sortable = [
        'name',
        'lowest_price',
        'highest_price',
    ];
    // リレーション設定
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }

    // リレーションシップ
    public function regular_holidays()
    {
    return $this->belongsToMany(RegularHoliday::class, 'regular_holiday_restaurant');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratingSortable($query, $direction) {
        return $query->withAvg('reviews', 'score')->orderBy('reviews_avg_score', $direction);
    }
}