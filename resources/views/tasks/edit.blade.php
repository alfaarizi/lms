<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}: {{ $task->name }}
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

                    <form method="POST" action="{{ route('tasks.update', [$subject, $task]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="points" class="block text-sm font-medium text-gray-700">Points</label>
                            <input type="number" name="points" id="points" value="{{ old('points', $task->points) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('points')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('due_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('tasks.show', [$subject, $task]) }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>