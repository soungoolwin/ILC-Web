{{-- resources/views/admin/attendance/preview.blade.php --}}
<x-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Attendance</h1>

        @foreach($grouped as $course => $sections)
            <div class="mb-8 border rounded-lg shadow-sm">
                <div class="bg-blue-500 px-4 py-3 flex items-center justify-between">
                    <h2 class="font-semibold text-white">
                        {{ $course }}
                        <span class="text-sm text-white opacity-80">({{ $counts[$course]['__total'] ?? 0 }} records)</span>
                    </h2>
                </div>

                {{-- Filter by Section --}}
                <div class="p-4">
                    <label for="sectionFilter-{{ $course }}" class="block font-semibold text-gray-700">Choose Section:</label>
                    <select id="sectionFilter-{{ $course }}" class="block w-full px-4 py-2 border rounded-md" onchange="filterBySection('{{ $course }}')">
                        <option value="all">All Sections</option>
                        @foreach($sections as $section => $list)
                            <option value="{{ $section }}">Section {{ $section }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Single Table for Course --}}
                <div class="p-4 space-y-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left border">Timestamp</th>
                                    <th class="px-3 py-2 text-left border">Student ID</th>
                                    <th class="px-3 py-2 text-left border">Name</th>
                                    <th class="px-3 py-2 text-left border">Email</th>
                                    <th class="px-3 py-2 text-left border">Section</th>
                                    <th class="px-3 py-2 text-left border">Date</th>
                                    <th class="px-3 py-2 text-left border">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $section => $list)
                                    @foreach($list as $r)
                                        {{-- Use data attributes to store section and course --}}
                                        <tr class="odd:bg-white even:bg-gray-50"
                                            data-section="{{ $section }}"
                                            data-course="{{ $course }}">
                                            <td class="px-3 py-2 border">{{ $r['timestamp'] }}</td>
                                            <td class="px-3 py-2 border">{{ $r['student_id'] }}</td>
                                            <td class="px-3 py-2 border">{{ $r['name'] }}</td>
                                            <td class="px-3 py-2 border">{{ $r['email'] }}</td>
                                            <td class="px-3 py-2 border">{{ $section }}</td>
                                            <td class="px-3 py-2 border">{{ $r['date'] }}</td>
                                            <td class="px-3 py-2 border">{{ $r['time'] }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <a href="{{ route('admin.attendance.index') }}" class="inline-block text-blue-600 hover:underline">⟵ Upload another CSV</a>
    </div>

    {{-- Script to filter sections --}}
    <script>
        function filterBySection(course) {
            const sectionFilter = document.getElementById('sectionFilter-' + course);
            const selectedSection = sectionFilter.value;
            
            // Get all rows for the selected course
            const rows = document.querySelectorAll(`tr[data-course="${course}"]`);
            
            if (selectedSection === 'all') {
                // Show all rows for the selected course
                rows.forEach(row => row.style.display = 'table-row');
            } else {
                // Hide all rows first
                rows.forEach(row => {
                    if (row.getAttribute('data-section') === selectedSection) {
                        row.style.display = 'table-row';  // Show the selected section rows
                    } else {
                        row.style.display = 'none';  // Hide the others
                    }
                });
            }
        }
    </script>
</x-layout>
