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

        <section data-chart-slideshow class="relative mb-6 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <div data-chart-chrome class="flex flex-col gap-3 border-b border-gray-100 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Chart Slideshow</p>
                    <h2 data-chart-current-title class="mt-1 text-lg font-bold text-gray-900">
                        {{ $chartPicker[array_key_first($slideshowCharts)]['label'] ?? 'Analytics Chart' }}
                    </h2>
                    <p data-chart-counter class="mt-1 text-xs text-gray-500"></p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" data-chart-prev class="rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        Previous
                    </button>
                    <button type="button" data-chart-next class="rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        Next
                    </button>

                    <div class="relative">
                        <button type="button" data-chart-menu-toggle class="rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">
                            Choose Charts
                        </button>

                        <div data-chart-menu class="absolute right-0 z-20 mt-2 hidden w-72 rounded-lg border border-gray-200 bg-white shadow-lg">
                            <div class="max-h-80 overflow-y-auto p-2">
                                @foreach ($chartPicker as $key => $option)
                                    @if (isset($slideshowCharts[$key]))
                                        <label class="flex cursor-pointer items-center gap-3 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                            <input
                                                type="checkbox"
                                                value="{{ $key }}"
                                                data-chart-choice
                                                checked
                                                class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                            >
                                            <span>{{ $option['label'] }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div data-chart-stage class="relative min-h-[360px] overflow-hidden bg-white">
                @foreach ($slideshowCharts as $key => $chart)
                    <div
                        data-chart-slide="{{ $key }}"
                        data-chart-label="{{ $chartPicker[$key]['label'] ?? $key }}"
                        aria-hidden="{{ $loop->first ? 'false' : 'true' }}"
                        class="absolute inset-0 px-4 py-4 transition duration-300 {{ $loop->first ? 'opacity-100' : 'pointer-events-none opacity-0' }}"
                    >
                        <div data-chart-frame class="w-full">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                @endforeach
            </div>

            <button
                type="button"
                data-chart-fullscreen
                aria-label="Enter full screen"
                title="Full screen"
                class="absolute bottom-3 right-3 z-10 inline-flex h-10 w-10 items-center justify-center rounded-md border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50"
            >
                <svg data-fullscreen-enter-icon xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                    <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                    <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                    <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
                </svg>
                <svg data-fullscreen-exit-icon xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 3v3a2 2 0 0 1-2 2H3"></path>
                    <path d="M21 8h-3a2 2 0 0 1-2-2V3"></path>
                    <path d="M3 16h3a2 2 0 0 1 2 2v3"></path>
                    <path d="M16 21v-3a2 2 0 0 1 2-2h3"></path>
                </svg>
            </button>

            <div data-chart-chrome class="flex flex-wrap items-center justify-center gap-2 border-t border-gray-100 px-4 py-3">
                @foreach ($slideshowCharts as $key => $chart)
                    <button
                        type="button"
                        data-chart-dot="{{ $key }}"
                        class="h-2.5 w-2.5 rounded-full bg-gray-300 transition hover:bg-gray-500"
                        aria-label="{{ $chartPicker[$key]['label'] ?? $key }}"
                    ></button>
                @endforeach
            </div>
        </section>

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

        @foreach ($chartSections as $section)
            <section class="mt-6">
                <div class="mb-4 border-b border-gray-100 pb-3">
                    <h2 class="text-xl font-bold text-gray-900">{{ $section['title'] }}</h2>
                    <p class="mt-1 text-sm text-gray-500">{{ $section['description'] }}</p>
                </div>

                <div class="grid gap-4 lg:grid-cols-3">
                    @foreach ($section['charts'] as $sectionChart)
                        <div class="{{ $sectionChart['span'] ?? '' }} rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                            {!! $charts[$sectionChart['key']]->container() !!}
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

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
    @foreach ($slideshowCharts as $chart)
        {!! $chart->script() !!}
    @endforeach
    @foreach ($charts as $chart)
        {!! $chart->script() !!}
    @endforeach
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.querySelector('[data-chart-slideshow]');

            if (!root) {
                return;
            }

            const slides = Array.from(root.querySelectorAll('[data-chart-slide]'));
            const choices = Array.from(root.querySelectorAll('[data-chart-choice]'));
            const dots = Array.from(root.querySelectorAll('[data-chart-dot]'));
            const chrome = Array.from(root.querySelectorAll('[data-chart-chrome]'));
            const frames = Array.from(root.querySelectorAll('[data-chart-frame]'));
            const menu = root.querySelector('[data-chart-menu]');
            const menuToggle = root.querySelector('[data-chart-menu-toggle]');
            const title = root.querySelector('[data-chart-current-title]');
            const counter = root.querySelector('[data-chart-counter]');
            const prevButton = root.querySelector('[data-chart-prev]');
            const nextButton = root.querySelector('[data-chart-next]');
            const fullscreenButton = root.querySelector('[data-chart-fullscreen]');
            const fullscreenEnterIcon = root.querySelector('[data-fullscreen-enter-icon]');
            const fullscreenExitIcon = root.querySelector('[data-fullscreen-exit-icon]');
            const stage = root.querySelector('[data-chart-stage]');
            const storageKey = 'databaseAnalyticsSlideshowCharts';
            const allKeys = slides.map((slide) => slide.dataset.chartSlide);
            let activeKey = allKeys[0] || null;
            let timer = null;
            let fallbackFullscreen = false;

            function savedKeys() {
                try {
                    return JSON.parse(localStorage.getItem(storageKey)) || [];
                } catch (error) {
                    return [];
                }
            }

            function enabledKeys() {
                const selected = choices
                    .filter((choice) => choice.checked)
                    .map((choice) => choice.value)
                    .filter((key) => allKeys.includes(key));

                return selected.length ? selected : allKeys;
            }

            function visibleSlides() {
                const selected = enabledKeys();

                return slides.filter((slide) => selected.includes(slide.dataset.chartSlide));
            }

            function persistChoices() {
                try {
                    localStorage.setItem(storageKey, JSON.stringify(enabledKeys()));
                } catch (error) {
                    return;
                }
            }

            function setActive(key) {
                const selectedSlides = visibleSlides();

                if (!selectedSlides.length) {
                    return;
                }

                const requestedSlide = selectedSlides.find((slide) => slide.dataset.chartSlide === key);
                const activeSlide = requestedSlide || selectedSlides[0];
                activeKey = activeSlide.dataset.chartSlide;

                slides.forEach((slide) => {
                    const isEnabled = enabledKeys().includes(slide.dataset.chartSlide);
                    const isActive = slide.dataset.chartSlide === activeKey;
                    slide.classList.toggle('opacity-100', isActive);
                    slide.classList.toggle('opacity-0', !isActive);
                    slide.classList.toggle('pointer-events-none', !isActive);
                    slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
                    slide.classList.toggle('hidden', !isEnabled);
                });

                dots.forEach((dot) => {
                    const isEnabled = enabledKeys().includes(dot.dataset.chartDot);
                    const isActive = dot.dataset.chartDot === activeKey;
                    dot.classList.toggle('hidden', !isEnabled);
                    dot.classList.toggle('bg-gray-900', isActive);
                    dot.classList.toggle('bg-gray-300', !isActive);
                });

                const activeIndex = selectedSlides.findIndex((slide) => slide.dataset.chartSlide === activeKey);
                title.textContent = activeSlide.dataset.chartLabel;
                counter.textContent = `${activeIndex + 1} of ${selectedSlides.length}`;
                window.dispatchEvent(new Event('resize'));
            }

            function move(direction) {
                const selectedSlides = visibleSlides();

                if (!selectedSlides.length) {
                    return;
                }

                const currentIndex = selectedSlides.findIndex((slide) => slide.dataset.chartSlide === activeKey);
                const nextIndex = (currentIndex + direction + selectedSlides.length) % selectedSlides.length;
                setActive(selectedSlides[nextIndex].dataset.chartSlide);
            }

            function restartTimer() {
                window.clearInterval(timer);
                timer = window.setInterval(() => move(1), 8000);
            }

            function isFullscreen() {
                return document.fullscreenElement === root || fallbackFullscreen;
            }

            function syncFullscreenState() {
                const active = isFullscreen();
                root.classList.toggle('fixed', fallbackFullscreen);
                root.classList.toggle('inset-0', fallbackFullscreen);
                root.classList.toggle('z-50', fallbackFullscreen);
                root.classList.toggle('m-0', active);
                root.classList.toggle('flex', active);
                root.classList.toggle('h-screen', active);
                root.classList.toggle('flex-col', active);
                root.classList.toggle('rounded-none', active);
                root.classList.toggle('border-0', active);
                stage.classList.toggle('min-h-[360px]', !active);
                stage.classList.toggle('flex-1', active);
                stage.classList.toggle('min-h-0', active);
                stage.classList.toggle('w-full', active);
                chrome.forEach((element) => {
                    element.classList.toggle('hidden', active);
                });
                slides.forEach((slide) => {
                    slide.classList.toggle('px-4', !active);
                    slide.classList.toggle('py-4', !active);
                    slide.classList.toggle('px-6', active);
                    slide.classList.toggle('lg:px-10', active);
                    slide.classList.toggle('py-0', active);
                    slide.classList.toggle('flex', active);
                    slide.classList.toggle('items-center', active);
                    slide.classList.toggle('justify-center', active);
                });
                frames.forEach((frame) => {
                    frame.classList.toggle('w-full', active);
                    frame.classList.toggle('max-w-none', active);
                    frame.classList.toggle('mx-auto', active);
                });
                menu.classList.add('hidden');
                fullscreenEnterIcon.classList.toggle('hidden', active);
                fullscreenExitIcon.classList.toggle('hidden', !active);
                fullscreenButton.setAttribute('aria-label', active ? 'Exit full screen' : 'Enter full screen');
                fullscreenButton.setAttribute('title', active ? 'Exit full screen' : 'Full screen');
                window.setTimeout(() => window.dispatchEvent(new Event('resize')), 150);
            }

            async function toggleFullscreen() {
                if (isFullscreen()) {
                    if (document.fullscreenElement === root) {
                        await document.exitFullscreen();
                    } else {
                        fallbackFullscreen = false;
                        syncFullscreenState();
                    }

                    return;
                }

                if (root.requestFullscreen) {
                    try {
                        await root.requestFullscreen();
                        return;
                    } catch (error) {
                        fallbackFullscreen = true;
                        syncFullscreenState();
                        return;
                    }
                }

                fallbackFullscreen = true;
                syncFullscreenState();
            }

            const selectedFromStorage = savedKeys().filter((key) => allKeys.includes(key));

            if (selectedFromStorage.length) {
                choices.forEach((choice) => {
                    choice.checked = selectedFromStorage.includes(choice.value);
                });
            }

            choices.forEach((choice) => {
                choice.addEventListener('change', () => {
                    if (!choices.some((item) => item.checked)) {
                        choice.checked = true;
                    }

                    persistChoices();
                    setActive(activeKey);
                    restartTimer();
                });
            });

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    setActive(dot.dataset.chartDot);
                    restartTimer();
                });
            });

            prevButton.addEventListener('click', () => {
                move(-1);
                restartTimer();
            });

            nextButton.addEventListener('click', () => {
                move(1);
                restartTimer();
            });

            fullscreenButton.addEventListener('click', () => {
                toggleFullscreen();
                restartTimer();
            });

            menuToggle.addEventListener('click', (event) => {
                event.stopPropagation();
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', (event) => {
                if (!root.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });

            document.addEventListener('fullscreenchange', syncFullscreenState);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && fallbackFullscreen) {
                    fallbackFullscreen = false;
                    syncFullscreenState();
                }
            });

            setActive(activeKey);
            syncFullscreenState();
            restartTimer();
        });
    </script>
</x-layout>
