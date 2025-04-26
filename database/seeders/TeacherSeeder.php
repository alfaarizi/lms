<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'nagy',
                'neptun' => 'M4ZRL5',
                'email' => 'nagy.bendeguz@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ],
            [
                'name' => 'horvarth',
                'neptun' => 'GYOZKE',
                'email' => 'horvarth.gyozo@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ],
        ];

        foreach ($teachers as $teacher) {
            User::create($teacher);
        }
    }
}
