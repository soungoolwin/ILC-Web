<x-layout>
    <!-- Main content with video -->
    <div class="mx-auto w-screen">
        <!-- Hero Section -->
        <div class="relative flex min-h-[600px] w-full items-center overflow-hidden bg-slate-900 lg:min-h-[650px]">

            <!-- Background Image -->
            <div class="absolute inset-0 z-0">

                <img src="{{ asset('images/banner.webp') }}" alt="Background"
                    class="h-full w-full object-cover object-center opacity-50 transition-transform duration-[2000ms] hover:scale-105" />

                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-slate-900/40"></div>

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/70 to-slate-900/20"></div>

                <!-- Bottom Fade -->
                <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-900/50 to-transparent"></div>

            </div>


            <!-- Hero Content -->
            <div class="container relative z-10 mx-auto px-6 py-20 sm:px-10 lg:px-24 xl:px-36">

                <div class="max-w-3xl">

                    <!-- Badge -->
            <div class="container relative z-10 mx-auto px-2 py-12 text-white max-w-7xl">
                <div class="max-w-2xl">
                    <div
                        class="mb-6 inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-4 py-2 shadow-lg backdrop-blur-md">
                        <span class="relative flex h-2.5 w-2.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#B98CCB] opacity-75"></span>

                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-[#7D3C98]"></span>
                        </span>

                        <span class="text-xs font-medium uppercase tracking-[0.15em] text-gray-200 sm:text-sm">
                            Peer-Assisted Learning Center
                        </span>
                    </div>


                    <!-- Heading -->
                    <h1
                        class="mb-6 text-4xl font-bold leading-[1.1] tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl">
                        Empowering
                        <span class="text-[#B98CCB]">Global</span>
                        <br />
                        Communication
                    </h1>


                    <!-- Description -->
                    <p class="mb-8 max-w-xl text-sm leading-7 text-gray-300 sm:text-base lg:text-lg">
                        Connect with mentors, improve your English skills, and
                        become part of Rangsit University's vibrant
                        international community.
                    </p>


                    <!-- Buttons -->
                    <div class="flex flex-wrap items-center gap-4">

                        <!-- Primary Button -->
                        <a href="{{ route('register.mentor') }}"
                            class="group inline-flex items-center gap-2 rounded-lg bg-[#7D3C98] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple-950/30 transition-all duration-300 hover:-translate-y-1 hover:bg-[#6C3483] hover:shadow-xl hover:shadow-purple-950/40 lg:px-8 lg:py-3.5">
                            Join Mentorship

                            <span class="transition-transform duration-300 group-hover:translate-x-1">
                                →
                            </span>
                        </a>


                        <!-- Secondary Button -->
                        <a href="#about"
                            class="group inline-flex items-center gap-2 rounded-lg border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-white hover:bg-white hover:text-[#7D3C98] lg:px-8 lg:py-3.5">
                        <a
                            href="{{ route('about') }}"
                            class="rounded-md border border-gray-600 bg-gray-800/40 px-3 py-2 lg:px-8 lg:py-3 font-medium text-white backdrop-blur-sm transition-all hover:bg-gray-700/60"
                        >
                            Learn More

                            <span class="transition-transform duration-300 group-hover:translate-x-1">
                                ↓
                            </span>
                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-2 gap-4 px-6 py-12 sm:gap-6 lg:grid-cols-4 lg:gap-6 lg:px-24 lg:py-20">

            <!-- Active Students -->
            <div
                class="group flex flex-col items-center justify-center rounded-2xl border border-gray-100 bg-white px-4 py-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#7D3C98]/20 hover:shadow-lg lg:py-9">
                <!-- Icon -->
                <div
                    class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor"
                            class="text-[#7D3C98] transition-colors duration-300 group-hover:text-white"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-[#7D3C98] lg:text-3xl">
                    {{ number_format($totalStudents) }}+
                </h1>

                <p class="mt-1 text-xs font-medium text-gray-500 lg:text-sm">
                    Active Students
                </p>
            </div>


            <!-- Mentors -->
            <div
                class="group flex flex-col items-center justify-center rounded-2xl border border-gray-100 bg-white px-4 py-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#7D3C98]/20 hover:shadow-lg lg:py-9">
                <!-- Icon -->
                <div
                    class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor"
                            class="text-[#7D3C98] transition-colors duration-300 group-hover:text-white"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372a9.337 9.337 0 0 0 4.121-.952a4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0a3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0a2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-[#7D3C98] lg:text-3xl">
                    {{ number_format($totalMentors) }}+
                </h1>

                <p class="mt-1 text-xs font-medium text-gray-500 lg:text-sm">
                    Mentors
                </p>
            </div>


            <!-- Team Leaders -->
            <div
                class="group flex flex-col items-center justify-center rounded-2xl border border-gray-100 bg-white px-4 py-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#7D3C98]/20 hover:shadow-lg lg:py-9">
                <!-- Icon -->
                <div
                    class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor"
                            class="text-[#7D3C98] transition-colors duration-300 group-hover:text-white"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-[#7D3C98] lg:text-3xl">
                    {{ number_format($totalTeamLeaders) }}+
                </h1>

                <p class="mt-1 text-xs font-medium text-gray-500 lg:text-sm">
                    Team Leaders
                </p>
            </div>


            <!-- Programs -->
            <div
                class="group flex flex-col items-center justify-center rounded-2xl border border-gray-100 bg-white px-4 py-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#7D3C98]/20 hover:shadow-lg lg:py-9">
                <!-- Icon -->
                <div
                    class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor"
                            class="text-[#7D3C98] transition-colors duration-300 group-hover:text-white"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>

                <h1 class="text-2xl font-bold text-[#7D3C98] lg:text-3xl">
                    50+
                </h1>

                <p class="mt-1 text-xs font-medium text-gray-500 lg:text-sm">
                    Programs
                </p>
            </div>

        </div>

        <div class="flex flex-col justify-center gap-4 px-2 py-12 lg:px-24 lg:py-24 text-center bg-gray-50 rounded-lg">
            <div class="mb-10 text-center">
                <span
                    class="mb-3 inline-block rounded-full bg-[#7D3C98]/10 px-4 py-2 text-sm font-medium text-[#7D3C98]">
                    Explore RSU Global!
                </span>

                <h1 class="mb-4 text-3xl font-bold tracking-tight text-gray-800 lg:text-4xl">
                    Why join RSUGlobal! PAL?
                </h1>

                <p class="mx-auto max-w-2xl text-sm leading-relaxed text-gray-500 lg:text-base">
                    We believe in the power of peer-to-peer learning to break down language barriers and foster cultural
                    exchange.
                </p>
            </div>

            {{-- 4 Cards --}}
            <div class="grid grid-cols-1 gap-6 px-2 sm:grid-cols-2 lg:grid-cols-4 lg:px-24">

                <!-- Card 1: Newsletter -->
                <div
                    class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 text-left shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <!-- Icon -->
                    <div
                        class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98] group-hover:text-white group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <h2 class="mb-3 text-lg font-semibold text-gray-800">
                        RSU Global! Newsletter
                    </h2>

                    <p class="mb-6 flex-grow text-sm leading-relaxed text-gray-500">
                        Stay updated with the latest news, activities, events, and
                        opportunities from the RSU Global! community.
                    </p>

                    <!-- Button -->
                    <a href="{{ route('newsletter') }}"
                        class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#7D3C98]/10 px-4 py-2 text-sm font-medium text-[#7D3C98] transition-all duration-300 hover:bg-[#7D3C98] hover:text-white">
                        Learn More
                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    <a href="{{ route('newsletter') }}" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &rarr;
                    </a>
                </div>


                <!-- Card 2: Mentor of the Month -->
                <div
                    class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 text-left shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <!-- Icon -->
                    <div
                        class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98] group-hover:text-white group-hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1.5"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372a9.337 9.337 0 0 0 4.121-.952a4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0a3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0a2.625 2.625 0 0 1-5.25 0Z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <h2 class="mb-3 text-lg font-semibold text-gray-800">
                        Mentor of the Month
                    </h2>

                    <p class="mb-6 flex-grow text-sm leading-relaxed text-gray-500">
                        Discover inspiring mentors who share their knowledge and
                        experiences to help others grow and succeed.
                    </p>

                    <!-- Button -->
                    <a href="#"
                        class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#7D3C98]/10 px-4 py-2 text-sm font-medium text-[#7D3C98] transition-all duration-300 hover:bg-[#7D3C98] hover:text-white">
                        Learn More
                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    <h2 class="text-lg font-semibold text-gray-800">
                       RSU Global! Publications
                    </h2>
                    <p class="text-xs text-gray-500 min-h-[60px]">
                        Access publications, research papers, and resources to support your language learning journey and academic success. 
                    </p>
                    <a href="{{ route('publications') }}" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &rarr;
                    </a>
                </div>


                <!-- Card 3: RSU/IRS 127 -->
                <div
                    class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 text-left shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <!-- Icon -->
                    <div
                        class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98] group-hover:text-white group-hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1.5"
                                d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41a60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84a51.39 51.39 0 0 0-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <h2 class="mb-3 text-lg font-semibold text-gray-800">
                        RSU/IRS 127
                    </h2>

                    <p class="mb-6 flex-grow text-sm leading-relaxed text-gray-500">
                        Improve your academic writing, presentation skills, and
                        confidence for your future career.
                    </p>

                    <!-- Button -->
                    <a href="#"
                        class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#7D3C98]/10 px-4 py-2 text-sm font-medium text-[#7D3C98] transition-all duration-300 hover:bg-[#7D3C98] hover:text-white">
                        Learn More
                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    <a href="#" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &rarr;
                    </a>
                </div>


                <!-- Card 4: YouTube -->
                <div
                    class="group flex h-full flex-col rounded-2xl border border-gray-100 bg-white p-6 text-left shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <!-- Icon -->
                    <div
                        class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#7D3C98]/10 transition-all duration-300 group-hover:bg-[#7D3C98] group-hover:text-white group-hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                d="m15.75 10.5l4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <h2 class="mb-3 text-lg font-semibold text-gray-800">
                        YouTube @RSUGlobal
                    </h2>

                    <p class="mb-6 flex-grow text-sm leading-relaxed text-gray-500">
                        Access a library of video resources covering language learning,
                        cultural insights, and success stories from our community.
                    </p>

                    <!-- Button -->
                    <a href="https://www.youtube.com/@RSUGlobal555/featured"
                        class="inline-flex w-fit items-center gap-2 rounded-lg bg-[#7D3C98]/10 px-4 py-2 text-sm font-medium text-[#7D3C98] transition-all duration-300 hover:bg-[#7D3C98] hover:text-white">
                        Watch Videos
                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    <a href="https://www.youtube.com/@RSUGlobal555" target="_blank" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &rarr;
                    </a>
                </div>

            </div>

        </div>
        <!-- Final Call to Action -->
        <div class="bg-[#7D3C98] px-4 py-20 lg:py-24">
            <div class="mx-auto max-w-3xl text-center">

                <!-- Small Label -->
                <span
                    class="mb-4 inline-block rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-medium uppercase tracking-wider text-white">
                    Join Our Community
                </span>

                <!-- Heading -->
                <h1 class="mb-5 text-3xl font-bold tracking-tight text-white lg:text-5xl">
                    Ready to Start Your Journey?
                </h1>

                <!-- Description -->
                <p class="mx-auto mb-8 max-w-2xl text-sm leading-relaxed text-purple-100 lg:text-base">
                    Whether you want to improve your English, connect with new people,
                    or become a mentor, there's a place for you at RSU Global!
                </p>

                <!-- Buttons -->
                <div class="flex flex-wrap justify-center gap-4">

                    <!-- Primary Button -->
                    <a href="{{ route('register.mentor') }}"
                        class="group inline-flex items-center gap-2 rounded-lg bg-white px-6 py-3 text-sm font-semibold text-[#7D3C98] shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-gray-50 hover:shadow-xl lg:px-8 lg:py-3.5">
                        Join Mentorship
                        <span class="transition-transform duration-300 group-hover:translate-x-1">
                            →
                        </span>
                    </a>

                    <!-- Secondary Button -->
                    <a href="{{ route('newsletter') }}"
                        class="inline-flex items-center gap-2 rounded-lg border border-white/50 bg-white/5 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:bg-white hover:text-[#7D3C98] lg:px-8 lg:py-3.5">
                        Newsletter
                    </a>

                </div>

        
        </div>
        <div class="flex flex-col justify-center py-24 gap-2 text-center bg-[#7D3C98]">
            <h1 class="mb-2 text-4xl font-bold tracking-wide text-white text-center">
                Ready to start your journey?
            </h1>
            <p
                class="break-word mx-auto mb-4 max-w-xl text-sm leading-relaxed text-white text-center"
            >
                Whether you want to improve your English or become a mentor, there's a place for your at RSUGlobal!.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a
                    href="{{ route('register.mentor') }}"
                    class="text-xs lg:text-sm rounded-md  bg-white px-2 py-2 lg:px-8 lg:py-3 font-medium text-[#7D3C98] shadow-md hover:opacity-90 transition-all "
                >
                    Join Mentorship
                </a>
                <a
                    href="{{ route('newsletter') }}"
                    class="text-xs lg:text-sm rounded-md border border-gray-100 px-2 py-2 lg:px-8 lg:py-3 font-medium text-white hover:bg-white/10 backdrop-blur-sm transition-all"
                >
                    Newsletter
                </a>
            </div>
        </div>

        <script>
            function toggleAccordion(id) {
                const element = document.getElementById(id);
                if (element.classList.contains('hidden')) {
                    element.classList.remove('hidden');
                } else {
                    element.classList.add('hidden');
                }
            }
        </script>

</x-layout>
