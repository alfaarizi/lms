<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Auth::user()->isTeacher())
                        <div class="mb-4">
                            <a href="{{ route('subjects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New Subject
                            </a>
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">Your Subjects</h3>
                    
                    @if($subjects->isEmpty())
                        <p>No subjects found.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($subjects as $subject)
                                <div class="border rounded p-4">
                                    <h3 class="font-bold">{{ $subject->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $subject->code }} - {{ $subject->credit }} credits</p>
                                    <div class="mt-4">
                                        <a href="{{ route('subjects.show', $subject) }}" class="text-blue-500 hover:underline">View Details</a>
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