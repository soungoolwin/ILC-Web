<x-layout>
    <div class="mx-auto w-full max-w-7xl px-4 py-8">
        <div class="mb-6 flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 lg:text-3xl">
                    Database Analytics
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Live operational metrics from users, appointments, timetables, mentors, and forms.
                </p>
            </div>

            <div class="rounded-md border border-gray-200 bg-white px-3 py-2 text-sm text-gray-500 shadow-sm">
                Updated {{ now()->format('M j, Y H:i') }}
            </div>
        </div>

        <section class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="h-9 w-2 rounded-full {{ $stat['accent'] }}"></span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                                {{ $stat['label'] }}
                            </p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">
                                {{ number_format($stat['value']) }}
                            </p>
                            @isset($stat['meta'])
                                <p class="mt-1 text-xs text-gray-500">{{ $stat['meta'] }}</p>
                            @endisset
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="mt-6 grid gap-4 lg:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['roleDistribution']->container() !!}
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm lg:col-span-2">
                {!! $charts['appointmentsByWeek']->container() !!}
            </div>
        </section>

        <section class="mt-4 grid gap-4 lg:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm lg:col-span-2">
                {!! $charts['timetableAvailability']->container() !!}
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['mentorStatus']->container() !!}
            </div>
        </section>

        <section class="mt-4 grid gap-4 lg:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['appointmentsByDay']->container() !!}
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['appointmentsByTimeSlot']->container() !!}
            </div>
        </section>

        <section class="mt-4 grid gap-4 lg:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['accountGrowth']->container() !!}
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['formInventory']->container() !!}
            </div>
        </section>

        @foreach ($rolePanels as $panel)
            <section class="mt-6 rounded-lg border-l-4 {{ $panel['accent'] }} border-y border-r border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-4 flex flex-col gap-3 border-b border-gray-100 pb-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $panel['title'] }}</h2>
                        <p class="mt-1 text-sm text-gray-500">{{ $panel['description'] }}</p>
                    </div>

                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($panel['stats'] as $stat)
                            <div class="min-w-36 rounded-md border border-gray-200 bg-gray-50 px-3 py-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $stat['label'] }}</p>
                                <p class="mt-1 text-lg font-bold text-gray-900">{{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-{{ count($panel['charts']) === 3 ? '3' : '2' }}">
                    @foreach ($panel['charts'] as $chartKey)
                        <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            {!! $charts[$chartKey]->container() !!}
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Form Type</th>
                                <th class="px-3 py-2 text-right">Forms</th>
                                <th class="px-3 py-2 text-right">Completed</th>
                                <th class="px-3 py-2 text-right">Expected</th>
                                <th class="px-3 py-2 text-right">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($panel['completionRows'] as $row)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-gray-900">{{ $row['type'] }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['forms']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['completed']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['expected']) }}</td>
                                    <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ $row['percentage'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach

        <section class="mt-4 grid gap-4 lg:grid-cols-3">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                {!! $charts['formCompletion']->container() !!}
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm lg:col-span-2">
                <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Form Completion by Role</h2>
                        <p class="text-xs text-gray-500">Expected completions are role members multiplied by assigned forms.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Role</th>
                                <th class="px-3 py-2 text-right">Members</th>
                                <th class="px-3 py-2 text-right">Forms</th>
                                <th class="px-3 py-2 text-right">Completed</th>
                                <th class="px-3 py-2 text-right">Expected</th>
                                <th class="px-3 py-2 text-right">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($formCompletionStats as $row)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-gray-900">{{ $row['label'] }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['people']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['forms']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['completed']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['expected']) }}</td>
                                    <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ $row['percentage'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="mt-4 grid gap-4 lg:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900">Daily Load Detail</h2>
                    <p class="text-xs text-gray-500">Appointment utilization compared with mentor timetable capacity.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Day</th>
                                <th class="px-3 py-2 text-right">Slots</th>
                                <th class="px-3 py-2 text-right">Capacity</th>
                                <th class="px-3 py-2 text-right">Appointments</th>
                                <th class="px-3 py-2 text-right">Students</th>
                                <th class="px-3 py-2 text-right">Use</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($dayLoadRows as $row)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-gray-900">{{ $row['day'] }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['slots']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['capacity']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['appointments']) }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row['students']) }}</td>
                                    <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ $row['utilization'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900">Time Slot Detail</h2>
                    <p class="text-xs text-gray-500">Exact timetable slots ranked by appointment count.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Time Slot</th>
                                <th class="px-3 py-2 text-right">Appointments</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($timeSlotRows as $row)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-gray-900">{{ $row->time_slot }}</td>
                                    <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ number_format($row->total) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-6 text-center text-gray-500">No appointment time slot data yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="mt-4 grid gap-4 lg:grid-cols-2">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900">Users by Faculty</h2>
                    <p class="text-xs text-gray-500">Top faculty values recorded in user profiles.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Faculty</th>
                                <th class="px-3 py-2 text-right">Users</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($facultyRows as $row)
                                <tr>
                                    <td class="px-3 py-3 font-medium text-gray-900">{{ $row->faculty }}</td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($row->total) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-6 text-center text-gray-500">No user data yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900">Top Mentors by Appointments</h2>
                    <p class="text-xs text-gray-500">Mentors ranked by booked student appointments.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Mentor</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2 text-right">Slots</th>
                                <th class="px-3 py-2 text-right">Appointments</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($topMentors as $mentor)
                                <tr>
                                    <td class="px-3 py-3">
                                        <div class="font-medium text-gray-900">{{ $mentor->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $mentor->mentor_id }}</div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                            {{ ucfirst($mentor->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-right text-gray-700">{{ number_format($mentor->timetable_count) }}</td>
                                    <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ number_format($mentor->appointment_count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-6 text-center text-gray-500">No mentor appointment data yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ $charts['roleDistribution']->cdn() }}"></script>
    @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach
</x-layout>
