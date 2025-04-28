<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-200 leading-tight mt-2">
                @if(isset($viewType) && $viewType == 'self')
                    {{ __('Your Subjects') }}
                @elseif (isset($viewType) && $viewType == 'available')
                    {{ __('Available Subjects for Enrollment') }}
                @else
                    {{ __('All Available Subjects') }}
                @endif
            </h2>
            @if(auth()->user()->isTeacher())
            <div class="flex space-x-2">
                <div>
                    <a href="{{ route('subjects.create') }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3">
                        New Subject
                    </a>
                </div>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-2 bg-indigo-500"></div>    
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                    @if(isset($viewType) && $viewType == 'self')
                        <h3 class="text-lg font-medium text-gray-900">Your Subjects ({{ $subjects->count() }})</h3>
                    @elseif (isset($viewType) && $viewType == 'available')
                        <h3 class="text-lg font-medium text-gray-900">Available Subjects for Enrollment ({{ $subjects->count() }})</h3>
                    @else
                        <h3 class="text-lg font-medium text-gray-900">All Available Subjects ({{ $subjects->count() }})</h3>
                    @endif
                    </div>

                    @if($subjects->isEmpty())
                        <div class="alert alert-info">
                            <div class="flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>No subjects found.</span>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($subjects as $subject)
                                <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="card-body">
                                        <h3 class="card-title">
                                            <a href="{{ route('subjects.show', $subject) }}" class="font-bold text-white-800 text-lg hover:underline">
                                                {{ $subject->name }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-blue-200">{{ $subject->code }} – {{ $subject->credit }} credits</p>
                                        <p class="text-sm text-white-500 mt-2 line-clamp-2">{{ $subject->description }}</p>
                                        <div class="card-actions justify-end mt-4">
                                            <a href="{{ route('subjects.show', $subject) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mr-0">
                                                View Details
                                            </a>
                                            @if(auth()->user()->isStudent())
                                                @if(auth()->user()->enrolledSubjects->contains($subject->id))
                                                    <form action="{{ route('subjects.leave', $subject) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-0">
                                                            Leave Subject
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('subjects.enroll', $subject) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-0">
                                                            Enroll
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>