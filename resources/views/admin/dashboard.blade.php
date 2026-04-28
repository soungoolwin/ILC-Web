<x-layout>
    {{-- Flash messages --}}
    @if ($errors->any())
        <div
            class="mx-6 mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800"
        >
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session("success"))
        <div
            class="mx-6 mt-4 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800"
        >
            {{ session("success") }}
        </div>
    @endif

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Welcome bar --}}
        <div
            class="mb-8 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back,
                    <span class="text-[#7D3C98]">
                        {{ Auth::user()->name }}
                    </span>
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ now()->format("l, F j, Y") }}
                </p>
            </div>
            <a
                href="{{ route("admin.profile") }}"
                class="inline-flex items-center gap-2 rounded-xl border border-[#7D3C98] px-4 py-2 text-sm font-medium text-[#7D3C98] transition-colors hover:bg-[#7D3C98] hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                    />
                </svg>
                My Profile
            </a>
        </div>

        {{-- Stats row --}}
        <div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @php
                $stats = [
                    ["label" => "Students", "value" => $totalStudents, "color" => "bg-violet-100 text-violet-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84 51.39 51.39 0 00-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />'],
                    ["label" => "Mentors", "value" => $totalMentors, "color" => "bg-blue-100 text-blue-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />'],
                    ["label" => "Team Leaders", "value" => $totalTeamLeaders, "color" => "bg-indigo-100 text-indigo-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5a17.92 17.92 0 01-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />'],
                    ["label" => "Forms", "value" => $totalForms, "color" => "bg-yellow-100 text-yellow-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />'],
                    ["label" => "Appointments", "value" => $totalAppointments, "color" => "bg-green-100 text-green-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />'],
                    ["label" => "Timetables", "value" => $totalTimetables, "color" => "bg-orange-100 text-orange-700", "icon" => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                ];
            @endphp

            @foreach ($stats as $s)
                <div
                    class="flex flex-col gap-2 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-500">
                            {{ $s["label"] }}
                        </span>
                        <div
                            class="{{ $s["color"] }} flex h-8 w-8 items-center justify-center rounded-lg bg-opacity-60"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                {!! $s["icon"] !!}
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($s["value"]) }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Main controls grid --}}
        <div class="grid gap-6 rounded-3xl bg-gray-100 p-6 lg:grid-cols-3">
            {{-- Users & Timetables --}}
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div
                    class="flex items-center gap-2 rounded-t-2xl bg-blue-600 px-5 py-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                        />
                    </svg>
                    <h2 class="font-semibold text-white">
                        Users &amp; Timetables
                    </h2>
                </div>
                <div class="divide-y divide-gray-100 p-2">
                    <a
                        href="{{ route("admin.mentor_students_timetable") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-blue-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Mentor–Student Timetables
                                </p>
                                <p class="text-xs text-gray-400">
                                    View all paired session schedules
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-blue-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route("admin.team_leaders_timetable") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-blue-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5a17.92 17.92 0 01-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Team Leader Timetables
                                </p>
                                <p class="text-xs text-gray-400">
                                    View team leader session slots
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-blue-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route("admin.users.index") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-red-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-500 transition-colors group-hover:bg-red-500 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Manage Users
                                </p>
                                <p class="text-xs text-gray-400">
                                    View &amp; delete user accounts
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-red-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Forms & Attendance --}}
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div
                    class="flex items-center gap-2 rounded-t-2xl bg-yellow-500 px-5 py-3"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                        />
                    </svg>
                    <h2 class="font-semibold text-white">
                        Forms &amp; Attendance
                    </h2>
                </div>
                <div class="divide-y divide-gray-100 p-2">
                    <a
                        href="{{ route("admin.forms.index") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-yellow-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 transition-colors group-hover:bg-yellow-500 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Manage Forms
                                </p>
                                <p class="text-xs text-gray-400">
                                    Create, edit &amp; delete consent forms
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-yellow-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route("admin.forms.tracking") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-yellow-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 transition-colors group-hover:bg-yellow-500 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Track Form Completion
                                </p>
                                <p class="text-xs text-gray-400">
                                    See who has submitted which forms
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-yellow-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route("admin.attendance.index") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-yellow-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 transition-colors group-hover:bg-yellow-500 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Student Attendance
                                </p>
                                <p class="text-xs text-gray-400">
                                    Upload &amp; view attendance reports
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-yellow-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                    <a
                        href="{{ route("admin.forms.create") }}"
                        class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-yellow-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 transition-colors group-hover:bg-yellow-500 group-hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4.5v15m7.5-7.5h-15"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    Create New Form
                                </p>
                                <p class="text-xs text-gray-400">
                                    Add a new consent or submission form
                                </p>
                            </div>
                        </div>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-gray-300 group-hover:text-yellow-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Analytics & Portal --}}
            <div class="flex flex-col gap-6">
                {{-- Analytics --}}
                <div
                    class="rounded-2xl border border-gray-100 bg-white shadow-sm"
                >
                    <div
                        class="flex items-center gap-2 rounded-t-2xl bg-green-600 px-5 py-3"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                            />
                        </svg>
                        <h2 class="font-semibold text-white">Analytics</h2>
                    </div>
                    <div class="p-2">
                        <a
                            href="{{ route("admin.database_analytics") }}"
                            class="group flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-green-50"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-600 transition-colors group-hover:bg-green-600 group-hover:text-white"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-800"
                                    >
                                        Database Analytics
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Charts &amp; platform usage insights
                                    </p>
                                </div>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-300 group-hover:text-green-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Quick links: public portal --}}
                <div
                    class="rounded-2xl border border-gray-100 bg-white shadow-sm"
                >
                    <div
                        class="flex items-center gap-2 rounded-t-2xl bg-[#7D3C98] px-5 py-3"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
                            />
                        </svg>
                        <h2 class="font-semibold text-white">Public Portal</h2>
                    </div>
                    <div class="divide-y divide-gray-100 p-2">
                        @php
                            $portalLinks = [
                                ["label" => "Guest Home", "sub" => "Public-facing landing page", "route" => route("guest"), "icon" => "M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"],
                                ["label" => "Newsletter", "sub" => "View RSU Global! newsletter", "route" => route("newsletter"), "icon" => "M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"],
                                ["label" => "Publications", "sub" => "Research papers listing", "route" => route("publications"), "icon" => "M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"],
                                ["label" => "About Us", "sub" => "About the PAL center", "route" => route("about"), "icon" => "M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"],
                            ];
                        @endphp

                        @foreach ($portalLinks as $link)
                            <a
                                href="{{ $link["route"] }}"
                                class="group flex items-center justify-between rounded-xl px-4 py-2.5 transition-colors hover:bg-purple-50"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-[#7D3C98] transition-colors group-hover:bg-[#7D3C98] group-hover:text-white"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-3.5 w-3.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="{{ $link["icon"] }}"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-800"
                                        >
                                            {{ $link["label"] }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $link["sub"] }}
                                        </p>
                                    </div>
                                </div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-gray-300 group-hover:text-[#7D3C98]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                    />
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- /main grid --}}
    </div>
</x-layout>
