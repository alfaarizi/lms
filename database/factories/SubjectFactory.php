<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\SubjectCodeGenerator;
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
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(3, true),
            'code' => app(SubjectCodeGenerator::class)->generate(),
            'credit' => $this->faker->numberBetween(1, 6),
            'teacher_id' => User::factory()->create(['role' => 'teacher'])->id,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
