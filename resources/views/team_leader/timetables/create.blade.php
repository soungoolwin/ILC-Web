<x-layout>
    <div class="mx-auto my-36 max-w-4xl rounded-lg bg-white p-6 shadow-md">
        <h2 class="mb-6 text-2xl font-bold text-gray-800">
            Team Leader Timetable Reservation
        </h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-100 p-4 text-red-800">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session("success"))
            <div class="mb-6 rounded-md bg-green-100 p-4 text-green-800">
                {{ session("success") }}
            </div>
        @endif

        <!-- Reservation Form -->
        <form
            method="POST"
            action="{{ route("team_leader.timetable.store") }}"
        >
            @csrf

            <!-- Day -->
            <div class="mb-4">
                <label
                    for="day"
                    class="mb-1 block text-sm font-semibold text-gray-600"
                >
                    Day
                </label>
                <select
                    name="day"
                    id="day"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required
                >
                    <option value="">Select a Day</option>
                    @foreach (["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"] as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time Slot -->
            <div class="mb-4">
                <label
                    for="time_slot"
                    class="mb-1 block text-sm font-semibold text-gray-600"
                >
                    Time Slot
                </label>
                <select
                    name="time_slot"
                    id="time_slot"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required
                >
                    <option value="">Select a Time Slot</option>
                    @foreach ($timeSlots as $slot)
                        <option value="{{ $slot }}">{{ $slot }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    class="w-full rounded-lg bg-[#7D3C98] py-3 font-bold text-white shadow-lg transition hover:shadow-xl"
                >
                    Reserve Timetable
                </button>
            </div>
        </form>
        <p class="mt-6 text-center text-sm text-gray-500">
            Note: Please ensure that your desired time slot is available before
            booking. You can view available slots
            <a
                href="{{ route("team_leader.view_timetables") }}"
                class="text-blue-500 underline"
            >
                here
            </a>
            .
        </p>
    </div>
</x-layout>
