<x-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Form Completion Progress</h2>

        <div class="flex justify-center space-x-10 items-center ">
        <button onclick="showSection('studentForms')" class="print:hidden bg-blue-500 text-white px-4 py-2 rounded-lg mr-4 mb-6 hover:bg-blue-600 transition-all">
            Student Forms
        </button>

        <button onclick="showSection('mentorForms')" class="print:hidden bg-purple-500 text-white px-4 py-2 rounded-lg mr-4 mb-6 hover:bg-purple-600 transition-all">
            Mentor Forms
        </button>

        <button onclick="showSection('teamLeaderForms')" class="print:hidden bg-yellow-400 text-white px-4 py-2 rounded-lg mb-6 hover:bg-yellow-500 transition-all">
            Team Leader Forms
        </button>
        </div>
        <p class="print:hidden justify-center text-center text-sm text-gray-500 "> Expand the sections to view full tables. You can also print the tables by expanding.</p>


        {{-- STUDENTS --}}
        <div id="studentForms" class="mb-10">
            <h3 class="text-2xl font-semibold text-blue-500 mb-3">Student Forms</h3>

            
        <div class="mb-4 print:hidden flex justify-between items-center">
            <!--  Finding Students by ID -->

            <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                <input type="text" name="student_id" placeholder="Search Student ID" class="input border-blue-500 placeholder-gray-400 focus:ring-1 py-2 rounded-l-lg" />
                <button type="submit" class=" bg-blue-500 px-4 py-2 ring-1 ring-blue-500 ring-offset-1 ring-offset-white rounded-r-lg text-white hover:bg-blue-600">Search</button>
            </form>

            @if(request('student_id') && $students->isEmpty())
                <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                    No students found for ID: <strong>{{ request('student_id') }}</strong>
                </div>
            @endif

            <div class="flex items-end">

            <button onclick="toggleHeight('TableWrapperStudent', this)" class="print:hidden bg-blue-500 text-white px-4 py-2 rounded-tl-3xl mt-1 mb-4 hover:bg-blue-600 transition-all">
                Expand
            </button>
            <button id="printBtnStudent" onclick="window.print()"
                class="hidden bg-gray-200 text-blue-500 px-4 py-2 ml-1 rounded-tr-3xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">
                Print
            </button>
            </div>
        
        </div>


                <div id="TableWrapperStudent" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border transition-all duration-300">
                    <table class="min-w-full text-[12px] text-left z-10 ">
                    <thead class="bg-blue-100 text-gray-700 font-semibold sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No.</th>
                            <th class="px-4 py-2">Student ID </th>
                            <th class="px-4 py-2">Name</th>
                            @foreach($formTypes as $type)
                                <th class="px-4 py-2">{{ ucfirst($type) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            
                            <tr class="border-t">
                                <td class="px-4 py-2 border-r">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-gray-800 hover:underline">
                                        {{ $student->student_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-gray-800 hover:underline">
                                        {{ $student->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $studentStatuses[$student->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-left border-r">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold">Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Incomplete</span>
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
        <div id="mentorForms" class="mb-10 hidden">
            <h3 class="text-2xl font-semibold text-purple-800 mb-3">Mentor Forms</h3>

            <div class="mb-4 print:hidden flex justify-between items-center">

                <!-- Finding Mentors by ID -->
                <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                    <input type="text" name="mentor_id" placeholder="Search Mentor ID" class="print:hidden input border-purple-500 placeholder-gray-400 focus:ring-1 py-2 rounded-l-lg" />
                    <button type="submit" class=" print:hidden bg-purple-500 ring-1 ring-purple-500 ring-offset-1 ring-offset-white px-4 py-2 rounded-r-lg text-white hover:bg-purple-600">Search</button>
                </form>
                @if(request('mentor_id') && $mentors->isEmpty())
                    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                        No mentors found for ID: <strong>{{ request('mentor_id') }}</strong>
                    </div>
                @endif
                <div class="flex items-end">
                    <button onclick="toggleHeight('TableWrapperMentor',this)" class="bg-purple-500 text-white px-4 py-2 rounded-tl-3xl mt-1 mb-4 hover:bg-purple-600 print:hidden">
                        Expand
                    </button>
                    <button id="printBtnMentor" onclick="window.print()"
                        class="hidden bg-gray-200 text-purple-500 px-4 py-2 ml-1 rounded-tr-3xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">
                        Print
                    </button>
                </div>
            </div>

            <div id="TableWrapperMentor" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border transition-all duration-300">
                <table class="min-w-full text-[12px] text-left">
                    <thead class="bg-purple-100 text-gray-700 font-semibold sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No.</th>
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
                                <td class="px-4 py-2 border-r">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-gray-800 hover:underline">
                                        {{ $mentor->mentor_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.mentors.show', $mentor->id) }}" class="text-gray-800 hover:underline">
                                        {{ $mentor->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $mentorStatuses[$mentor->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-left border-r">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold"> Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Incomplete</span>
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
        <div id="teamLeaderForms" class="mb-10 hidden">
            <h3 class="text-2xl font-semibold text-yellow-400 mb-3">Team Leaders</h3>

            <div class="mb-4 print:hidden flex justify-between items-center">

                <!-- Finding Team Leaders by ID -->
                <form method="GET" action="{{ route('admin.forms.tracking') }}" class="mb-4">
                    <input type="text" name="team_leader_id" placeholder="Search Team Leader ID" class="print:hidden input border-yellow-400 placeholder-gray-400  focus:ring-1 py-2 rounded-l-lg" />
                    <button type="submit" class=" print:hidden bg-yellow-400 px-4 py-2 ring-1 ring-yellow-400 ring-offset-1 ring-offset-white
                    rounded-r-lg text-white hover:bg-yellow-500">Search</button>
                </form>

                @if(request('team_leader_id') && $teamleaders->isEmpty())
                    <div class="bg-red-100 border border-red-300 text-red-600 px-4 py-2 rounded mb-4 text-sm">
                        No team leaders found for ID: <strong>{{ request('team_leader_id') }}</strong>
                    </div>
                @endif

                <div class="flex items-end">
                    <button onclick="toggleHeight('TableWrapperTeamLeader',this)" class="bg-yellow-400 text-white px-4 py-2 rounded-tl-3xl mt-1 mb-4 hover:bg-yellow-500 print:hidden">
                        Expand
                    </button>
                    <button id="printBtnTeamLeader" onclick="window.print()"
                        class="hidden bg-gray-200 text-yellow-400 px-4 py-2 ml-1 rounded-tr-3xl mt-1 mb-4 hover:bg-gray-400 hover:text-white transition print:hidden">
                        Print
                    </button>
                </div>
            </div>

            <div id="TableWrapperTeamLeader" class="overflow-y-auto min-w-full max-h-64 rounded-lg shadow border">
                <table class="min-w-full text-[12px] text-left">
                    <thead class="bg-yellow-100 text-gray-700 font-semibold sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No.</th>
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
                                <td class="px-4 py-2 border-r">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.team_leaders.show', $leader->id) }}" class="text-gray-800 hover:underline">
                                        {{ $leader->team_leader_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-r">
                                    <a href="{{ route('admin.team_leaders.show', $leader->id) }}" class="text-gray-800 hover:underline">
                                        {{ $leader->user->name }}
                                    </a>
                                </td>

                                @foreach($formTypes as $type)
                                    @php $status = $teamLeaderStatuses[$leader->id][$type] ?? 'not_assigned'; @endphp
                                    <td class="px-4 py-2 text-left border-r">
                                        @if($status === 'completed')
                                            <span class="text-green-600 font-bold"> Completed</span>
                                        @elseif($status === 'not_completed')
                                            <span class="text-red-500 font-bold">Incomplete</span>
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

<script>
    function showSection(sectionId) {
        const sections = ['studentForms', 'mentorForms', 'teamLeaderForms'];

        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });

        const target = document.getElementById(sectionId);
        if (target) target.classList.remove('hidden');
    }

    function toggleHeight(wrapperId, button) {
    const wrapper = document.getElementById(wrapperId);
    const isExpanded = wrapper.classList.contains('max-h-[9999px]');

    // Build related print button ID
    const sectionName = wrapperId.replace('TableWrapper', ''); // e.g. "Student"
    const printBtnId = `printBtn${sectionName}`;
    const printBtn = document.getElementById(printBtnId);

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
