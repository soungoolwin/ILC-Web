<?php

namespace Database\Factories;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => Semester::nameFor(now()->year, 1),
            'year' => now()->year,
            'term' => 1,
            'start_date' => now()->startOfYear(),
            'end_date' => now()->startOfYear()->addMonths(5),
            'is_current' => true,
        ];
    }
}
