<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks for') }} {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('subjects.show', $subject) }}" class="text-blue-500 hover:underline">
                            &larr; Back to Subject
                        </a>
                    </div>

                    @if(Auth::user()->isTeacher() && Auth::id() === $subject->teacher_id)
                        <div class="mb-6">
                            <a href="{{ route('tasks.create', $subject) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New Task
                            </a>
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">All Tasks</h3>
                    
                    @if($tasks->isEmpty())
                        <p>No tasks found for this subject.</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($tasks as $task)
                                <div class="border rounded p-4">
                                    <h3 class="font-bold">{{ $task->name }}</h3>
                                    <p class="text-sm text-gray-600">Due: {{ $task->due_date ? $task->due_date->format('F j, Y') : 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Points: {{ $task->points }}</p>
                                    <div class="mt-4">
                                        <a href="{{ route('tasks.show', [$subject, $task]) }}" class="text-blue-500 hover:underline">View Details</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>