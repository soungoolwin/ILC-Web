<x-layout>
    <!-- Main content with video -->
    <div class="mx-auto w-screen">
        <div
            class="relative flex min-h-[500px] w-full items-center overflow-hidden bg-slate-900"
        >
            <div class="absolute inset-0 z-0">
                <img
                    src="{{ asset("images/banner.webp") }}"
                    alt="Background"
                    class="h-full w-full object-cover opacity-50"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-transparent"
                ></div>
            </div>

            <div class="container relative z-10 mx-auto px-36 text-white">
                <div class="max-w-2xl">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-gray-500 bg-gray-800/50 px-3 py-1 backdrop-blur-sm"
                    >
                        <span class="h-2 w-2 rounded-full bg-[#7D3C98]"></span>
                        <span
                            class="text-xs font-medium uppercase tracking-wider text-gray-300"
                        >
                            Peer-Assisted Learning Center
                        </span>
                    </div>

                    <h1
                        class="mb-6 text-5xl font-bold leading-tight md:text-7xl"
                    >
                        Empowering
                        <span class="text-[#7D3C98]">Global</span>
                        <br />
                        Communication
                    </h1>

                    <p
                        class="mb-8 max-w-lg text-lg leading-relaxed text-gray-300"
                    >
                        Connect with mentors, improve your English skills, and
                        become part of Rangsit University's vibrant
                        international community.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a
                            href="#join"
                            class="rounded-md bg-[#7D3C98] px-8 py-3 font-medium text-white shadow-lg shadow-purple-900/20 transition-all hover:bg-[#7D3C98]"
                        >
                            Join Mentorship
                        </a>
                        <a
                            href="#about"
                            class="rounded-md border border-gray-600 bg-gray-800/40 px-8 py-3 font-medium text-white backdrop-blur-sm transition-all hover:bg-gray-700/60"
                        >
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4 gap-2 px-24 py-24">
            <div
                class="flex flex-col items-center justify-center gap-2 border-r border-gray-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="#7d3c98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 1 1-7.5 0a3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                <h1 class="text-3xl font-bold text-[#7D3C98]">2000+</h1>
                <p class="text-xs text-gray-600">Active Students</p>
            </div>
            <div
                class="flex flex-col items-center justify-center gap-2 border-r border-gray-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="#7D3C98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372a9.337 9.337 0 0 0 4.121-.952a4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0a3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0a2.625 2.625 0 0 1 5.25 0Z"/></svg>
                <h1 class="text-3xl font-bold text-[#7D3C98]">100+</h1>
                <p class="text-xs text-gray-600">Mentors</p>
            </div>
            <div
                class="flex flex-col items-center justify-center gap-2 border-r border-gray-300"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="none" stroke="#7d3c98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                <h1 class="text-3xl font-bold text-[#7D3C98]">50+</h1>
                <p class="text-xs text-gray-600">Countries</p>
            </div>
            <div class="flex flex-col items-center justify-center gap-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-12 w-12 text-[#7D3C98]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                    />
                </svg>
                <h1 class="text-3xl font-bold text-[#7D3C98]">50+</h1>
                <p class="text-xs text-gray-600">Programs</p>
            </div>
        </div>

        <div class="flex flex-col justify-center gap-4 px-24 py-24 text-center bg-gray-50 rounded-lg">
            <div>
                <h1 class="mb-4 text-4xl font-bold tracking-wide text-gray-800">
                    Why join RSUGlobal! PAL?
                </h1>
                <p
                    class="break-word mx-auto mb-4 max-w-xl text-sm leading-relaxed text-gray-400"
                >
                    We believe in the power of peer-to-peer learning to break
                    down language barriers and foster cultural exchange.
                </p>
            </div>
            <div class="grid grid-cols-4 gap-4 justify-center px-24">
                <div class="flex flex-col items-left justify-center text-left gap-2 p-4 bg-white rounded-xl min-w-lg h-full max-h-64 border border-gray-200/20 shadow-md">
                    <svg class="bg-[#7d3c98]/20 rounded-lg p-1" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#7d3c98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                
                    <h2 class="text-lg font-semibold text-gray-800">
                        RSU Global! Newsletter
                    </h2>
                    <p class="text-xs text-gray-500 min-h-[60px]">
                        Get matched with experienced mentors who can help you
                        improve your English skills and navigate cultural
                        differences.
                    </p>
                    <a href="{{ route('newsletter') }}" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &nbsp;
                    </a>
                </div>
                <div class="flex flex-col items-left justify-center text-left gap-2 p-4 bg-white rounded-xl min-w-lg h-full max-h-64 border border-gray-200/20 shadow-md">
                    
                        <svg class="bg-[#7d3c98]/20 rounded-lg p-1" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#7D3C98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372a9.337 9.337 0 0 0 4.121-.952a4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0a3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0a2.625 2.625 0 0 1 5.25 0Z"/></svg>

                    <h2 class="text-lg font-semibold text-gray-800">
                        Mentor of the Month
                    </h2>
                    <p class="text-xs text-gray-500 min-h-[60px]">
                        Share you own knowledge and experiences to help others grow and succeed. 
                    </p>
                    <a href="#" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &nbsp;
                    </a>
                </div>
                <div class="flex flex-col items-left justify-center text-left gap-2 p-4 bg-white rounded-xl min-w-lg h-full max-h-64 border border-gray-200/20 shadow-md">
                        <svg class="bg-[#7d3c98]/20 rounded-lg p-1" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#7d3c98" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41a60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84a51.39 51.39 0 0 0-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
                    
                    <h2 class="text-lg font-semibold text-gray-800">
                        RSU/IRS 127
                    </h2>
                    <p class="text-xs text-gray-500 min-h-[60px]">
                        Improve your academic writing, presentation skills, and confidence for your future career.
                    </p>
                    <a href="#" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &nbsp;
                    </a>
                </div>
                <div class="flex flex-col items-left justify-center text-left gap-2 p-4 bg-white rounded-xl min-w-lg h-full max-h-64 border border-gray-200/20 shadow-md">
                    <svg class="bg-[#7d3c98]/20 rounded-lg p-1"xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#7d3c98" stroke-linecap="round" stroke-width="1.5" d="m15.75 10.5l4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                    <h2 class="text-lg font-semibold text-gray-800">
                        YouTube @RSUGlobal
                    </h2>
                    <p class="text-xs text-gray-500 min-h-[60px]">
                        Access a library of video resources covering language learning, cultural insights, and success stories from our community.
                    </p>
                    <a href="#" class="text-xs text-[#7D3C98] justify-self-end hover:underline">
                        Learn More &nbsp;
                    </a>
                </div>
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
                    href="#join"
                    class="rounded-md  bg-white px-8 py-3 font-medium text-[#7D3C98] shadow-lg shadow-purple-900/20 transition-all "
                >
                    Join Mentorship
                </a>
                <a
                    href="#about"
                    class="rounded-md border border-gray-100 px-8 py-3 font-medium text-white backdrop-blur-sm transition-all"
                >
                    Contact Us
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
