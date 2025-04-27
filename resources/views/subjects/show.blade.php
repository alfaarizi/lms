<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="font-bold text-lg">{{ $subject->code }} - {{ $subject->credit }} credits</h3>
                        <p class="text-gray-600 mt-2">{{ $subject->description }}</p>
                        
                        <div class="mt-4">
                            <p><strong>Teacher:</strong> {{ $subject->teacher->name }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->isTeacher() && Auth::id() === $subject->teacher_id)
                        <div class="flex space-x-4 mb-6">
                            <a href="{{ route('subjects.edit', $subject) }}" class="bg-yellow-500 hover:bg-yellow-700 text-gray-800 font-bold py-2 px-4 rounded">
                                Edit Subject
                            </a>
                            
                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-gray-800 font-bold py-2 px-4 rounded">
                                    Delete Subject
                                </button>
                            </form>
                            
                            <a href="{{ route('tasks.create', $subject) }}" class="bg-green-500 hover:bg-green-700 text-gray-800 font-bold py-2 px-4 rounded">
                                Add Task
                            </a>
                        </div>
                    @endif

                    @if(Auth::user()->isStudent())
                        <div class="mb-6">
                            @if(Auth::user()->enrolledSubjects->contains($subject->id))
                                <form action="{{ route('subjects.leave', $subject) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Leave Subject
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('subjects.enroll', $subject) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Enroll in Subject
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <div class="mt-6">
                        <h3 class="font-bold text-lg mb-4">Tasks</h3>
                        <a href="{{ route('tasks.index', $subject) }}" class="text-blue-500 hover:underline">
                            View All Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>