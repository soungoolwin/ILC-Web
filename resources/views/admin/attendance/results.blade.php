{{-- resources/views/admin/attendance/results.blade.php --}}
<x-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Attendance Results</h1>

        @forelse($grouped as $course => $sections)
            <div class="mb-8 border rounded-lg shadow-sm bg-white">
                {{-- Course Header --}}
                <div class="bg-blue-600 px-4 py-3">
                    <h2 class="font-semibold text-white text-xl">
                        {{ $course }}
                    </h2>
                </div>

                {{-- Section Filter --}}
                <div class="p-4 border-b">
                    <label for="sectionFilter-{{ $loop->index }}" class="block font-semibold text-gray-700">Filter by Section:</label>
                    <select id="sectionFilter-{{ $loop->index }}" class="mt-1 block w-full md:w-1/3 px-4 py-2 border rounded-md" onchange="filterBySection('{{ $loop->index }}')">
                        <option value="all">All Sections ({{ $counts[$course]['__total_students'] ?? 0 }} Students)</option>
                        @foreach($sections as $section => $students)
                            <option value="{{ $section }}">
                                Section {{ $section }} ({{ $counts[$course][$section]['student_count'] ?? 0 }} Students)
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Students Table --}}
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full border course-table" data-course-index="{{ $loop->index }}">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left border">Student ID</th>
                                <th class="px-4 py-2 text-left border">Name</th>
                                <th class="px-4 py-2 text-left border">Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $section => $students)
                                @foreach($students as $studentId => $studentData)
                                    <tr class="student-row odd:bg-white even:bg-gray-50" data-section="{{ $section }}">
                                        <td class="px-4 py-2 border align-top">{{ $studentData['details']['student_id'] }}</td>
                                        <td class="px-4 py-2 border align-top">{{ $studentData['details']['name'] }}</td>
                                        <td class="px-4 py-2 border align-top">
                                            <div class="space-y-1">
                                                @foreach($studentData['sessionsByDate'] as $date => $sessions)
                                                    <div>
                                                        <span class="font-semibold">{{ $date }}:</span>
                                                        <span>{{ implode(', ', array_column($sessions, 'time')) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">No Matches Found</p>
                <p>No records could be matched between the check-in and check-out files.</p>
            </div>
        @endforelse

        <a href="{{ route('admin.attendance.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">⟵ Upload New Files</a>
    </div>

    {{-- JavaScript for Section Filtering --}}
    <script>
        function filterBySection(courseIndex) {
            const select = document.getElementById('sectionFilter-' + courseIndex);
            const selectedSection = select.value;
            const table = document.querySelector(`.course-table[data-course-index="${courseIndex}"]`);
            const rows = table.querySelectorAll('tbody .student-row');

            rows.forEach(row => {
                if (selectedSection === 'all' || row.dataset.section === selectedSection) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</x-layout>