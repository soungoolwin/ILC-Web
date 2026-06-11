<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeamLeader>
 */
class TeamLeaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create([
                'role' => 'team_leader'
            ])->id,
            'team_leader_id' => 'TL' . $this->faker->unique()->numberBetween(1000, 9999),
        ];
    }
}