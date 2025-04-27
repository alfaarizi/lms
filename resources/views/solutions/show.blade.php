<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $solution->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        @if(Auth::id() === $subject->teacher_id)
                            <a href="{{ route('solutions.index', [$subject, $task]) }}" class="text-blue-500 hover:underline">
                                &larr; Back to Solutions
                            </a>
                        @else
                            <a href="{{ route('tasks.show', [$subject, $task]) }}" class="text-blue-500 hover:underline">
                                &larr; Back to Task
                            </a>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg">Solution Details</h3>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p><strong>Submitted By:</strong> {{ $solution->student->name }}</p>
                                <p><strong>Submitted On:</strong> {{ $solution->created_at->format('F j, Y g:i A') }}</p>
                            </div>
                            <div>
                                <p><strong>Task:</strong> {{ $task->name }}</p>
                                <p>
                                    <strong>Status:</strong> 
                                    @if($solution->evaluation_time)
                                        <span class="text-green-600">Evaluated on {{ $solution->evaluation_time->format('F j, Y g:i A') }}</span>
                                    @else
                                        <span class="text-yellow-600">Pending evaluation</span>
                                    @endif
                                </p>
                                <p>
                                    <strong>Points:</strong> 
                                    @if($solution->earned_points !== null)
                                        {{ $solution->earned_points }} / {{ $task->points }}
                                    @else
                                        Not graded
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">Solution Content</h3>
                        <div class="p-4 bg-gray-100 rounded">
                            <pre class="whitespace-pre-wrap">{{ $solution->content }}</pre>
                        </div>
                    </div>

                    @if(Auth::id() === $subject->teacher_id && $solution->earned_points === null)
                        <div class="mt-8 border-t pt-6">
                            <h3 class="font-bold text-lg mb-4">Evaluate Solution</h3>
                            <form method="POST" action="{{ route('solutions.update', [$subject, $task, $solution]) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="earned_points" class="block text-sm font-medium text-gray-700">Points (out of {{ $task->points }})</label>
                                    <input type="number" name="earned_points" id="earned_points" min="0" max="{{ $task->points }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('earned_points')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-end">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Submit Evaluation
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>