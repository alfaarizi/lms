<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ $subject->name }}
            </h2>
            <div class="flex space-x-2">
                @if(auth()->user()->isTeacher() && $subject->teacher_id === auth()->id())
                    <a href="{{ route('subjects.edit', $subject) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mr-0">
                        Edit Subject
                    </a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-0">
                            Delete
                        </button>
                    </form>
                @endif
                <a href="{{ route('subjects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                    Back to Subjects
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-2 bg-indigo-500"></div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Subject Information</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="mb-2 text-gray-600"><span class="font-semibold">Name:</span> {{ $subject->name }}</p>
                                    <p class="mb-2 text-gray-600"><span class="font-semibold">Code:</span> {{ $subject->code }}</p>
                                    <p class="mb-2 text-gray-600"><span class="font-semibold">Credits:</span> {{ $subject->credit }}</p>
                                    <p class="mb-2 text-gray-600"><span class="font-semibold">Teacher:</span> {{ $subject->teacher->name }}</p>
                                    <p class="mb-4 text-gray-600"><span class="font-semibold">Description:</span></p>
                                    <p class="text-gray-600">{{ $subject->description }}</p>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Tasks</h3>
                                    @if(auth()->user()->isTeacher() && $subject->teacher_id === auth()->id())
                                        <a href="{{ route('tasks.create', $subject) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                                            Create New Task
                                        </a>
                                    @endif
                                </div>

                                @if($subject->tasks->isEmpty())
                                    <div class="alert alert-info">
                                        <div class="flex-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>No tasks available for this subject.</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="table w-full table-zebra border-collapse border border-gray-800">
                                            <thead>
                                                <tr>
                                                    <th class="text-gray-600">Name</th>
                                                    <th class="text-gray-600">Points</th>
                                                    <th class="text-gray-600">Due Date</th>
                                                    <th colspan="2" class="text-gray-600 text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subject->tasks as $task)
                                                    <tr class="odd:bg-gray-800">
                                                        <td>{{ $task->name }}</td>
                                                        <td>{{ $task->points }}</td>
                                                        <td>{{ $task->due_date->format('Y-m-d H:i') }}</td>
                                                        <td>
                                                            <a href="{{ route('tasks.show', [$subject, $task]) }}" class="btn btn-xs btn-outline btn-info normal-case">
                                                                View
                                                            </a>
                                                            @if(auth()->user()->isTeacher())
                                                                <a href="{{ route('solutions.index', [$subject, $task]) }}" class="btn btn-xs btn-outline btn-success normal-case">
                                                                    Solutions
                                                                </a>
                                                            @endif
                                                            @if(auth()->user()->isStudent())
                                                                <a href="{{ route('solutions.create', [$subject, $task]) }}" class="btn btn-xs btn-outline btn-primary normal-case">
                                                                    Submit Solution
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Students Enrolled</h3>
                            @if($subject->students->isEmpty())
                                <div class="alert alert-info">
                                    <div class="flex-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-gray-600">No students enrolled yet.</span>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($subject->students as $student)
                                            <li class="py-2 text-gray-600">{{ $student->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(auth()->user()->isStudent() && !$subject->students->contains(auth()->id()))
                                <div class="mt-4">
                                    <form action="{{ route('subjects.enroll', $subject) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-full normal-case">
                                            Enroll in Subject
                                        </button>
                                    </form>
                                </div>
                            @elseif(auth()->user()->isStudent())
                                <div class="mt-4">
                                    <form action="{{ route('subjects.leave', $subject) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline btn-error w-full normal-case">
                                            Leave Subject
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>