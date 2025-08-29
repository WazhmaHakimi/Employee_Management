<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address(),
            'city_id' => fake()->randomElement(City::pluck('id')->toArray()),
            'state_id' => fake()->randomElement(State::pluck('id')->toArray()),
            'country_id' => fake()->randomElement(Country::pluck('id')->toArray()),
            'department_id' => fake()->randomElement(Department::pluck('id')->toArray()),
            'zip_code' => '10002',
            'birth_date' => fake()->dateTimeBetween('-20 years', 'now'),
            'hired_date' => fake()->date('now'),
        ];
    }
}
