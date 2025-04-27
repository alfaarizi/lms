<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight mt-2">
                {{ $task->name }}
            </h2>
            <div class="flex space-x-2">
                @if(auth()->user()->isTeacher() && $subject->teacher_id === auth()->id())
                    <a href="{{ route('tasks.edit', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mr-0">
                        Edit Task
                    </a>
                    <form action="{{ route('tasks.destroy', [$subject, $task]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-0">
                            Delete
                        </button>
                    </form>
                @endif
                <a href="{{ route('subjects.show', $subject) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Task Details</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <p class="mb-2 text-gray-600">
                                    <span class="font-semibold">Points:</span> {{ $task->points }}
                                </p>
                                <p class="mb-2 text-gray-600">
                                    <span class="font-semibold">Due Date:</span> 
                                    {{ $task->due_date->format('Y-m-d H:i') }}
                                    @if($task->due_date < now())
                                        <span class="badge badge-error">Expired</span>
                                    @endif
                                </p>
                                <p class="mb-4 text-gray-600"><span class="font-semibold">Description:</span></p>
                                <div class="prose max-w-none text-gray-600">
                                    {{ $task->description }}
                                </div>
                            </div>

                            @if(auth()->user()->isStudent())
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Solutions</h3>
                                    
                                    @php
                                        $userSolutions = $task->solutions->where('user_id', auth()->id());
                                    @endphp
                                    
                                    @if($userSolutions->isEmpty())
                                        <div class="alert alert-info">
                                            <div class="flex-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>You haven't submitted any solutions yet.</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <a href="{{ route('solutions.create', [$subject, $task]) }}" class="btn btn-primary normal-case">
                                                Submit Solution
                                            </a>
                                        </div>
                                    @else
                                        <div class="overflow-x-auto">
                                            <table class="table w-full table-zebra border-collapse border border-gray-800">
                                                <thead>
                                                    <tr>
                                                        <th class="text-gray-600">Submitted At</th>
                                                        <th class="text-gray-600">Status</th>
                                                        <th class="text-gray-600">Points</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($userSolutions as $solution)
                                                        <tr class="odd:bg-gray-800">
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
                                                                    {{ $solution->earned_points }} / {{ $task->points }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        @if($task->due_date >= now())
                                            <div class="mt-4">
                                                <a href="{{ route('solutions.create', [$subject, $task]) }}" class="btn btn-primary normal-case">
                                                    Submit New Solution
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endif

                            @if(auth()->user()->isTeacher())
                                <div class="mt-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">Student Solutions</h3>
                                        <a href="{{ route('solutions.index', [$subject, $task]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                                            View All Solutions
                                        </a>
                                    </div>
                                    
                                    @if($task->solutions->isEmpty())
                                        <div class="alert alert-info">
                                            <div class="flex-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>No solutions submitted yet.</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="overflow-x-auto">
                                            <table class="table w-full table-zebra border-collapse border border-gray-800">
                                                <thead>
                                                    <tr>
                                                        <th class="text-gray-600">Student</th>
                                                        <th class="text-gray-600">Submitted At</th>
                                                        <th class="text-gray-600">Status</th>
                                                        <th class="text-gray-600">Points</th>
                                                        <th class="text-gray-600">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($task->solutions->sortByDesc('created_at')->take(5) as $solution)
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
                                                                    {{ $solution->earned_points }} / {{ $task->points }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('solutions.show', [$subject, $task, $solution]) }}" class="btn btn-xs btn-outline btn-info normal-case">
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subject Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg mb-2">
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Name:</span> {{ $subject->name }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Code:</span> {{ $subject->code }}</p>
                                <p class="mb-2 text-gray-600"><span class="font-semibold">Teacher:</span> {{ $subject->teacher->name }}</p>
                            </div>
                            
                            @if(auth()->user()->isStudent())
                                <div class="bg-base-100 border border-gray-200 rounded-lg p-4">
                                    <h3 class="font-medium text-gray-900 mb-2">Quick Actions</h3>
                                    
                                    @if($task->due_date >= now())
                                        <a href="{{ route('solutions.create', [$subject, $task]) }}" class="btn btn-primary btn-sm w-full normal-case mb-2">
                                            Submit Solution
                                        </a>
                                    @else
                                        <div class="alert alert-error mb-2">
                                            <div class="flex-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span>Submission deadline passed!</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-outline btn-sm w-full normal-case">
                                        Back to Subject
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>