{{-- resources/views/admin/attendance/results.blade.php --}}
<x-layout>
    {{-- 1. Add Print-Specific Styles --}}
    <style>
        @media print {
            /* Hide everything by default */
            body * {
                visibility: hidden;
            }
            /* Make only the section to be printed and its children visible */
            .printable-section, .printable-section * {
                visibility: visible;
            }
            /* Position the printable section at the top of the page */
            .printable-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }
            /* Ensure elements that should never be printed are hidden */
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 no-print">Attendance Results</h1>

        @forelse($grouped as $course => $ajarns)
            {{-- 2. Add an ID to the main course container --}}
            <div id="course-{{ $loop->index }}" class="mb-8 border rounded-lg shadow-sm bg-white">
                {{-- Course Header --}}
                {{-- 3. Add Print Button to the header --}}
                <div class="bg-blue-600 px-4 py-3 flex justify-between items-center">
                    <h2 class="font-semibold text-white text-xl">
                        {{ $course }}
                    </h2>
                    <button onclick="printCourse('course-{{ $loop->index }}')" class="no-print bg-white text-blue-600 px-3 py-1 rounded text-sm font-semibold hover:bg-blue-100 transition">
                        Print Course
                    </button>
                </div>

                {{-- Filters (will be hidden on print) --}}
                <div class="p-4 border-b grid grid-cols-1 md:grid-cols-2 gap-4 no-print">
                    {{-- Ajarn Filter --}}
                    <div>
                        <label for="ajarnFilter-{{ $loop->index }}" class="block font-semibold text-gray-700">Filter by Ajarn:</label>
                        <select id="ajarnFilter-{{ $loop->index }}" class="mt-1 block w-full px-4 py-2 border rounded-md" onchange="filterTable('{{ $loop->index }}')">
                            <option value="all">All Ajarns ({{ $counts[$course]['__total_students'] ?? 0 }} Students)</option>
                            @foreach($ajarns as $ajarnName => $sections)
                                <option value="{{ $ajarnName }}">
                                    {{ $ajarnName }} ({{ $counts[$course][$ajarnName]['__total_students'] ?? 0 }} Students)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Section Filter --}}
                    <div>
                        <label for="sectionFilter-{{ $loop->index }}" class="block font-semibold text-gray-700">Filter by Section:</label>
                        <select id="sectionFilter-{{ $loop->index }}" class="mt-1 block w-full px-4 py-2 border rounded-md" onchange="filterTable('{{ $loop->index }}')">
                            <option value="all">All Sections</option>
                            @foreach($uniqueSections[$course] as $section)
                                <option value="{{ $section }}">Section {{ $section }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Students Table --}}
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full border course-table" data-course-index="{{ $loop->index }}">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left border">Student ID</th>
                                <th class="px-4 py-2 text-left border">Name</th>
                                <th class="px-4 py-2 text-left border">Section</th>
                                <th class="px-4 py-2 text-left border">Ajarn Name</th>
                                <th class="px-4 py-2 text-left border">Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ajarns as $ajarnName => $sections)
                                @foreach($sections as $section => $students)
                                    @foreach($students as $studentId => $studentData)
                                        <tr class="student-row odd:bg-white even:bg-gray-50" data-section="{{ $section }}" data-ajarn="{{ $ajarnName }}">
                                            <td class="px-4 py-2 border align-top">{{ $studentData['details']['student_id'] }}</td>
                                            <td class="px-4 py-2 border align-top">{{ $studentData['details']['name'] }}</td>
                                            <td class="px-4 py-2 border align-top">{{ $section }}</td>
                                            <td class="px-4 py-2 border align-top">{{ $ajarnName }}</td>
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

        <a href="{{ route('admin.attendance.index') }}" class="inline-block mt-4 text-blue-600 hover:underline no-print">⟵ Upload New Files</a>
    </div>

    <script>
        function filterTable(courseIndex) {
            const ajarnSelect = document.getElementById('ajarnFilter-' + courseIndex);
            const sectionSelect = document.getElementById('sectionFilter-' + courseIndex);
            
            const selectedAjarn = ajarnSelect.value;
            const selectedSection = sectionSelect.value;

            const table = document.querySelector(`.course-table[data-course-index="${courseIndex}"]`);
            const rows = table.querySelectorAll('tbody .student-row');

            rows.forEach(row => {
                const rowAjarn = row.dataset.ajarn;
                const rowSection = row.dataset.section;

                const ajarnMatch = (selectedAjarn === 'all' || rowAjarn === selectedAjarn);
                const sectionMatch = (selectedSection === 'all' || rowSection === selectedSection);

                if (ajarnMatch && sectionMatch) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // 4. Add the JavaScript function for printing
        function printCourse(courseId) {
            const courseToPrint = document.getElementById(courseId);
            if (courseToPrint) {
                // Temporarily add a class to the target course for the print styles to work
                courseToPrint.classList.add('printable-section');
                
                // Trigger the browser's print dialog
                window.print();
                
                // Remove the class after the print dialog is closed
                // Using a small delay ensures the class is removed after the print process starts
                setTimeout(() => {
                    courseToPrint.classList.remove('printable-section');
                }, 500);
            }
        }
    </script>
</x-layout>