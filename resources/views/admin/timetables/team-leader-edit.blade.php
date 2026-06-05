<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Team Leader Reservation</h2>
        <p class="text-sm text-gray-600 mb-4">
            Team Leader:
            <span class="font-semibold">{{ $teamLeader->user->name ?? 'N/A' }}</span>
            ({{ $teamLeader->team_leader_id ?? 'N/A' }})
        </p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.team_leader_timetable.update', $teamLeader->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="day" class="block text-sm font-semibold text-gray-600 mb-1">Day</label>
                <select name="day" id="day"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" required>
                    @foreach ($days as $day)
                        <option value="{{ $day }}" {{ $timetable->day === $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="time_slot" class="block text-sm font-semibold text-gray-600 mb-1">Time Slot</label>
                <select name="time_slot" id="time_slot"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" required>
                    @foreach ($timeSlots as $slot)
                        <option value="{{ $slot }}" {{ $timetable->time_slot === $slot ? 'selected' : '' }}>
                            {{ $slot }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.team_leaders_timetable') }}"
                   class="text-sm text-gray-600 hover:underline">
                    &larr; Back to team leader timetables
                </a>
                <button type="submit" class="bg-[#7D3C98] text-white font-bold py-2 px-6 rounded-md">
                    Update Reservation
                </button>
            </div>
        </form>
    </div>
</x-layout>
