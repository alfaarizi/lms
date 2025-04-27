<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('tasks.index', $subject) }}" class="text-blue-500 hover:underline">
                            &larr; Back to Tasks
                        </a>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg">Task Details</h3>
                        <p class="mt-2">{{ $task->description }}</p>
                        
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p><strong>Points:</strong> {{ $task->points }}</p>
                            </div>
                            <div>
                                <p><strong>Due Date:</strong> {{ $task->due_date->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->isTeacher() && Auth::id() === $subject->teacher_id)
                        <div class="flex space-x-4 mb-6">
                            <a href="{{ route('tasks.edit', [$subject, $task]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Edit Task
                            </a>
                            
                            <form action="{{ route('tasks.destroy', [$subject, $task]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete Task
                                </button>
                            </form>
                            
                            <a href="{{ route('solutions.index', [$subject, $task]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                View Solutions
                            </a>
                        </div>
                    @endif

                    @if(Auth::user()->isStudent())
                        <div class="mt-6 p-4 border rounded">
                            <h3 class="font-bold text-lg mb-4">Your Solution</h3>
                            
                            @if($solution)
                                <div>
                                    <p><strong>Submitted:</strong> {{ $solution->created_at->format('F j, Y g:i A') }}</p>
                                    <p><strong>Points Earned:</strong> {{ $solution->earned_points !== null ? $solution->earned_points : 'Not evaluated yet' }}</p>
                                    <p><strong>Solution:</strong></p>
                                    <div class="mt-2 p-4 bg-gray-100 rounded">
                                        <pre>{{ $solution->content }}</pre>
                                    </div>
                                </div>
                            @else
                                <p>You haven't submitted a solution yet.</p>
                                <div class="mt-4">
                                    <a href="{{ route('solutions.create', [$subject, $task]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Submit Solution
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>