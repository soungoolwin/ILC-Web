<x-layout>
    <div class="min-h-screen bg-gray-100 py-8 px-4 print:bg-white">
    <div class="max-w-7xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg px-8 py-8 ">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Form Completion Progress</h2>

        <div class="flex justify-center space-x-10 items-center">
            <button onclick="showSection('studentForms')" class="print:hidden bg-blue-500 text-white text-[10px] lg:text-lg px-4 py-2 rounded-lg mr-4 mb-6 hover:bg-blue-600 transition-all">
                Student Forms
            </button>
            <button onclick="showSection('mentorForms')" class="print:hidden bg-purple-500 text-white text-[10px] lg:text-lg px-4 py-2 rounded-lg mr-4 mb-6 hover:bg-purple-600 transition-all">
                Mentor Forms
            </button>
            <button onclick="showSection('teamLeaderForms')" class="print:hidden bg-yellow-400 text-white text-[10px] lg:text-lg px-4 py-2 rounded-lg mb-6 hover:bg-yellow-500 transition-all">
                Team Leader Forms
            </button>
        </div>
        <p class="print:hidden justify-center text-center text-xs lg:text-sm text-gray-500">Expand the sections to view full tables. You can also print the tables by expanding.</p>



        {{-- ===================== STUDENTS ===================== --}}
        <div id="studentForms" class="mb-10">
            <h3 class="text-xl lg:text-2xl font-semibold text-blue-500 mb-3">Student Forms Overview</h3>
            <div class="mb-4 print:hidden flex justify-between items-center">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                    <input type="text" name="student_id" placeholder="Search by Student ID" class="input w-2/3 lg:w-[180px] text-xs lg:text-sm border-blue-500 placeholder-gray-400 focus:ring-1 py-2 rounded-l-lg" />
                    <button type="submit" class="text-xs lg:text-sm bg-blue-500 px-4 py-2 ring-1 ring-blue-500 ring-offset-1 ring-offset-white rounded-r-lg text-white hover:bg-blue-600">Search</button>
                </form>

                @if(request('student_id') && $students->isEmpty())
                    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                        No students found for ID: <strong>{{ request('student_id') }}</strong>
                    </div>
                @endif

                <div class="flex items-end">
                    <button onclick="toggleHeight('TableWrapperStudent', this)" class="print:hidden text-xs lg:text-sm bg-blue-500 text-white px-4 py-2 rounded-tl-xl mt-1 mb-4 hover:bg-blue-600 transition-all">Expand</button>
                    <button id="printBtnStudent" onclick="window.print()" class="hidden text-xs lg:text-sm bg-gray-200 text-blue-500 px-4 py-2 ml-1 rounded-tr-xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">Print</button>
                </div>
            </div>

                    {{-- Student Form Completion Statistics --}}

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($studentCompletionStats as $studentStat)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <h4 class="text-xs lg:text-sm font-semibold text-gray-600 mb-1">{{ $studentStat['label'] }}</h4>
                <p class="text-2xl lg:text-3xl font-bold text-blue-600">{{ number_format($studentStat['percentage'], 1) }}%</p>
                <p class="text-[10px] lg:text-xs text-gray-500 mt-1">{{ $studentStat['completed'] }}/{{ $studentStat['total'] }} completed</p>
            </div>
        @endforeach
    </div>

            <div id="TableWrapperStudent" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border transition-all duration-300">
                <table class="min-w-full text-[10px] lg:text-sm text-left z-10">
                    <thead class="bg-blue-100 text-gray-700 font-semibold sticky top-0 z-10">
                        {{-- Header row 1: type groups --}}
                        <tr>
                            <th class="px-1 py-1 text-center align-bottom">No.</th>
                            <th class="px-2 py-2 align-bottom">Student ID</th>
                            <th class="px-2 py-2 align-bottom">Name</th>
                            @foreach($formTypes as $type)
                                @php $cols = $formColumns['student'][$type] ?? collect(); @endphp
                                <th class="px-4 py-2 text-center align-bottom" colspan="{{ max($cols->count(), 1) }}">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                        {{-- Header row 2: per-form labels --}}
                        
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="border-t">
                                <td class="px-1 py-1 border-r text-center">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-gray-800 hover:underline">{{ $student->student_id }}</a>
                                </td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-gray-800 hover:underline">{{ $student->user->name }}</a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $cols = $formColumns['student'][$type] ?? collect(); @endphp
                                    @forelse($cols as $col)
                                        @php
                                            $status = $studentStatusesByForm[$student->id][$type][$col['id']] ?? 'not_completed';
                                        @endphp
                                        <td class="px-4 py-2 text-left border-r">
                                            @if($status === 'completed')
                                                <span class="text-green-600 font-bold">Completed</span>
                                            @else
                                                <span class="text-red-500 font-bold">Incomplete</span>
                                            @endif
                                        </td>
                                    @empty
                                        <td class="px-4 py-2 text-left border-r">
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        </td>
                                    @endforelse
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===================== MENTORS ===================== --}}
        <div id="mentorForms" class="mb-10 hidden">
            <h3 class="text-2xl font-semibold text-purple-800 mb-3">Mentor Forms Overview</h3>

            <div class="mb-4 print:hidden flex justify-between items-center">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                    <input type="text" name="mentor_id" placeholder="Search by Mentor ID" class="input w-2/3 lg:w-[180px] text-xs lg:text-sm print:hidden input border-purple-500 placeholder-gray-400 focus:ring-1 py-2 rounded-l-lg" />
                    <button type="submit" class="text-xs lg:text-sm print:hidden bg-purple-500 ring-1 ring-purple-500 ring-offset-1 ring-offset-white px-4 py-2 rounded-r-lg text-white hover:bg-purple-600">Search</button>
                </form>

                @if(request('mentor_id') && $mentors->isEmpty())
                    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                        No mentors found for ID: <strong>{{ request('mentor_id') }}</strong>
                    </div>
                @endif

                <div class="flex items-end">
                    <button onclick="toggleHeight('TableWrapperMentor',this)" class="bg-purple-500 text-xs lg:text-sm text-white px-4 py-2 rounded-tl-xl mt-1 mb-4 hover:bg-purple-600 print:hidden">Expand</button>
                    <button id="printBtnMentor" onclick="window.print()" class="hidden bg-gray-200 text-xs lg:text-sm text-purple-500 px-4 py-2 ml-1 rounded-tr-xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">Print</button>
                </div>
            </div>

            {{-- Mentor Form Completion Statistics --}}
    
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($mentorCompletionStats as $mentorStat)
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <h4 class="text-xs lg:text-sm font-semibold text-gray-600 mb-1">{{ $mentorStat['label'] }}</h4>
                <p class="text-2xl lg:text-3xl font-bold text-purple-600">{{ number_format($mentorStat['percentage'], 1) }}%</p>
                <p class="text-[10px] lg:text-xs text-gray-500 mt-1">{{ $mentorStat['completed'] }}/{{ $mentorStat['total'] }} completed</p>
            </div>
        @endforeach
    </div>

            <div id="TableWrapperMentor" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border transition-all duration-300">
                <table class="text-[10px] lg:text-sm min-w-full text-left">
                    <thead class="bg-purple-100 text-gray-700 font-semibold sticky top-0 z-10">
                        {{-- Header row 1 --}}
                        <tr>
                            <th class="px-1 py-1 text-center align-bottom">No.</th>
                            <th class="px-2 py-2 align-bottom">Mentor ID</th>
                            <th class="px-2 py-2 align-bottom">Name</th>
                            @foreach($formTypes as $type)
                                @php $cols = $formColumns['mentor'][$type] ?? collect(); @endphp
                                <th class="px-4 py-2 text-center align-bottom" colspan="{{ max($cols->count(), 1) }}">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                        {{-- Header row 2 --}}
                    </thead>
                    <tbody>
                        @foreach ($mentors as $mentor)
                            <tr class="border-t">
                                <td class="px-1 py-1 border-r text-center">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-gray-800 hover:underline">{{ $mentor->mentor_id }}</a>
                                </td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-gray-800 hover:underline">{{ $mentor->user->name }}</a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $cols = $formColumns['mentor'][$type] ?? collect(); @endphp
                                    @forelse($cols as $col)
                                        @php
                                            $status = $mentorStatusesByForm[$mentor->id][$type][$col['id']] ?? 'not_completed';
                                        @endphp
                                        <td class="px-4 py-2 text-left border-r">
                                            @if($status === 'completed')
                                                <span class="text-green-600 font-bold">Completed</span>
                                            @else
                                                <span class="text-red-500 font-bold">Incomplete</span>
                                            @endif
                                        </td>
                                    @empty
                                        <td class="px-4 py-2 text-left border-r">
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        </td>
                                    @endforelse
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===================== TEAM LEADERS ===================== --}}
        <div id="teamLeaderForms" class="mb-10 hidden">
            <h3 class="text-2xl font-semibold text-yellow-400 mb-3">Team Leaders Overview</h3>

            <div class="mb-4 print:hidden flex justify-between items-center">
                {{-- Search --}}
                <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                    <input type="text" name="team_leader_id" placeholder="Search by Team Leader ID" class="w-2/3 lg:w-[180px] text-xs lg:text-sm text-left print:hidden input border-yellow-400 placeholder-gray-400 focus:ring-1 py-2 rounded-l-lg" />
                    <button type="submit" class="text-xs lg:text-sm print:hidden bg-yellow-400 px-4 py-2 ring-1 ring-yellow-400 ring-offset-1 ring-offset-white rounded-r-lg text-white hover:bg-yellow-500">Search</button>
                </form>

                @if(request('team_leader_id') && $teamleaders->isEmpty())
                    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                        No team leaders found for ID: <strong>{{ request('team_leader_id') }}</strong>
                    </div>
                @endif

                <div class="flex items-end">
                    <button onclick="toggleHeight('TableWrapperTeamLeader',this)" class="bg-yellow-400 text-xs lg:text-sm text-white px-4 py-2 rounded-tl-xl mt-1 mb-4 hover:bg-yellow-500 print:hidden">Expand</button>
                    <button id="printBtnTeamLeader" onclick="window.print()" class="hidden bg-gray-200 text-xs lg:text-sm text-yellow-400 px-4 py-2 ml-1 rounded-tr-xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">Print</button>
                </div>
            </div>

            {{-- Team Leader Form Completion Statistics --}}
    
    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach($teamLeaderCompletionStats as $teamLeaderStat)
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-50 rounded-lg p-4 border border-yellow-200">
                <h4 class="text-xs lg:text-sm font-semibold text-gray-600 mb-1">{{ $teamLeaderStat['label'] }}</h4>
                <p class="text-2xl lg:text-3xl font-bold text-yellow-600">{{ number_format($teamLeaderStat['percentage'], 1) }}%</p>
                <p class="text-[10px] lg:text-xs text-gray-500 mt-1">{{ $teamLeaderStat['completed'] }}/{{ $teamLeaderStat['total'] }} completed</p>
            </div>
        @endforeach
    </div>

            <div id="TableWrapperTeamLeader" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border transition-all duration-300">
                <table class="text-[10px] lg:text-sm min-w-full text-left">
                    <thead class="bg-yellow-100 text-gray-700 font-semibold sticky top-0 z-10">
                        {{-- Header row 1 --}}
                        <tr>
                            <th class="px-1 py-1 text-center align-bottom">No.</th>
                            <th class="px-2 py-2 align-bottom">Leader ID</th>
                            <th class="px-2 py-2 align-bottom">Name</th>
                            @foreach($formTypes as $type)
                                @php $cols = $formColumns['team_leader'][$type] ?? collect(); @endphp
                                <th class="px-4 py-2 text-center align-bottom" colspan="{{ max($cols->count(), 1) }}">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teamleaders as $leader)
                            <tr class="border-t">
                                <td class="px-1 py-1 border-r text-center">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.team_leaders.show', $leader->id) }}" class="text-gray-800 hover:underline">{{ $leader->team_leader_id }}</a>
                                </td>
                                <td class="px-2 py-2 border-r">
                                    <a href="{{ route('admin.team_leaders.show', $leader->id) }}" class="text-gray-800 hover:underline">{{ $leader->user->name }}</a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $cols = $formColumns['team_leader'][$type] ?? collect(); @endphp
                                    @forelse($cols as $col)
                                        @php
                                            $status = $teamLeaderStatusesByForm[$leader->id][$type][$col['id']] ?? 'not_completed';
                                        @endphp
                                        <td class="px-4 py-2 text-left border-r">
                                            @if($status === 'completed')
                                                <span class="text-green-600 font-bold">Completed</span>
                                            @else
                                                <span class="text-red-500 font-bold">Incomplete</span>
                                            @endif
                                        </td>
                                    @empty
                                        <td class="px-4 py-2 text-left border-r">
                                            <span class="text-gray-400 italic">Not Assigned</span>
                                        </td>
                                    @endforelse
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>

<script>
    function showSection(sectionId) {
        const sections = ['studentForms', 'mentorForms', 'teamLeaderForms'];
        sections.forEach(id => document.getElementById(id)?.classList.add('hidden'));
        document.getElementById(sectionId)?.classList.remove('hidden');
    }

    function toggleHeight(wrapperId, button) {
        const wrapper = document.getElementById(wrapperId);
        const isExpanded = wrapper.classList.contains('max-h-[9999px]');
        const sectionName = wrapperId.replace('TableWrapper', ''); // e.g. "Student"
        const printBtn = document.getElementById(`printBtn${sectionName}`);

        if (isExpanded) {
            wrapper.classList.remove('max-h-[9999px]');
            wrapper.classList.add('max-h-64');
            button.textContent = "Expand";
            if (printBtn) printBtn.classList.add('hidden');
        } else {
            wrapper.classList.remove('max-h-64');
            wrapper.classList.add('max-h-[9999px]');
            button.textContent = "Collapse";
            if (printBtn) printBtn.classList.remove('hidden');
        }
    }
</script>
</x-layout>
