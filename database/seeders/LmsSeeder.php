<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Solution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(TeacherSeeder::class);
        // Create students
        $students = User::factory(10)->create(['role' => 'student']);
        
        // Get teachers and create subjects, tasks, and enroll students
        User::where('role', 'teacher')->get()->each(function ($teacher) use ($students) {
            Subject::factory(3)->create(['teacher_id' => $teacher->id])->each(function ($subject) use ($students) {
                // Create tasks
                Task::factory(4)->create(['subject_id' => $subject->id])->each(function ($task) use ($subject, $students) {
                    // Enroll random students
                    $enrolledStudents = $students->random(rand(3, min(6, count($students))));
                    $subject->students()->syncWithoutDetaching($enrolledStudents->pluck('id'));
                    
                    // Create solutions for some students
                    $enrolledStudents->each(function ($student) use ($task) {
                        if (rand(0, 1)) {
                            Solution::factory()->create([
                                'task_id' => $task->id,
                                'user_id' => $student->id,
                                'name' => "{$task->name}#Solution{$student->id}",
                            ]);
                        }
                    });
                });
            });
        });
    }
}
