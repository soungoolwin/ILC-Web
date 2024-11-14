<?php

namespace Database\Factories;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timetable>
 */
class TimetableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mentor_id' => Mentor::factory(),
            'day' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'time_slot' => $this->faker->randomElement(['9:00-9:30', '9:30-10:00']),
            'table_number' => $this->faker->numberBetween(1, 25),
            'reserved' => false,
            'week_number' => $this->faker->numberBetween(1, 10),
        ];
    }
}
