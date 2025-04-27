<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Solution for') }} {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('tasks.show', [$subject, $task]) }}" class="text-blue-500 hover:underline">
                            &larr; Back to Task
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

                    <form method="POST" action="{{ route('solutions.store', [$subject, $task]) }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Solution Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Your Solution</label>
                            <textarea name="content" id="content" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('tasks.show', [$subject, $task]) }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit Solution
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>