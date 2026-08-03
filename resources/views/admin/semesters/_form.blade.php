@php
    // $prefill is either an existing Semester (edit) or a throwaway one
    // carrying sensible defaults (create), so this partial can serve both.
    $prefill ??= new \App\Models\Semester();
    $currentYear = now()->year;
    $tlLimits = $prefill->teamLeaderSlotLimits();
    $capacityGrid = $prefill->tableCapacityGrid();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div>
        <label for="year" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">Year</label>
        <select name="year" id="year"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
            @for ($y = $currentYear - 1; $y <= $currentYear + 3; $y++)
                <option value="{{ $y }}" {{ (int) old('year', $prefill->year ?? $currentYear) === $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>
    <div>
        <label for="term" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">Semester</label>
        <select name="term" id="term"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
            @foreach (\App\Models\Semester::TERMS as $value => $label)
                <option value="{{ $value }}" {{ (int) old('term', $prefill->term ?? 1) === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="start_date" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">Start Date</label>
        <input type="date" name="start_date" id="start_date"
            value="{{ old('start_date', optional($prefill->start_date)->format('Y-m-d')) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
    </div>
    <div>
        <label for="end_date" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">End Date</label>
        <input type="date" name="end_date" id="end_date"
            value="{{ old('end_date', optional($prefill->end_date)->format('Y-m-d')) }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
    </div>
</div>

<div class="mb-6">
    <h3 class="text-sm font-bold text-gray-700 mb-2">Team Leader Slot Limits</h3>
    <p class="text-xs text-gray-500 mb-3">Max team leaders that can reserve each time slot this semester.</p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach (\App\Models\Semester::TEAM_LEADER_TIME_SLOTS as $slot)
            <div>
                <label class="block text-xs text-gray-600 mb-1">{{ $slot }}</label>
                <input type="number" min="0" name="tl_limit[{{ $slot }}]"
                    value="{{ old('tl_limit.' . $slot, $tlLimits[$slot] ?? 0) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
            </div>
        @endforeach
    </div>
</div>

<div class="mb-6">
    <h3 class="text-sm font-bold text-gray-700 mb-2">Mentor/Student Table Capacity</h3>
    <p class="text-xs text-gray-500 mb-3">
        Number of tables (appointment slots) available each day and hour — the same day/time grid mentors and students schedule against, so there's no ambiguity about which day a number applies to.
    </p>

    <div class="mb-4 max-w-xs">
        <label for="table_capacity_default" class="block text-xs text-gray-600 mb-1">Fallback table count</label>
        <input type="number" min="1" name="table_capacity_default" id="table_capacity_default"
            value="{{ old('table_capacity_default', $prefill->tableCapacityDefault()) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
        <p class="text-xs text-gray-400 mt-1">Only used for a time slot outside the grid below.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto border-collapse border border-gray-300 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-3 py-2 text-left">Day</th>
                    @foreach (\App\Models\Semester::HOUR_SLOTS as $slot)
                        <th class="border border-gray-300 px-2 py-2 whitespace-nowrap">{{ $slot }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach (\App\Models\Semester::DAYS as $day)
                    <tr>
                        <td class="border border-gray-300 px-3 py-2 font-semibold text-gray-700">{{ $day }}</td>
                        @foreach (\App\Models\Semester::HOUR_SLOTS as $slot)
                            <td class="border border-gray-300 px-1 py-1">
                                <input type="number" min="0" name="capacity[{{ $day }}][{{ $slot }}]"
                                    value="{{ old('capacity.' . $day . '.' . $slot, $capacityGrid[$day][$slot] ?? $prefill->tableCapacityDefault()) }}"
                                    class="w-16 border border-gray-300 rounded px-2 py-1 text-center focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
