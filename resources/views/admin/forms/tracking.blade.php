<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Form Completion Tracking</h2>

        {{-- STUDENTS --}}
        <div class="mb-10">
            <h3 class="text-2xl font-semibold text-blue-800 mb-3">Students</h3>
            <div class="overflow-auto rounded-lg shadow border">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-blue-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2">Student ID</th>
                            <th class="px-4 py-2">Name</th>
                            @foreach($formTypes as $type)
                                <th class="px-4 py-2">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-blue-600 hover:underline">
                                        {{ $student->student_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-blue-600 hover:underline">
                                        {{ $student->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $studentStatuses[$student->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-center">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold">Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Not Completed</span>
                                        @else
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MENTORS --}}
        <div class="mb-10">
            <h3 class="text-2xl font-semibold text-purple-800 mb-3">Mentors</h3>
            <div class="overflow-auto rounded-lg shadow border">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-purple-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2">Mentor ID</th>
                            <th class="px-4 py-2">Name</th>
                            @foreach($formTypes as $type)
                                <th class="px-4 py-2">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mentors as $mentor)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-purple-600 hover:underline">
                                        {{ $mentor->mentor_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-purple-600 hover:underline">
                                        {{ $mentor->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $mentorStatuses[$mentor->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-center">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold"> Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Not Completed</span>
                                        @else
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TEAM LEADERS --}}
        <div class="mb-10">
            <h3 class="text-2xl font-semibold text-yellow-800 mb-3">Team Leaders</h3>
            <div class="overflow-auto rounded-lg shadow border">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-yellow-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2">Team Leader ID</th>
                            <th class="px-4 py-2">Name</th>
                            @foreach($formTypes as $type)
                                <th class="px-4 py-2">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamleaders as $leader)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-purple-600 hover:underline">
                                        {{ $mentor->mentor_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-purple-600 hover:underline">
                                        {{ $mentor->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $teamLeaderStatuses[$leader->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-center">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold"> Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Not Completed</span>
                                        @else
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
