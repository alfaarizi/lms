<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solution>
 */
class SolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $task = Task::factory()->create();
        $user = User::factory()->create(['role' => 'student']);
        
        $hasBeenEvaluated = $this->faker->boolean(70);

        return [
            'name' => "{$task->name}#Solution{$user->id}",
            'content' => $this->faker->paragraphs(3, true),
            'earned_points' => $hasBeenEvaluated ? $this->faker->numberBetween(0, $task->points) : null,
            'evaluation_time' => $hasBeenEvaluated ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'task_id' => $task->id,
            'user_id' => $user->id,
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
