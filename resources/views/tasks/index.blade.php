<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight mt-2">
                Tasks for {{ $subject->name }}
            </h2>
            <div class="flex space-x-2">
                @if(auth()->user()->isTeacher() && $subject->teacher_id === auth()->id())
                    <a href="{{ route('tasks.create', $subject) }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                        Create New Task
                    </a>
                @endif
                <a href="{{ route('subjects.show', $subject) }}" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                    Back to Subject
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-2 bg-indigo-500"></div>
                <div class="p-6 bg-white border-b border-gray-200">
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
                                        <th class="text-gray-600">Description</th>
                                        <th class="text-gray-600">Points</th>
                                        <th class="text-gray-600">Due Date</th>
                                        <th colspan="3" class="text-gray-600 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject->tasks as $task)
                                        <tr class="odd:bg-gray-800 {{ $task->due_date < now() ? 'bg-red-50' : '' }}">
                                            <td>{{ $task->name }}</td>
                                            <td class="truncate max-w-xs">{{ Str::limit($task->description, 50) }}</td>
                                            <td>{{ $task->points }}</td>
                                            <td>
                                                {{ $task->due_date->format('Y-m-d H:i') }}
                                                @if($task->due_date < now())
                                                    <span class="badge badge-error badge-sm">Expired</span>
                                                @endif
                                            </td>
                                            <td class="flex space-x-1">
                                                <a href="{{ route('tasks.show', [$subject, $task]) }}" class="bg-blue-500 btn btn-xs btn-outline btn-info normal-case mr-0">
                                                    View
                                                </a>
                                                @if(auth()->user()->isTeacher())
                                                    <a href="{{ route('tasks.edit', [$subject, $task]) }}" class="bg-yellow-600 btn btn-xs btn-outline btn-accent normal-case">
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('solutions.index', [$subject, $task]) }}" class="bg-green-700 btn btn-xs btn-outline btn-success normal-case">
                                                        Solutions
                                                    </a>
                                                @endif
                                                @if(auth()->user()->isStudent())
                                                    <a href="{{ route('solutions.create', [$subject, $task]) }}" class="bg-green-700 btn btn-xs btn-outline btn-primary normal-case">
                                                        Submit
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
        </div>
    </div>
</x-app-layout>