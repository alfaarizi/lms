<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight mt-2">
            {{ __('Submit Solution for') }}: {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($task->due_date < now())
                <div class="alert alert-error mb-4">
                    <div class="flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-gray-600">Warning: The deadline for this task has passed. Your submission might not be accepted.</span>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-2 bg-indigo-500"></div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 text-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Your Solution</h3>
                            
                            <form method="POST" action="{{ route('solutions.store', [$subject, $task]) }}">
                                @csrf

                                <input type="hidden" id="name" name="name" value="{{ $task->name }}#Solution{{ Auth::id() }}" />
                                
                                <div class="mb-4">
                                    <x-input-label for="content" :value="__('Solution Content')" />
                                    <textarea id="content" name="content" rows="10" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('content') }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('tasks.show', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                                        Cancel
                                    </a>
                                    <x-primary-button class="ml-3 bg-green-700">
                                        {{ __('Submit Solution') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg mb-6 text-gray-600">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Task Details</h3>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Task:</span> {{ $task->name }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Points:</span> {{ $task->points }}</p>
                                <p class="mb-2 text-gray-600">
                                    <span class="font-semibold">Due Date:</span> 
                                    {{ $task->due_date->format('Y-m-d H:i') }}
                                    @if($task->due_date < now())
                                        <span class="badge badge-error">Expired</span>
                                    @else
                                        @php
                                            $hoursLeft = now()->diffInHours($task->due_date, false);
                                        @endphp
                                        @if($hoursLeft < 24 && $hoursLeft > 0)
                                            <span class="badge badge-warning">{{ $hoursLeft }} hours left</span>
                                        @elseif($hoursLeft > 0)
                                            <span class="badge badge-info">{{ (int)now()->diffInDays($task->due_date) }} days left</span>
                                        @endif
                                    @endif
                                </p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Description:</span></p>
                                <div class="prose max-w-none text-gray-600">
                                    {{ $task->description }}
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg text-gray-600">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Subject Information</h3>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Subject:</span> {{ $subject->name }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Code:</span> {{ $subject->code }}</p>
                                <p><span class="font-semibold text-gray-600">Teacher:</span> {{ $subject->teacher->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>