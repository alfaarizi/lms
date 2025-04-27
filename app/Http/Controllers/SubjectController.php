<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of all subjects.
     */
    public function dashboard()
    {
        $subjects = Subject::all();
        $viewType = 'all';
        return view('subjects.index', compact('subjects', 'viewType'));
    }

    /**
     * Display a listing of the user's subject.
     */
    public function index()
    {
        $user = Auth::user();
        $subjects = $user->isTeacher() ? $user->taughtSubjects : $user->enrolledSubjects;
        $viewType = 'self';
        return view('subjects.index', compact('subjects', 'viewType'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'code' => [
                'required',
                'string',
                'max:9',
                'unique:subjects',
                'regex:/^IK-[A-Z]{3}[0-9]{3}$/'
            ],
            'credit' => 'required|integer|min:1',
        ]);
        $subject = new Subject($validated);
        $subject->teacher_id = Auth::id();
        $subject->save();
        return redirect()
            ->route('subjects.show', $subject)
            ->with('success', 'Subject created successfully');
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'credit' => 'required|integer|min:1',
        ]);
        $subject->update([
            ...$validated,
            'code' => $subject->code,
        ]);
        return redirect()
            ->route('subjects.show', $subject)
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject deleted successfully');
    }

    /**
     * Enroll the authenticated student in the specified subject.
     * @param \App\Models\Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(Subject $subject){
        $user = Auth::user();
        if (!$user->enrolledSubjects->contains($subject->id)){
            $user->enrolledSubjects()->attach($subject);
            return redirect()
                ->back()
                ->with('success', 'Enrolled successfully');
        }
        return redirect()
            ->back()
            ->with('error', 'Already enrolled');
    }

    /**
     * Remove the authenticated student from the specified subject
     * @param \App\Models\Subject $subject
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leave(Subject $subject) {
        $user = Auth::user();
        if ($user->enrolledSubjects->contains($subject->id)) {
            $user->enrolledSubjects()->detach($subject);
            return redirect()
                ->back()
                ->with('success', 'Left subject successfully');
        }
        return redirect()
            ->back()
            ->with('error', 'Not enrolled in this subject');
    }


}
