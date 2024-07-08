<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RegularHoliday;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegularHoliday>
 */
class RegularHolidayFactory extends Factory
{
    
    protected $model = RegularHoliday::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => $this->faker->dayOfWeek(),
            'day_index' => $this->faker->numberBetween(1, 7),
        ];
    }
}
