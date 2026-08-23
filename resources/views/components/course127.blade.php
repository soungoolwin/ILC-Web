<x-layout>
    @php
        $pdfUrl = asset('images/RSU 127 Course Syllabus.pdf');
        $pdfPath = public_path('images/RSU 127 Course Syllabus.pdf');
        if (!file_exists($pdfPath)) {
            $pdfPath = public_path('images/RSU_127_Course_Syllabus.pdf');
            $pdfUrl = asset('images/RSU_127_Course_Syllabus.pdf');
        }
    @endphp

    <!-- Top Hero Header Banner (Deep Solid Purple Background for High Contrast) -->
    <div style="background-color: #5B2C6F;" class="py-10 text-white shadow-lg border-b-4 border-[#7D3C98]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-xs font-bold text-purple-200 uppercase tracking-widest">
                        <a href="{{ route('guest') }}" class="hover:text-white hover:underline flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Home
                        </a>
                        <span class="text-purple-400">/</span>
                        <span class="text-purple-200">Courses</span>
                        <span class="text-purple-400">/</span>
                        <span class="text-white font-extrabold bg-purple-900/80 px-2 py-0.5 rounded">RSU/IRS 127</span>
                    </div>
                    <h1 class="text-3xl font-black tracking-tight text-white sm:text-4xl lg:text-5xl">
                        RSU/IRS 127: Intercultural Communication
                    </h1>
                    <p class="text-sm sm:text-base text-purple-100 font-medium max-w-3xl">
                        Official Course Syllabus & Learning Guide &bull; Rangsit University PAL Center
                    </p>
                </div>
                
                <!-- Top Right Badges & High-Visibility Gold Download Button -->
                <div class="flex flex-wrap items-center gap-3">
                    <span style="background-color: #4A235A;" class="inline-flex items-center rounded-lg px-3.5 py-2 text-xs font-black text-purple-100 border border-purple-400/40 shadow-xs">
                        <svg class="mr-1.5 h-4 w-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Term 2, 2026
                    </span>
                    <span style="background-color: #145A32;" class="inline-flex items-center rounded-lg px-3.5 py-2 text-xs font-black text-emerald-100 border border-emerald-400/40 shadow-xs">
                        <svg class="mr-1.5 h-4 w-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        3 Credits
                    </span>
                    <!-- High Visibility Amber/Gold Button for Top Right Download -->
                    <a 
                        href="{{ $pdfUrl }}" 
                        download 
                        style="background-color: #D68910;" 
                        class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-xs font-black text-white shadow-lg hover:bg-amber-600 hover:scale-105 transition-all duration-200 border border-amber-300"
                    >
                        <svg class="mr-2 h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container: 2 Column Layout with Spaced Out Sections -->
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 bg-slate-100/70 min-h-screen">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
            
            <!-- LEFT COLUMN: Syllabus Content (8 Columns on desktop) -->
            <div class="lg:col-span-8 space-y-12">
                
                <!-- Quick Info Cards Bar -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-2xl border border-purple-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center gap-3.5">
                            <div style="background-color: #F4ECF7;" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-[#5B2C6F]">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-purple-900 uppercase tracking-wider">Course Manager</p>
                                <p class="text-sm font-extrabold text-slate-900">Dr. Edward Devere Bacon</p>
                                <p class="text-xs text-[#5B2C6F] font-bold">Director, RSU Global!</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-purple-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
                        <div class="flex items-center gap-3.5">
                            <div style="background-color: #F4ECF7;" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-[#5B2C6F]">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-purple-900 uppercase tracking-wider">Lecturers</p>
                                <p class="text-sm font-extrabold text-slate-900">Aj. Maksim, Aj. Krita</p>
                                <p class="text-xs text-slate-600 font-semibold">RIC Faculty</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-purple-200 bg-white p-5 shadow-sm hover:shadow-md transition-all sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-3.5">
                            <div style="background-color: #F4ECF7;" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-[#5B2C6F]">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-purple-900 uppercase tracking-wider">Office Location</p>
                                <p class="text-sm font-extrabold text-slate-900">RIC Main Office</p>
                                <p class="text-xs text-slate-600 font-semibold">Bldg 11, 2nd Fl (Ext. 4012)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Description Section -->
                <section id="description" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div style="background-color: #5B2C6F;" class="px-6 py-4 flex items-center justify-between text-white">
                        <h2 class="flex items-center text-lg font-extrabold tracking-wide text-white">
                            <svg class="mr-2.5 h-6 w-6 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Course Description
                        </h2>
                        <span style="background-color: #7D3C98;" class="rounded-full px-3.5 py-1 text-xs font-bold text-white border border-purple-300/30">Overview</span>
                    </div>
                    <div class="p-6 md:p-8 text-slate-800 leading-relaxed text-sm md:text-base font-medium">
                        <p class="first-letter:float-left first-letter:mr-3 first-letter:text-5xl first-letter:font-black first-letter:text-[#5B2C6F]">
                            Intercultural communication; definition of intercultural communication, types of culture, factors of intercultural communication; the culture shock, cultural dimension, nonverbal communication, gestures, eye contact, facial expressions, personal distance, haptics, paralanguage, types of communication, contexts, values, and understanding international languages that reflect the cultural values of each race.
                        </p>
                    </div>
                </section>

                <!-- Eligibility & Pedagogical Methods Grid (Spaced Out with gap-8 md:gap-10) -->
                <div class="grid grid-cols-1 gap-8 md:gap-10 md:grid-cols-2">
                    <!-- Course Eligibility -->
                    <section id="eligibility" class="rounded-2xl border-2 border-amber-300 bg-amber-50/70 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 border-b border-amber-200 pb-3">
                                <div style="background-color: #D68910;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-amber-950">Course Eligibility</h3>
                                    <p class="text-xs font-bold text-amber-800">Prerequisites & Enrollment Requirement</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-xl bg-white p-4 border border-amber-200 shadow-xs">
                                <p class="text-xs md:text-sm leading-relaxed font-bold text-amber-950">
                                    All students need a minimum <span style="background-color: #FEF9E7; color: #B7950B;" class="font-black px-2 py-0.5 rounded border border-amber-300">5.5 IELTS band score</span> (or equivalent) in order to enroll in RSU/IRS 127.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Pedagogical Methods -->
                    <section id="pedagogy" class="rounded-2xl border-2 border-purple-200 bg-purple-50/70 p-6 shadow-sm">
                        <div class="flex items-center gap-3 border-b border-purple-200 pb-3">
                            <div style="background-color: #5B2C6F;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-purple-950">Pedagogical Methods</h3>
                                <p class="text-xs font-bold text-purple-800">Teaching Methodology</p>
                            </div>
                        </div>
                        <ul class="mt-4 space-y-2.5 text-xs md:text-sm text-purple-950 font-bold">
                            <li class="flex items-start gap-2">
                                <span class="text-[#5B2C6F] font-black">&bull;</span>
                                Student-centered blended learning with a flipped classroom approach
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5B2C6F] font-black">&bull;</span>
                                Group presentations & group discussions
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5B2C6F] font-black">&bull;</span>
                                Formative Assessment through Homework Assignments
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-[#5B2C6F] font-black">&bull;</span>
                                Use of AI for development of critical thinking skills
                            </li>
                        </ul>
                    </section>
                </div>

                <!-- Course Objectives Card -->
                <section id="objectives" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div style="background-color: #2874A6;" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Course Objectives</h2>
                            <p class="text-xs font-bold text-slate-500">Key Learning Outcomes for Students</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-start gap-4 rounded-xl border border-purple-100 bg-purple-50/40 p-4.5 transition-all hover:bg-white hover:shadow-md">
                            <span style="background-color: #5B2C6F;" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-extrabold text-white">1</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">
                                Apply intercultural communication theories in real peer-mentoring contexts at RSU Global!
                            </p>
                        </div>
                        <div class="flex items-start gap-4 rounded-xl border border-purple-100 bg-purple-50/40 p-4.5 transition-all hover:bg-white hover:shadow-md">
                            <span style="background-color: #5B2C6F;" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-extrabold text-white">2</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">
                                Demonstrate intercultural competence through guided peer mentoring at RSU Global!
                            </p>
                        </div>
                        <div class="flex items-start gap-4 rounded-xl border border-purple-100 bg-purple-50/40 p-4.5 transition-all hover:bg-white hover:shadow-md">
                            <span style="background-color: #5B2C6F;" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-extrabold text-white">3</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-800 leading-relaxed">
                                Critically reflect on intercultural experiences at RSU Global! to enhance personal and professional communication skills
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Course Requirements & Assessment Grid (Spaced Out with gap-8 md:gap-10) -->
                <div class="grid grid-cols-1 gap-8 md:gap-10 lg:grid-cols-2">
                    
                    <!-- Assessment Breakdown -->
                    <section id="assessment" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-between space-y-6">
                        <div>
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3">
                                    <div style="background-color: #1F618D;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-black text-slate-900">Class Assessment</h2>
                                        <p class="text-xs font-bold text-slate-500">Weight Distribution (100%)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div>
                                    <div class="flex justify-between text-xs font-bold text-slate-800">
                                        <span>Final Exam</span>
                                        <span class="text-[#5B2C6F] font-black">40%</span>
                                    </div>
                                    <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="h-full rounded-full" style="width: 40%; background-color: #5B2C6F;"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold text-slate-800">
                                        <span>10 Writing Homework Assignments</span>
                                        <span class="text-[#7D3C98] font-black">30%</span>
                                    </div>
                                    <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="h-full rounded-full" style="width: 30%; background-color: #7D3C98;"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold text-slate-800">
                                        <span>RSU Global! Participation</span>
                                        <span class="text-indigo-700 font-black">15%</span>
                                    </div>
                                    <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="h-full rounded-full bg-indigo-600" style="width: 15%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold text-slate-800">
                                        <span>Attendance</span>
                                        <span class="text-blue-700 font-black">10%</span>
                                    </div>
                                    <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="h-full rounded-full bg-blue-600" style="width: 10%"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold text-slate-800">
                                        <span>RSU Global! Passport</span>
                                        <span class="text-emerald-700 font-black">5%</span>
                                    </div>
                                    <div class="mt-1.5 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="h-full rounded-full bg-emerald-600" style="width: 5%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: #F4ECF7;" class="flex items-center justify-between rounded-xl p-3.5 border border-purple-200">
                            <span class="text-xs font-black text-[#5B2C6F]">Total Score Weight</span>
                            <span style="background-color: #5B2C6F;" class="rounded-lg px-3 py-1 text-xs font-black text-white">100%</span>
                        </div>
                    </section>

                    <!-- Grading Criteria Table -->
                    <section id="grading" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div style="background-color: #1E8449;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-slate-900">Grading Criteria</h2>
                                <p class="text-xs font-bold text-slate-500">Letter Grade Scale</p>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-slate-200 text-xs">
                            <table class="w-full text-left">
                                <thead class="bg-slate-100 text-slate-800 uppercase font-extrabold">
                                    <tr>
                                        <th class="px-4 py-2.5">Score Range</th>
                                        <th class="px-4 py-2.5 text-center">Grade</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-bold text-slate-800">
                                    <tr class="bg-emerald-50"><td class="px-4 py-2 text-slate-900">90 &ndash; 100</td><td class="px-4 py-2 text-center font-black text-emerald-800">A</td></tr>
                                    <tr><td class="px-4 py-2 text-slate-900">80 &ndash; 89</td><td class="px-4 py-2 text-center font-black text-emerald-700">B+</td></tr>
                                    <tr class="bg-slate-50"><td class="px-4 py-2 text-slate-900">70 &ndash; 79</td><td class="px-4 py-2 text-center font-black text-blue-700">B</td></tr>
                                    <tr><td class="px-4 py-2 text-slate-900">65 &ndash; 69</td><td class="px-4 py-2 text-center font-black text-blue-600">C+</td></tr>
                                    <tr class="bg-slate-50"><td class="px-4 py-2 text-slate-900">60 &ndash; 64</td><td class="px-4 py-2 text-center font-black text-amber-700">C</td></tr>
                                    <tr><td class="px-4 py-2 text-slate-900">55 &ndash; 59</td><td class="px-4 py-2 text-center font-black text-amber-700">D+</td></tr>
                                    <tr class="bg-slate-50"><td class="px-4 py-2 text-slate-900">50 &ndash; 54</td><td class="px-4 py-2 text-center font-black text-orange-700">D</td></tr>
                                    <tr class="bg-rose-100/70"><td class="px-4 py-2 text-rose-950 font-black">49 or below</td><td class="px-4 py-2 text-center font-black text-rose-800">F</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>

                <!-- Course Requirements & Rules Sections (Spaced Out with gap-8 md:gap-10) -->
                <div class="grid grid-cols-1 gap-8 md:gap-10 md:grid-cols-2">
                    <!-- Requirements -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                            <svg class="h-5 w-5 text-[#5B2C6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Course Requirements
                        </h3>
                        <ul class="mt-4 space-y-2.5 text-xs md:text-sm text-slate-800 leading-relaxed font-bold">
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-black">&check;</span>
                                Complete on time: English pretest & posttest, 10 writing assignments, and final presentation.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-black">&check;</span>
                                Participation in RSU Global! Passport (Week 3).
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-black">&check;</span>
                                Participation in RSU Global! as a peer-mentor for the 10-week PAL program.
                            </li>
                        </ul>
                    </div>

                    <!-- Rules & Regulations -->
                    <div class="rounded-2xl border-2 border-rose-300 bg-rose-50/70 p-6 shadow-sm">
                        <h3 class="text-base font-black text-rose-950 flex items-center gap-2 border-b border-rose-200 pb-3">
                            <svg class="h-5 w-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Rules & Regulations
                        </h3>
                        <ul class="mt-4 space-y-2.5 text-xs md:text-sm text-rose-950 leading-relaxed font-bold">
                            <li class="flex items-start gap-2">
                                <span class="text-rose-700 font-black">&bull;</span>
                                10 online assignments <strong class="underline decoration-rose-400">CANNOT be accepted AFTER due date</strong>.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-rose-700 font-black">&bull;</span>
                                Be punctual. Attendance is taken based on group presentations & peer feedback. Late or non-participating attendance is NOT recorded.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-rose-700 font-black">&bull;</span>
                                Conduct professionally. Academic dishonesty/cheating is strictly prohibited.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 15-Week Timeline Schedule Section -->
                <section id="schedule" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 gap-2">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                                <svg class="h-6 w-6 text-[#5B2C6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Course Schedule & Weekly Topics
                            </h2>
                            <p class="text-xs font-bold text-slate-500 mt-0.5">15 Weeks Interactive Curriculum Plan</p>
                        </div>
                        <span style="background-color: #F4ECF7; color: #5B2C6F;" class="inline-flex items-center rounded-lg px-3.5 py-1.5 text-xs font-black border border-purple-200">
                            15 Weeks Total
                        </span>
                    </div>

                    <div class="space-y-6">
                        
                        <!-- Week 1 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 1 &bull; Jan 15</span>
                                    <span class="text-xs font-extrabold text-slate-600">Orientation</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Introduction to Intercultural Communication</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Course orientation, expectations, and assessments. Definition and scope of intercultural communication. Importance in globalized education and work. Icebreaker with RSU Global! peer mentors.
                                </p>
                            </div>
                        </div>

                        <!-- Week 2 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 2 &bull; Jan 22</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Understanding Culture</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Types of culture: national, social, organizational, individual. Surface vs. deep culture (iceberg model). Cultural universals vs. cultural specifics. Activity: &ldquo;Culture as an Iceberg&rdquo;. Mentor sharing: hidden aspects of their home cultures.
                                </p>
                            </div>
                        </div>

                        <!-- Week 3 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 3 &bull; Jan 29</span>
                                    <span class="rounded-full bg-emerald-700 px-2.5 py-0.5 text-xs font-black text-white">Passport Week (5%)</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Cultural Dimensions I</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Hofstede&rsquo;s six cultural dimensions. Case study: Thailand compared with other countries. Activity: &ldquo;Which dimensions shape your communication style?&rdquo;. Preparation for RSU Global! volunteering (roles, expectations, online reflection journals).
                                </p>
                            </div>
                        </div>

                        <!-- Week 4 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 4 &bull; Feb 5</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #1</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Cultural Dimensions II & Contextual Communication</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    (First RSU Global! volunteering week) Hall&rsquo;s high- vs. low-context communication. Trompenaars&rsquo; cultural dilemmas. Role-play: miscommunication scenarios. PAL Task: Observe whether your mentee communicates directly or indirectly.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #1
                                </div>
                            </div>
                        </div>

                        <!-- Week 5 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 5 &bull; Feb 12</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #2</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Culture Shock & Adaptation</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Stages of culture shock and adaptation strategies. Case study: international student adjusting to Thailand. PAL Task: Ask your mentor about their own adaptation experience in Thailand.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #2
                                </div>
                            </div>
                        </div>

                        <!-- Week 6 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 6 &bull; Feb 19</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #3</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Nonverbal Communication I</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Gestures, posture, facial expressions. Universal vs. culture-specific nonverbals. Video analysis of intercultural gestures. PAL Task: Identify a gesture or expression that could be misinterpreted in Thailand.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #3
                                </div>
                            </div>
                        </div>

                        <!-- Week 7 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 7 &bull; Feb 26</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #4</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Nonverbal Communication II</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Eye contact, proxemics, haptics, paralanguage. Cross-cultural role-play on personal space and tone. Mentor demonstration: greeting rituals from their countries. PAL Task: Observe mentor&rsquo;s use of distance or tone.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #4
                                </div>
                            </div>
                        </div>

                        <!-- Week 8 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 8 &bull; Mar 12</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #5</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Verbal Communication & World Englishes</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    English as a Lingua Franca (ELF). Global Englishes and identity in communication. Case analysis: misunderstandings in ELF. PAL Task: Record examples of how your mentor&rsquo;s English reflects cultural identity.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #5
                                </div>
                            </div>
                        </div>

                        <!-- Week 9 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 9 &bull; Mar 19</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #6</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Values, Beliefs, and Worldviews</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Kluckhohn & Strodtbeck&rsquo;s Value Orientations. Values shaping communication (time, authority, relationships). Mentor activity: cultural values showcase. PAL Task: Compare observed values with Thai values.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #6
                                </div>
                            </div>
                        </div>

                        <!-- Week 10 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 10 &bull; Mar 26</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #7</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Intercultural Barriers and Stereotypes</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Stereotypes, prejudice, and ethnocentrism. Attribution theory and intercultural misinterpretation. Media analysis: stereotypes in films/ads. PAL Task: Reflect on one stereotype you held that changed through mentoring.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #7
                                </div>
                            </div>
                        </div>

                        <!-- Week 11 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 11 &bull; Apr 2</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #8</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Identity and Intercultural Communication</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Cultural identity, social identity, hybrid identities. Identity negotiation theory. Identity mapping activity. PAL Task: Ask mentors how they balance identity in Thailand.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #8
                                </div>
                            </div>
                        </div>

                        <!-- Week 12 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 12 &bull; Apr 9</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #9</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Intercultural Competence</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Byram&rsquo;s Intercultural Competence Model. Deardorff&rsquo;s Process Model. Group activity: building an &ldquo;Intercultural Toolkit&rdquo;. PAL Task: Self-assess: which intercultural skill did I show in mentoring?
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #9
                                </div>
                            </div>
                        </div>

                        <!-- Week 13 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #5B2C6F;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 13 &bull; Apr 16</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Reflection Homework #10</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Intercultural Communication in Practice & Internationalization at Home (IaH)</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Applications in business, education, and healthcare. Introduction to IaH definition & strategies. RSU Case Study. Group activity & PAL Task. Prep session for final presentations.
                                </p>
                                <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                    &bull; ONLINE RSU GLOBAL! REFLECTION HOMEWORK #10
                                </div>
                            </div>
                        </div>

                        <!-- Week 14 -->
                        <div class="relative pl-6 border-l-4 border-purple-400 pb-2">
                            <div style="background-color: #2563EB;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-blue-200 bg-blue-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="rounded-md bg-blue-700 px-3 py-1 text-xs font-black text-white">Week 14 &bull; Apr 23</span>
                                    <span class="rounded-full bg-blue-700 px-2.5 py-0.5 text-xs font-black text-white">Final Presentations (Group 1)</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Final Presentations (Group 1)</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Student projects: &ldquo;Best Practices in Intercultural Communication at RSU Global!&rdquo;. Presentations link classroom theory with PAL volunteering experiences. Peer feedback and Q&A.
                                </p>
                            </div>
                        </div>

                        <!-- Week 15 -->
                        <div class="relative pl-6 border-l-4 border-purple-400">
                            <div style="background-color: #2563EB;" class="absolute -left-3 top-0.5 h-5 w-5 rounded-full border-4 border-white shadow-xs"></div>
                            <div class="rounded-xl border-2 border-blue-200 bg-blue-50/40 p-5 hover:bg-white hover:shadow-md transition-all space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="rounded-md bg-blue-700 px-3 py-1 text-xs font-black text-white">Week 15 &bull; Apr 30</span>
                                    <span class="rounded-full bg-blue-700 px-2.5 py-0.5 text-xs font-black text-white">Final Presentations (Group 2)</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900">Final Presentations (Group 2) & Closing Reflection</h3>
                                <p class="text-xs md:text-sm text-slate-700 leading-relaxed font-medium">
                                    Remaining presentations. Closing reflection: &ldquo;What did I learn about myself as an intercultural communicator?&rdquo; &ldquo;How can RSU Global! continue strengthening IaH at Rangsit?&rdquo;
                                </p>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- References & Course Manager Footer Card -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">References & Resources</h3>
                        <p class="text-xs text-slate-700 font-bold mt-1">RSU/IRS 127 Moodle &bull; Digital chapters from course textbook &bull; Digital Handouts</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-[#5B2C6F]">Dr. Edward Devere Bacon</p>
                        <p class="text-xs font-bold text-slate-600">Director, RSU Global!</p>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Sticky Sidebar (4 Columns on desktop) -->
            <!-- Clean layout: Quick Navigation Card -> PDF Download Card (No embedded preview) -->
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-8">
                    
                    <!-- Quick Navigation Links -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2.5">
                            Quick Navigation
                        </h4>
                        <nav class="space-y-2 text-xs font-bold">
                            <a href="#description" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] transition-all border border-slate-100 hover:border-purple-200">
                                <span>Course Description</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#eligibility" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] transition-all border border-slate-100 hover:border-purple-200">
                                <span>Eligibility & Pedagogy</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#objectives" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] transition-all border border-slate-100 hover:border-purple-200">
                                <span>Course Objectives</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#assessment" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] transition-all border border-slate-100 hover:border-purple-200">
                                <span>Assessment & Grading</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#schedule" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] transition-all border border-slate-100 hover:border-purple-200">
                                <span>15-Week Schedule</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </nav>
                    </div>

                    <!-- PDF Download Widget Card -->
                    <div class="overflow-hidden rounded-2xl border-2 border-[#5B2C6F] bg-white shadow-xl">
                        <div style="background-color: #5B2C6F;" class="p-6 text-white space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-white/20 px-3 py-0.5 text-[11px] font-extrabold uppercase tracking-wider text-white">Official Syllabus</span>
                                <span class="text-xs font-bold text-purple-100">PDF &bull; 3 Pages &bull; ~314 KB</span>
                            </div>
                            <h3 class="text-xl font-black text-white leading-snug pt-1">
                                Course Syllabus PDF
                            </h3>
                            <p class="text-xs text-purple-100 font-medium">
                                RSU/IRS 127: Intercultural Communication
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-5 bg-purple-50/40">
                            <a 
                                href="{{ $pdfUrl }}" 
                                download 
                                style="background-color: #D68910;"
                                class="flex w-full items-center justify-center gap-2.5 rounded-xl px-5 py-4 text-sm font-black text-white shadow-lg hover:bg-amber-600 hover:shadow-xl hover:scale-[1.02] transition-all duration-200 group border border-amber-300"
                            >
                                <svg class="h-6 w-6 text-white transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Syllabus (PDF)
                            </a>

                            <div class="flex items-center justify-between text-xs font-bold text-slate-700 pt-3 border-t border-purple-200">
                                <span>File: PDF Document</span>
                                <a href="{{ $pdfUrl }}" target="_blank" class="text-[#5B2C6F] font-black hover:underline flex items-center gap-1">
                                    Open PDF in New Tab
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layout>
