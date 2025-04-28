<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Task;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    /**
     * Display a listing of the solution.
     */
    public function index(Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Only the teacher of the subject can view all solutions
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to view all solutions.');
        }
        $solutions = $task->solutions()->with('student')->get();
        return view('solutions.index', compact('subject', 'task', 'solutions'));
    }

    /**
     * Show the form for creating a new solution.
     */
    public function create(Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Only students can submit solutions
        if (!Auth::user()->isStudent()) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'Only students can submit solutions.');
        }
        // Student must be enrolled in the subject
        if (!Auth::user()->enrolledSubjects->contains($subject->id)) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'You need to be enrolled in this subject to submit a solution.');
        }
        // Student has already submitted a solution
        // $existingSolution = $task->solutions()->where('user_id', Auth::id())->first();
        // if ($existingSolution) {
        //     return redirect()
        //         ->route('tasks.show', [$subject, $task])
        //         ->with('error', 'You have already submitted a solution for this task.');
        // }
        return view('solutions.create', compact('subject', 'task'));
    }

    /**
     * Store a newly created solution in storage.
     */
    public function store(Request $request, Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Only students can submit solutions
        if (!Auth::user()->isStudent()) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'Only students can submit solutions.');
        }
        // Student must be enrolled in the subject
        if (!Auth::user()->enrolledSubjects->contains($subject->id)) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'You need to be enrolled in this subject to submit a solution.');
        }
        // Check if the student has already submitted a solution
        // $existingSolution = $task->solutions()->where('user_id', Auth::id())->first();
        // if ($existingSolution) {
        //     return redirect()->route('tasks.show', [$subject, $task])->with('error', 'You have already submitted a solution for this task.');
        // }
        //  Task must not past due
        if (now()->isAfter($task->due_date)) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'The deadline for this task has passed.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $solution = new Solution($validated);
        $solution->task_id = $task->id;
        $solution->user_id = Auth::id();
        $solution->save();
        return redirect()
            ->route('tasks.show', [$subject, $task])
            ->with('success', 'Solution submitted successfully.');
    }

    /**
     * Display the specified solution.
     */
    public function show(Subject $subject, Task $task, Solution $solution)
    {
        // Task must belongs to the subject and solution must belongs to the task
        if ($task->subject_id !== $subject->id || $solution->task_id !== $task->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Solution not found for this task.');
        }
        // Only teacher of the subject or student who submitted the solution can view it
        if (Auth::id() !== $subject->teacher_id && Auth::id() !== $solution->user_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to view this solution.');
        }
        return view('solutions.show', compact('subject', 'task', 'solution'));
    }

    /**
     * Show the form for editing the specified solution.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified solution in storage.
     */
    public function update(Request $request, Subject $subject, Task $task, Solution $solution)
    {
        // Task must belongs to the subject and solution belongs to the task
        if ($task->subject_id !== $subject->id || $solution->task_id !== $task->id) {
            return redirect()->route('subjects.show', $subject)->with('error', 'Solution not found for this task.');
        }
        // Only teacher of the subject can evaluate solutions
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to evaluate this solution.');
        }
        $validated = $request->validate([
            'earned_points' => "required|integer|min:0|max:{$task->points}",
        ]);
        $solution->update([
            ...$validated,
            'evaluation_time' => now(),
        ]);
        return redirect()
            ->route('solutions.show', [$subject, $task, $solution])
            ->with('success', 'Solution evaluated successfully.');
    }

    /**
     * Remove the specified solution from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
