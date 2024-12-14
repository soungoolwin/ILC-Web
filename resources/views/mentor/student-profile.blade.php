<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Student Profile</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <!-- Student Info -->
            <div>
                <label class="text-sm font-medium text-gray-500">Student ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->student_id }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-500">Name:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->user->name }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-500">Nickname:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->user->nickname }}</p>
            </div>

            {{-- <div>
                <label class="text-sm font-medium text-gray-500">Email:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->user->email }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-500">Line ID:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->user->line_id ?? 'N/A' }}</p>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-500">Phone Number:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $student->user->phone_number ?? 'N/A' }}</p>
            </div> --}}
        </div>

        <div class="mt-6">
            <a href="{{ route('mentor.timetables.students') }}" class="text-blue-600 hover:underline">Back to
                Timetables</a>
        </div>
    </div>
</x-layout>
