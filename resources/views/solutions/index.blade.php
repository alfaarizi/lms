<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                {{ __('Solutions for') }}: {{ $task->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.show', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                    Back to Task
                </a>
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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Task Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="mb-2 text-gray-600"><span class="font-semibold">Points:</span> {{ $task->points }}</p>
                            <p class="mb-2 text-gray-600">
                                <span class="font-semibold">Due Date:</span> 
                                {{ $task->due_date->format('Y-m-d H:i') }}
                                @if($task->due_date < now())
                                    <span class="badge badge-error">Expired</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($solutions->isEmpty())
                        <div class="alert alert-info">
                            <div class="flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>No solutions submitted yet.</span>
                            </div>
                        </div>
                    @else
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Submissions</h3>
                        <div class="overflow-x-auto">
                            <table class="table w-full table-zebra border-collapse border border-gray-800">
                                <thead>
                                    <tr>
                                        <th class="text-gray-600">Student</th>
                                        <th class="text-gray-600">Submission Date</th>
                                        <th class="text-gray-600">Status</th>
                                        <th class="text-gray-600">Points</th>
                                        <th class="text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($solutions as $solution)
                                        <tr class="odd:bg-gray-800">
                                            <td>{{ $solution->student->name }}</td>
                                            <td>{{ $solution->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if($solution->evaluation_time)
                                                    <span class="badge badge-success">Evaluated</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($solution->evaluation_time)
                                                    <span class="font-medium">{{ $solution->earned_points }} / {{ $task->points }}</span>
                                                @else
                                                    <span class="text-gray-500">Not graded</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('solutions.show', [$subject, $task, $solution]) }}" class="w-full bg-green-700 btn btn-xs btn-outline btn-info normal-case">
                                                    View & Grade
                                                </a>
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