<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'postal_code' => fake()->postcode,
            'address' => fake()->address,
            'representative' => fake()->name,
            'establishment_date' => fake()->date,
            'capital' => fake()->randomNumber,
            'business' => fake()->text,
            'number_of_employees' => fake()->randomNumber,
        ];
    }
}
