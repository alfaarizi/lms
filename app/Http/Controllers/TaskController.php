<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the task.
     */
    public function index(Subject $subject)
    {
        $tasks = $subject->tasks;
        return view('tasks.index', compact('subject', 'tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Subject $subject)
    {
        // Authenticated user must be a teacher of this subject
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'You are not authorized to create tasks for this subject.');
        }
        return view('tasks.create', compact('subject'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request, Subject $subject)
    {
        // Authenticated user must be a teacher of this subject
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'You are not authorized to create tasks for this subject.');
        }
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'description' => 'required|string',
            'points' => 'required|integer|min:0',
            'due_date' => 'nullable|date|after:' . now(),
        ]);
        $task = new Task($validated);
        $task->subject_id = $subject->id;
        $task->save();
        return redirect()
            ->route('tasks.show', [$subject, $task])
            ->with('success', 'Task created successfully');
    }

    /**
     * Display the specified task.
     */
    public function show(Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }

        $user = Auth::user();
        $solution = null;
        if ($user->isStudent()) {
            // Get the student's solution for this task if it exists
            $solution = $task->solutions()->where('user_id', $user->id)->first();
        }
        return view('tasks.show', compact('subject', 'task', 'solution'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Authenticated user must be a teacher of this subject
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to edit this task.');
        }
        return view('tasks.edit', compact('subject', 'task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Authenticated user must be a teacher of this subject
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to edit this task.');
        }
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'description' => 'required|string',
            'points' => 'required|integer|min:0',
            'due_date' => 'nullable|date|after:' . now(),
        ]);
        $task->update($validated);
        return redirect()
            ->route('tasks.show', [$subject, $task])
            ->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Subject $subject, Task $task)
    {
        // Task must belongs to the subject
        if ($task->subject_id !== $subject->id) {
            return redirect()
                ->route('subjects.show', $subject)
                ->with('error', 'Task not found in this subject.');
        }
        // Authenticated user must be a teacher of this subject
        if (Auth::id() !== $subject->teacher_id) {
            return redirect()
                ->route('tasks.show', [$subject, $task])
                ->with('error', 'You are not authorized to delete this task.');
        }
        $task->delete();
        return redirect()
            ->route('tasks.index', $subject)
            ->with('success', 'Task deleted successfully');
    }
}
