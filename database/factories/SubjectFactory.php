<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a valid code in IK-SSSNNN format
        $letters = '';
        for ($i = 0; $i < 3; $i++) {
            $letters .= $this->faker->randomElement(range('A', 'Z'));
        }
        
        $numbers = '';
        for ($i = 0; $i < 3; $i++) {
            $numbers .= $this->faker->randomElement(range('0', '9'));
        }

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(3, true),
            'code' => "IK-{$letters}{$numbers}",
            'credit' => $this->faker->numberBetween(1, 6),
            'teacher_id' => User::factory()->create(['role' => 'teacher'])->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
