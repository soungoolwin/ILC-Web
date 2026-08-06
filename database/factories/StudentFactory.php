<?php

namespace Database\Factories;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(['role' => 'student'])->id,
            'semester_id' => Semester::current()?->id ?? Semester::factory(),
            'student_id' => $this->faker->unique()->randomNumber(7),
        ];
    }
}
