<x-layout>
    {{-- Hero --}}
    <div
        class="relative flex min-h-[320px] w-full items-center overflow-hidden bg-slate-900"
    >
        <div class="absolute inset-0 z-0">
            <img
                src="{{ asset("images/banner.webp") }}"
                alt="Background"
                class="h-full w-full object-cover opacity-30"
            />
            <div
                class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-900/40"
            ></div>
        </div>
        <div class="relative z-10 px-6 py-16 text-white lg:px-80">
            <div
                class="mb-3 inline-flex items-center gap-2 rounded-full border border-gray-500 bg-gray-800/50 px-3 py-1 backdrop-blur-sm"
            >
                <span class="h-2 w-2 rounded-full bg-[#7D3C98]"></span>
                <span
                    class="text-xs font-medium uppercase tracking-wider text-gray-300"
                >
                    Peer-Assisted Learning Center
                </span>
            </div>
            <h1 class="mb-4 text-4xl font-bold leading-tight md:text-5xl">
                About
                <span class="text-[#7D3C98]">RSU Global!</span>
            </h1>
            <p
                class="max-w-xl text-sm leading-relaxed text-gray-300 lg:text-base"
            >
                The official Peer-Assisted Learning (PAL) center for Rangsit
                University — bridging cultures, building skills, and empowering
                students through the power of peer mentorship.
            </p>
        </div>
    </div>

    <nav class="flex w-full justify-start px-4 py-2">
        <a
            href="{{ route("guest") }}"
            class="px-4 py-4 text-sm text-[#7D3C98] hover:underline"
        >
            &larr; Go back to Home
        </a>
    </nav>

    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        {{-- What We Are --}}
        <section class="mb-16">
            <div
                class="mb-2 inline-block rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#7D3C98]"
            >
                Our Story
            </div>
            <h2 class="mb-4 text-3xl font-bold text-gray-800">
                What is RSU Global! PAL Center?
            </h2>
            <div class="grid gap-6 lg:grid-cols-2">
                <p class="leading-relaxed text-gray-600">
                    RSU Global! is the official Peer-Assisted Learning (PAL)
                    center at Rangsit University, Thailand. Founded by Dr.
                    Edward Devere Bacon and co-led by Aj. Gary Ambito
                    Torremucha, the center was established with a clear purpose:
                    to help international and Thai students build genuine
                    English communication skills in a real-world, peer-driven
                    environment.
                </p>
                <p class="leading-relaxed text-gray-600">
                    Unlike traditional language classrooms, RSU Global! pairs
                    students with trained peer mentors — international students
                    fluent in English — who guide them through structured
                    sessions covering speaking, listening, academic writing, and
                    intercultural exchange. The program is grounded in published
                    research and continuously refined based on outcomes data.
                </p>
            </div>
        </section>

        {{-- Mission & Vision --}}
        <section class="mb-16 grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl bg-[#7D3C98] p-8 text-white shadow-lg">
                <div
                    class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-white/20"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"
                        />
                    </svg>
                </div>
                <h3 class="mb-3 text-xl font-bold">Our Mission</h3>
                <p class="text-sm leading-relaxed text-purple-100">
                    To enhance English communication skills among Rangsit
                    University students through structured, research-backed
                    peer-assisted learning — fostering intercultural competence,
                    academic confidence, and lifelong language skills.
                </p>
            </div>
            <div
                class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg"
            >
                <div
                    class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-[#7D3C98]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                </div>
                <h3 class="mb-3 text-xl font-bold text-gray-800">Our Vision</h3>
                <p class="text-sm leading-relaxed text-gray-600">
                    To become the leading model of internationalization at home
                    in Southeast Asia — a program where language learning and
                    cultural integration happen naturally through authentic
                    human connection between peers.
                </p>
            </div>
        </section>

        {{-- How the Platform Works --}}
        <section class="mb-16">
            <div
                class="mb-2 inline-block rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#7D3C98]"
            >
                How It Works
            </div>
            <h2 class="mb-2 text-3xl font-bold text-gray-800">
                The Platform & Its Roles
            </h2>
            <p class="mb-8 max-w-2xl text-sm leading-relaxed text-gray-500">
                The RSU Global! portal connects three groups of people — each
                with a distinct role that keeps the program running smoothly.
            </p>
            <div class="grid gap-6 sm:grid-cols-3">
                {{-- Students --}}
                <div
                    class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#7D3C98]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84 51.39 51.39 0 00-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"
                            />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Students</h3>
                    <p class="text-xs leading-relaxed text-gray-500">
                        Thai university students enrolled in the PAL program.
                        Through the portal, students browse available mentors,
                        book one-on-one or group sessions, and track their
                        appointments and progress over time.
                    </p>
                    <span
                        class="mt-auto inline-block rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-[#7D3C98]"
                    >
                        Book sessions · Track progress
                    </span>
                </div>
                {{-- Mentors --}}
                <div
                    class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#7D3C98]"
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
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Mentors</h3>
                    <p class="text-xs leading-relaxed text-gray-500">
                        International students and fluent English speakers who
                        volunteer as peer mentors. Mentors set their
                        availability via a timetable, accept session bookings,
                        and guide students through speaking practice, writing
                        feedback, and cultural conversations.
                    </p>
                    <span
                        class="mt-auto inline-block rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-[#7D3C98]"
                    >
                        Set timetable · Run sessions
                    </span>
                </div>
                {{-- Team Leaders --}}
                <div
                    class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#7D3C98]"
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
                    <h3 class="text-lg font-bold text-gray-800">
                        Team Leaders
                    </h3>
                    <p class="text-xs leading-relaxed text-gray-500">
                        Senior international students who take on a coordination
                        role. Team Leaders oversee their assigned mentor groups,
                        manage timetables, review consent forms, and ensure
                        sessions run effectively across their cohort.
                    </p>
                    <span
                        class="mt-auto inline-block rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-[#7D3C98]"
                    >
                        Coordinate · Oversee mentors
                    </span>
                </div>
            </div>
        </section>

        {{-- How to Contribute --}}
        <section class="mb-16">
            <div
                class="mb-2 inline-block rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#7D3C98]"
            >
                Get Involved
            </div>
            <h2 class="mb-2 text-3xl font-bold text-gray-800">
                How You Can Contribute
            </h2>
            <p class="mb-8 max-w-2xl text-sm leading-relaxed text-gray-500">
                RSU Global! runs because people choose to give their time and
                skill. Here's how you can be part of it.
            </p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    class="rounded-xl border border-[#7D3C98] bg-white p-5 shadow-sm"
                >
                    <h4 class="mb-2 font-semibold text-gray-800">
                        Become a Mentor
                    </h4>
                    <p class="text-xs leading-relaxed text-gray-500">
                        If you're an international student with strong English
                        skills, register as a mentor. You'll set your own
                        schedule and help students grow through guided
                        conversation and writing sessions.
                    </p>
                    <a
                        href="{{ route("register.mentor") }}"
                        class="mt-3 inline-block text-xs font-medium text-[#7D3C98] hover:underline"
                    >
                        Register as Mentor &rarr;
                    </a>
                </div>
                <div
                    class="rounded-xl border border-[#7D3C98] bg-white p-5 shadow-sm"
                >
                    <h4 class="mb-2 font-semibold text-gray-800">
                        Join as a Team Leader
                    </h4>
                    <p class="text-xs leading-relaxed text-gray-500">
                        Experienced mentors can step up as Team Leaders —
                        coordinating sessions, supporting newer mentors, and
                        helping the administrative side of the program run
                        smoothly.
                    </p>
                    <a
                        href="{{ route("register.team_leader") }}"
                        class="mt-3 inline-block text-xs font-medium text-[#7D3C98] hover:underline"
                    >
                        Register as Team Leader &rarr;
                    </a>
                </div>
                <div
                    class="rounded-xl border border-[#7D3C98] bg-white p-5 shadow-sm"
                >
                    <h4 class="mb-2 font-semibold text-gray-800">
                        Enrol as a Student
                    </h4>
                    <p class="text-xs leading-relaxed text-gray-500">
                        Thai students at Rangsit University can join the program
                        to access one-on-one mentoring sessions, improve their
                        English, and gain real intercultural experience on
                        campus.
                    </p>
                    <a
                        href="{{ route("register.student") }}"
                        class="mt-3 inline-block text-xs font-medium text-[#7D3C98] hover:underline"
                    >
                        Register as Student &rarr;
                    </a>
                </div>
                <div
                    class="rounded-xl border border-[#7D3C98] bg-white p-5 shadow-sm"
                >
                    <h4 class="mb-2 font-semibold text-gray-800">
                        Explore Our Research
                    </h4>
                    <p class="text-xs leading-relaxed text-gray-500">
                        RSU Global! is built on peer-reviewed research. Browse
                        published papers by the center's directors — covering
                        intercultural competence, PAL outcomes, and language
                        acquisition.
                    </p>
                    <a
                        href="{{ route("publications") }}"
                        class="mt-3 inline-block text-xs font-medium text-[#7D3C98] hover:underline"
                    >
                        View Publications &rarr;
                    </a>
                </div>
            </div>
        </section>

        {{-- Leadership --}}
        <section class="mb-16">
            <div
                class="mb-2 inline-block rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#7D3C98]"
            >
                Leadership
            </div>
            <h2 class="mb-8 text-3xl font-bold text-gray-800">
                Who Runs RSU Global!
            </h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div
                    class="flex gap-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#7D3C98] text-xl font-bold text-white"
                    >
                        EB
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">
                            Dr. Edward Devere Bacon
                        </h3>
                        <p class="mb-2 text-xs text-[#7D3C98]">
                            Director & Founder
                        </p>
                        <p class="text-xs leading-relaxed text-gray-500">
                            Dr. Bacon founded RSU Global! with the goal of
                            creating a sustainable, research-driven peer
                            learning model at Rangsit University. His work spans
                            intercultural communication, EFL academic writing,
                            and PAL program design — with over 15 published
                            papers directly stemming from the center's work.
                        </p>
                    </div>
                </div>
                <div
                    class="flex gap-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#7D3C98] text-xl font-bold text-white"
                    >
                        GT
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">
                            Aj. Gary Ambito Torremucha
                        </h3>
                        <p class="mb-2 text-xs text-[#7D3C98]">
                            Deputy Director
                        </p>
                        <p class="text-xs leading-relaxed text-gray-500">
                            Aj. Gary co-leads the program and oversees the
                            day-to-day operations of RSU Global!, mentoring the
                            team leaders and mentors, and collaborating on the
                            research that underpins the program's continuous
                            improvement.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Research note --}}
        <section class="mb-16 rounded-2xl bg-gray-50 p-8">
            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
            >
                <div class="max-w-2xl">
                    <div
                        class="mb-2 inline-block rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-[#7D3C98]"
                    >
                        Research-Backed
                    </div>
                    <h3 class="mb-2 text-2xl font-bold text-gray-800">
                        Grounded in Peer-Reviewed Research
                    </h3>
                    <p class="text-sm leading-relaxed text-gray-500">
                        Everything RSU Global! does is informed by published
                        academic research. The center's directors have authored
                        17+ papers in Scopus-indexed journals and international
                        conference proceedings, covering intercultural
                        development, PAL outcomes across disciplines, and the
                        impact of peer mentorship on EFL learners. The platform
                        itself is a direct outcome of that ongoing work.
                    </p>
                </div>
                <a
                    href="{{ route("publications") }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#7D3C98] px-6 py-3 text-sm font-medium text-white shadow-md transition-colors hover:bg-[#7D3C98]/90"
                >
                    Browse Publications
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                        />
                    </svg>
                </a>
            </div>
        </section>

        {{-- CTA --}}
        <section
            class="rounded-2xl bg-[#7D3C98] p-10 text-center text-white shadow-xl"
        >
            <h2 class="mb-3 text-3xl font-bold">Ready to get started?</h2>
            <p
                class="mx-auto mb-6 max-w-lg text-sm leading-relaxed text-purple-100"
            >
                Whether you're a student looking to improve your English, an
                international student who wants to give back, or a coordinator —
                there's a role here for you.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a
                    href="{{ route("register.student") }}"
                    class="rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[#7D3C98] shadow transition-opacity hover:opacity-90"
                >
                    Join as Student
                </a>
                <a
                    href="{{ route("register.mentor") }}"
                    class="rounded-xl border border-white/40 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/10"
                >
                    Join as Mentor
                </a>
                <a
                    href="{{ route("newsletter") }}"
                    class="rounded-xl border border-white/40 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-colors hover:bg-white/10"
                >
                    Read Newsletter
                </a>
            </div>
        </section>
    </div>
</x-layout>
