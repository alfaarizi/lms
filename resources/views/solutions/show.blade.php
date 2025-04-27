<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight mt-2">
                {{ __('Solution by') }}: {{ $solution->student->name }}
            </h2>
            <div class="flex space-x-2">
                @if(auth()->user()->isTeacher())
                    <a href="{{ route('solutions.index', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                        All Solutions
                    </a>
                @endif
                <a href="{{ route('tasks.show', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                    Back to Task
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
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Solution Content</h3>
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="prose max-w-none text-gray-600">
                                    {{ $solution->content }}
                                </div>
                            </div>

                            @if(auth()->user()->isTeacher() && !$solution->evaluation_time)
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evaluate Solution</h3>
                                    <form action="{{ route('solutions.update', [$subject, $task, $solution]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-4 text-gray-600">
                                            <x-input-label for="earned_points" :value="__('Points (max: ' . $task->points . ')')" />
                                            <x-text-input id="earned_points" class="block mt-1" type="number" min="0" max="{{ $task->points }}" name="earned_points" :value="old('earned_points', 0)" required />
                                            <x-input-error :messages="$errors->get('earned_points')" class="mt-2" />
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <x-primary-button>
                                                {{ __('Submit Evaluation') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Submission Details</h3>
                            <div class="bg-gray-50 p-4 rounded-lg mb-2 text-gray-600">
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Student:</span> {{ $solution->student->name }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Submitted:</span> {{ $solution->created_at->format('Y-m-d H:i') }}</p>
                                <p class="mb-2 text-gray-600">
                                    <span class="font-semibold">Status:</span> 
                                    @if($solution->evaluation_time)
                                        <span class="badge badge-success">Evaluated</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </p>
                                @if($solution->evaluation_time)
                                    <p class="mb-2 text-gray-600"><span class="font-semibold">Evaluated:</span> {{ $solution->evaluation_time->format('Y-m-d H:i') }}</p>
                                    <p class="mb-2 text-gray-600">
                                        <span class="font-semibold">Points:</span> 
                                        <span class="text-lg font-bold">{{ $solution->earned_points }} / {{ $task->points }}</span>
                                    </p>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Task Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg mb-2 text-gray-600">
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Name:</span> {{ $task->name }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Subject:</span> {{ $subject->name }}</p>
                                <p class="mb-2 text-gray-600">
                                    <span class="font-semibold">Due Date:</span> 
                                    {{ $task->due_date->format('Y-m-d H:i') }}
                                </p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Max Points:</span> {{ $task->points }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>