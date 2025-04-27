<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solutions for') }} {{ $task->name }}
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

                    <h3 class="text-lg font-semibold mb-4">All Submitted Solutions</h3>
                    
                    @if($solutions->isEmpty())
                        <p>No solutions have been submitted yet.</p>
                    @else
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">Student</th>
                                        <th class="py-2 px-4 border-b text-left">Solution Name</th>
                                        <th class="py-2 px-4 border-b text-left">Submitted On</th>
                                        <th class="py-2 px-4 border-b text-left">Status</th>
                                        <th class="py-2 px-4 border-b text-left">Points</th>
                                        <th class="py-2 px-4 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($solutions as $solution)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $solution->student->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $solution->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $solution->created_at->format('M d, Y H:i') }}</td>
                                            <td class="py-2 px-4 border-b">
                                                @if($solution->evaluation_time)
                                                    <span class="text-green-600">Evaluated</span>
                                                @else
                                                    <span class="text-yellow-600">Pending</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                @if($solution->earned_points !== null)
                                                    {{ $solution->earned_points }} / {{ $task->points }}
                                                @else
                                                    Not graded
                                                @endif
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('solutions.show', [$subject, $task, $solution]) }}" class="text-blue-500 hover:underline">View</a>
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