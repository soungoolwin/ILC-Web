<x-layout>
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
                
                <!-- Top Right Badges & Functional Amber Download Button -->
                <div class="flex flex-col gap-2.5 w-full sm:w-auto">
                    <div class="grid grid-cols-2 gap-2.5">
                        <span style="background-color: #4A235A;" class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-xs font-black text-purple-100 border border-purple-400/40 shadow-xs gap-2 hover:scale-105 hover:brightness-110 hover:shadow-md transition-all duration-200 cursor-default">
                            <svg class="h-4 w-4 text-purple-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="whitespace-nowrap">Term 1, 2026</span>
                        </span>
                        <span style="background-color: #145A32;" class="inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-xs font-black text-emerald-100 border border-emerald-400/40 shadow-xs gap-2 hover:scale-105 hover:brightness-110 hover:shadow-md transition-all duration-200 cursor-default">
                            <svg class="h-4 w-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="whitespace-nowrap">3 Credits</span>
                        </span>
                    </div>
                    <!-- Functional Automatic PDF Download Button via Backend Controller Route -->
                    <a 
                        href="{{ route('course127.download') }}" 
                        download="RSU 127 Course Syllabus.pdf" 
                        style="background-color: #D68910;" 
                        class="w-full inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-xs font-black text-white shadow-lg hover:bg-amber-600 hover:scale-[1.02] hover:shadow-xl transition-all duration-200 border border-amber-300"
                    >
                        <svg class="mr-2 h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Download PDF</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container: 2 Column Layout with Spaced Out Sections -->
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 bg-slate-100/70 min-h-screen">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:gap-12">
            
            <!-- LEFT COLUMN: Syllabus Content (8 Columns on desktop) -->
            <div class="lg:col-span-8 space-y-12">
                
                <!-- 1. Top Metadata Cards Bar -->
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 mb-10">
                    <div class="rounded-2xl border border-purple-200 bg-white p-6 shadow-sm hover:shadow-md hover:-translate-y-1 hover:border-purple-300 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-4">
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

                    <div class="rounded-2xl border border-purple-200 bg-white p-6 shadow-sm hover:shadow-md hover:-translate-y-1 hover:border-purple-300 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div style="background-color: #F4ECF7;" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-[#5B2C6F]">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-purple-900 uppercase tracking-wider">Lecturers</p>
                                <p class="text-sm font-extrabold text-slate-900">Aj. Gary Ambito Torremucha</p>
                                <p class="text-xs text-slate-600 font-semibold">RIC Faculty</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-purple-200 bg-white p-6 shadow-sm hover:shadow-md hover:-translate-y-1 hover:border-purple-300 transition-all duration-200 sm:col-span-2 lg:col-span-1 cursor-pointer">
                        <div class="flex items-center gap-4">
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

                <!-- 2. Course Description Section Card -->
                <section id="description" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm mb-10 transition-all duration-200 hover:shadow-md">
                    <div style="background-color: #5B2C6F;" class="px-6 py-4 flex items-center justify-between text-white">
                        <h2 class="flex items-center gap-4 text-lg font-extrabold tracking-wide text-white">
                            <svg class="h-6 w-6 shrink-0 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>Course Description</span>
                        </h2>
                        <span style="background-color: #7D3C98;" class="inline-flex items-center justify-center rounded-full px-5 py-1.5 min-w-[95px] text-xs font-black text-white text-center border border-purple-300/40 shadow-xs hover:scale-105 hover:brightness-110 hover:shadow-md transition-all duration-200 cursor-default">Overview</span>
                    </div>
                    <div class="p-6 md:p-8 text-slate-800 leading-relaxed text-sm md:text-base font-medium">
                        <p class="first-letter:float-left first-letter:mr-3 first-letter:text-5xl first-letter:font-black first-letter:text-[#5B2C6F]">
                            Intercultural communication; definition of intercultural communication, types of culture, factors of intercultural communication; the culture shock, cultural dimension, nonverbal communication, gestures, eye contact, facial expressions, personal distance, haptics, paralanguage, types of communication, contexts, values, and understanding international languages that reflect the cultural values of each race.
                        </p>
                    </div>
                </section>

                <!-- 3. Eligibility & Pedagogical Methods Grid (Matching Neutral Slate Outer Styling for Both Cards) -->
                <div class="grid grid-cols-1 gap-8 lg:gap-10 md:grid-cols-2 mb-10">
                    <!-- Course Eligibility (Neutral Slate Border) -->
                    <section id="eligibility" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                                <div style="background-color: #D68910;" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-slate-900">Course Eligibility</h3>
                                    <p class="text-xs font-bold text-slate-500">Prerequisites & Enrollment Requirement</p>
                                </div>
                            </div>
                            <div class="mt-5 rounded-xl bg-amber-50/70 p-5 border border-amber-200/80 shadow-xs">
                                <p class="text-xs md:text-sm leading-relaxed font-bold text-amber-950">
                                    All students need a minimum <span style="background-color: #FEF9E7; color: #B7950B;" class="font-black px-2 py-0.5 rounded border border-amber-300">5.5 IELTS band score</span> (or equivalent) in order to enroll in RSU/IRS 127.
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Pedagogical Methods (Matching Neutral Slate Border) -->
                    <section id="pedagogy" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
                        <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                            <div style="background-color: #5B2C6F;" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Pedagogical Methods</h3>
                                <p class="text-xs font-bold text-slate-500">Teaching Methodology</p>
                            </div>
                        </div>
                        <ul class="mt-5 space-y-3.5 text-xs md:text-sm text-slate-800 font-medium">
                            <li class="flex items-start gap-3">
                                <span class="text-[#5B2C6F] font-bold shrink-0">&bull;</span>
                                <span>Student-centered blended learning with a flipped classroom approach</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-[#5B2C6F] font-bold shrink-0">&bull;</span>
                                <span>Group presentations & group discussions</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-[#5B2C6F] font-bold shrink-0">&bull;</span>
                                <span>Formative Assessment through Homework Assignments</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-[#5B2C6F] font-bold shrink-0">&bull;</span>
                                <span>Use of AI for development of critical thinking skills</span>
                            </li>
                        </ul>
                    </section>
                </div>

                <!-- 4. Course Objectives Section Card -->
                <section id="objectives" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm space-y-5 mb-10 transition-all duration-200 hover:shadow-md">
                    <style>
                        .objective-item-card {
                            cursor: pointer;
                            transition: all 0.25s ease-in-out;
                        }
                        .objective-item-card:hover {
                            transform: translateX(6px) translateY(-2px);
                            border-color: #8b5cf6;
                            background-color: #faf5ff;
                            box-shadow: 0 8px 18px rgba(139, 92, 246, 0.12);
                        }
                        .objective-item-card:hover .obj-number {
                            color: #7c3aed;
                            transform: scale(1.1);
                        }
                        .obj-number {
                            transition: all 0.2s ease-in-out;
                        }
                    </style>

                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div style="background-color: #2874A6;" class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Course Objectives</h2>
                            <p class="text-xs font-bold text-slate-500">Key Learning Outcomes for Students</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div class="objective-item-card flex items-center gap-4 rounded-xl border border-purple-100 bg-purple-50/40 px-4 py-3">
                            <span class="obj-number text-base font-black text-[#5B2C6F] shrink-0">1.</span>
                            <p class="text-sm font-medium text-slate-800 leading-normal">
                                Apply intercultural communication theories in real peer-mentoring contexts at RSU Global!
                            </p>
                        </div>
                        <div class="objective-item-card flex items-center gap-4 rounded-xl border border-purple-100 bg-purple-50/40 px-4 py-3">
                            <span class="obj-number text-base font-black text-[#5B2C6F] shrink-0">2.</span>
                            <p class="text-sm font-medium text-slate-800 leading-normal">
                                Demonstrate intercultural competence through guided peer mentoring at RSU Global!
                            </p>
                        </div>
                        <div class="objective-item-card flex items-center gap-4 rounded-xl border border-purple-100 bg-purple-50/40 px-4 py-3">
                            <span class="obj-number text-base font-black text-[#5B2C6F] shrink-0">3.</span>
                            <p class="text-sm font-medium text-slate-800 leading-normal">
                                Critically reflect on intercultural experiences at RSU Global! to enhance personal and professional communication skills
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 5. Course Requirements & Assessment Grid -->
                <style>
                    @keyframes fillBoost40 {
                        0% { width: 0%; filter: brightness(1.2); }
                        80% { width: 43%; filter: brightness(1.25); }
                        100% { width: 40%; filter: brightness(1.2); }
                    }
                    @keyframes fillBoost30 {
                        0% { width: 0%; filter: brightness(1.2); }
                        80% { width: 33%; filter: brightness(1.25); }
                        100% { width: 30%; filter: brightness(1.2); }
                    }
                    @keyframes fillBoost15 {
                        0% { width: 0%; filter: brightness(1.2); }
                        80% { width: 17%; filter: brightness(1.25); }
                        100% { width: 15%; filter: brightness(1.2); }
                    }
                    @keyframes fillBoost10 {
                        0% { width: 0%; filter: brightness(1.2); }
                        80% { width: 12%; filter: brightness(1.25); }
                        100% { width: 10%; filter: brightness(1.2); }
                    }
                    @keyframes fillBoost5 {
                        0% { width: 0%; filter: brightness(1.2); }
                        80% { width: 7%; filter: brightness(1.25); }
                        100% { width: 5%; filter: brightness(1.2); }
                    }
                    .assessment-row {
                        cursor: pointer;
                        transition: all 0.2s ease;
                    }
                    .assessment-row:hover .bar-40 {
                        animation: fillBoost40 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                        box-shadow: 0 0 12px rgba(91, 44, 111, 0.5);
                    }
                    .assessment-row:hover .bar-30 {
                        animation: fillBoost30 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                        box-shadow: 0 0 12px rgba(125, 60, 152, 0.5);
                    }
                    .assessment-row:hover .bar-15 {
                        animation: fillBoost15 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                        box-shadow: 0 0 12px rgba(79, 70, 229, 0.5);
                    }
                    .assessment-row:hover .bar-10 {
                        animation: fillBoost10 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                        box-shadow: 0 0 12px rgba(37, 99, 235, 0.5);
                    }
                    .assessment-row:hover .bar-5 {
                        animation: fillBoost5 0.55s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                        box-shadow: 0 0 12px rgba(5, 150, 105, 0.5);
                    }
                </style>

                <div class="grid grid-cols-1 gap-8 lg:gap-10 lg:grid-cols-2 mb-10">
                    
                    <!-- Assessment Breakdown -->
                    <section id="assessment" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm flex flex-col justify-between space-y-6">
                        <div>
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-4">
                                    <div style="background-color: #1F618D;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-black text-slate-900">Class Assessment</h2>
                                        <p class="text-xs font-bold text-slate-500">Weight Distribution (100%)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-2">
                                <div class="assessment-row group rounded-xl p-2.5 -mx-2.5 hover:bg-slate-50">
                                    <div class="flex justify-between text-xs font-bold text-slate-900">
                                        <span>Final Exam</span>
                                        <span class="text-[#5B2C6F] font-black">40%</span>
                                    </div>
                                    <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="bar-40 h-full rounded-full transition-all duration-300 ease-out" style="width: 40%; background-color: #5B2C6F;"></div>
                                    </div>
                                </div>

                                <div class="assessment-row group rounded-xl p-2.5 -mx-2.5 hover:bg-slate-50">
                                    <div class="flex justify-between text-xs font-bold text-slate-900">
                                        <span>10 Writing Homework Assignments</span>
                                        <span class="text-[#7D3C98] font-black">30%</span>
                                    </div>
                                    <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="bar-30 h-full rounded-full transition-all duration-300 ease-out" style="width: 30%; background-color: #7D3C98;"></div>
                                    </div>
                                </div>

                                <div class="assessment-row group rounded-xl p-2.5 -mx-2.5 hover:bg-slate-50">
                                    <div class="flex justify-between text-xs font-bold text-slate-900">
                                        <span>PAL Participation</span>
                                        <span class="text-indigo-700 font-black">15%</span>
                                    </div>
                                    <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="bar-15 h-full rounded-full transition-all duration-300 ease-out" style="width: 15%; background-color: #4F46E5;"></div>
                                    </div>
                                </div>

                                <div class="assessment-row group rounded-xl p-2.5 -mx-2.5 hover:bg-slate-50">
                                    <div class="flex justify-between text-xs font-bold text-slate-900">
                                        <span>Attendance</span>
                                        <span class="text-blue-700 font-black">10%</span>
                                    </div>
                                    <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="bar-10 h-full rounded-full transition-all duration-300 ease-out" style="width: 10%; background-color: #2563EB;"></div>
                                    </div>
                                </div>

                                <div class="assessment-row group rounded-xl p-2.5 -mx-2.5 hover:bg-slate-50">
                                    <div class="flex justify-between text-xs font-bold text-slate-900">
                                        <span>RSU Passport</span>
                                        <span class="text-emerald-700 font-black">5%</span>
                                    </div>
                                    <div class="mt-2 h-2.5 w-full overflow-hidden rounded-full bg-slate-100 border border-slate-200">
                                        <div class="bar-5 h-full rounded-full transition-all duration-300 ease-out" style="width: 5%; background-color: #059669;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="background-color: #F4ECF7;" class="flex items-center justify-between rounded-xl p-4 border border-purple-200 mt-6">
                            <span class="text-xs font-black text-[#5B2C6F]">Total Score Weight</span>
                            <span style="background-color: #5B2C6F;" class="inline-flex items-center justify-center rounded-xl px-5 py-2 min-w-[70px] text-xs font-black text-white text-center shadow-xs">100%</span>
                        </div>
                    </section>

                    <!-- Grading Criteria Table -->
                    <section id="grading" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm flex flex-col justify-between space-y-6">
                        <div>
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-4">
                                    <div style="background-color: #1E8449;" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-white shadow-xs">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"></path></svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-black text-slate-900">Grading Criteria</h2>
                                        <p class="text-xs font-bold text-slate-500">Letter Grade Scale</p>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-hidden rounded-xl border border-slate-200 text-xs mt-6">
                                <table class="w-full text-left">
                                    <thead class="bg-slate-100 text-slate-800 uppercase font-extrabold">
                                        <tr>
                                            <th class="px-4 py-2.5">Score Range</th>
                                            <th class="px-4 py-2.5 text-center">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-bold text-slate-800">
                                        <tr class="bg-slate-50/50"><td class="px-4 py-2.5 text-slate-900 font-medium">85 &ndash; 100</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">A</td></tr>
                                        <tr><td class="px-4 py-2.5 text-slate-900 font-medium">80 &ndash; 84</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">B+</td></tr>
                                        <tr class="bg-slate-50/50"><td class="px-4 py-2.5 text-slate-900 font-medium">75 &ndash; 79</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">B</td></tr>
                                        <tr><td class="px-4 py-2.5 text-slate-900 font-medium">70 &ndash; 74</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">C+</td></tr>
                                        <tr class="bg-slate-50/50"><td class="px-4 py-2.5 text-slate-900 font-medium">65 &ndash; 69</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">C</td></tr>
                                        <tr><td class="px-4 py-2.5 text-slate-900 font-medium">60 &ndash; 64</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">D+</td></tr>
                                        <tr class="bg-slate-50/50"><td class="px-4 py-2.5 text-slate-900 font-medium">50 &ndash; 59</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">D</td></tr>
                                        <tr><td class="px-4 py-2.5 text-slate-900 font-medium">49 or below</td><td class="px-4 py-2.5 text-center font-extrabold text-slate-900">F</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- 6. Course Requirements & Rules Sections -->
                <div class="grid grid-cols-1 gap-8 lg:gap-10 md:grid-cols-2 mb-10">
                    <!-- Requirements -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-4 border-b border-slate-100 pb-3">
                            <svg class="h-5 w-5 shrink-0 text-[#5B2C6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span>Course Requirements</span>
                        </h3>
                        <ul class="mt-5 space-y-3.5 text-sm text-slate-800 font-medium leading-relaxed">
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-600 font-bold shrink-0">&check;</span>
                                <span>Complete on time: English pretest & posttest, 10 writing assignments, and final presentation.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-600 font-bold shrink-0">&check;</span>
                                <span>Participation in RSU Passport (Week 3).</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-emerald-600 font-bold shrink-0">&check;</span>
                                <span>Participation as a peer-mentor for the 10-week PAL program.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Rules & Regulations -->
                    <div class="rounded-2xl border-2 border-rose-300 bg-rose-50/70 p-6 md:p-8 shadow-sm">
                        <h3 class="text-base font-black text-rose-950 flex items-center gap-4 border-b border-rose-200 pb-3">
                            <svg class="h-5 w-5 shrink-0 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span>Rules & Regulations</span>
                        </h3>
                        <ul class="mt-5 space-y-3.5 text-sm text-rose-950 font-medium leading-relaxed">
                            <li class="flex items-start gap-3">
                                <span class="text-rose-700 font-bold shrink-0">&bull;</span>
                                <span>There are 10 online assignments in this course, which <strong class="underline decoration-rose-400 font-bold">CANNOT be accepted AFTER the due date</strong>.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-rose-700 font-bold shrink-0">&bull;</span>
                                <span>Make sure to be punctual. Attendance will be taken for each class based on your group presentations (and peer feedback), so if you are late or do not participate, your attendance will NOT be recorded.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-rose-700 font-bold shrink-0">&bull;</span>
                                <span>Students are to conduct themselves in a professional manner such as avoid talking in class when others are presenting. Academic dishonesty or cheating is not tolerated and is strictly enforced.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 7. 15-Week Schedule Section (Uniform Subtle Purple Border on All Weeks) -->
                <section id="schedule" class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm space-y-6 mb-10">
                    <style>
                        .schedule-card-hover {
                            cursor: pointer;
                            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        .schedule-card-hover:hover {
                            transform: translateY(-4px) scale(1.01);
                            border-color: #7D3C98;
                            background-color: #ffffff;
                            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.15), 0 8px 10px -6px rgba(139, 92, 246, 0.1);
                        }
                        .schedule-card-hover.schedule-blue-theme:hover {
                            border-color: #2563EB;
                            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
                        }
                    </style>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 gap-2">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 flex items-center gap-3">
                                <svg class="h-6 w-6 text-[#5B2C6F] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Course Schedule & Weekly Topics</span>
                            </h2>
                            <p class="text-xs font-bold text-slate-500 mt-0.5">Term 1, 2026 Interactive Curriculum Plan</p>
                        </div>
                        <span style="background-color: #F4ECF7; color: #5B2C6F;" class="inline-flex items-center justify-center rounded-xl px-5 py-2 min-w-[130px] text-xs font-black text-center border border-purple-200 shadow-xs hover:scale-105 hover:bg-purple-100 hover:shadow-md transition-all duration-200 cursor-default">
                            15 Weeks Total
                        </span>
                    </div>

                    <!-- Clean Weekly Card Blocks with Smooth Hover Effects -->
                    <div class="space-y-4">
                        
                        <!-- Week 1 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-3">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 1 &bull; Aug 20-21</span>
                                <span class="text-xs font-extrabold text-slate-600">Introduction</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Introduction to Intercultural Communication</h3>

                            <!-- Interactive Resource Buttons -->
                            <div class="pt-2 flex flex-wrap items-center gap-2.5">
                                <a 
                                    href="{{ route('materials.class01') }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    style="background-color: #5B2C6F;"
                                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-xs font-bold text-white shadow-xs border border-purple-800 hover:bg-[#4A235A] hover:scale-105 hover:shadow-md transition-all duration-200"
                                >
                                    <svg class="h-4 w-4 text-purple-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1m0 4h6m-6 4h6"></path>
                                    </svg>
                                    <span>Class 01 (Slides)</span>
                                    <svg class="h-3.5 w-3.5 text-purple-300 ml-0.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>

                                <a 
                                    href="{{ route('materials.chapter01') }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    style="background-color: #7D3C98;"
                                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-xs font-bold text-white shadow-xs border border-purple-600 hover:bg-[#6C3483] hover:scale-105 hover:shadow-md transition-all duration-200"
                                >
                                    <svg class="h-4 w-4 text-purple-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>Chapter 01 (Textbook)</span>
                                    <svg class="h-3.5 w-3.5 text-purple-200 ml-0.5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Week 2 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 2 &bull; Aug 27-28</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Understanding Culture, Power, and Decolonization</h3>
                        </div>

                        <!-- Week 3 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 3 &bull; Sept 3-4</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">AI-Assisted Training for Intercultural Peer Mentoring</h3>
                        </div>

                        <!-- Week 4 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 4 &bull; Sept 10-11</span>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-emerald-700 px-2.5 py-0.5 text-xs font-black text-white">RSU Passport</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">RSU Stargate</span>
                                </div>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Cultural Identity, Gender, and Intercultural Communication</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #1
                            </div>
                        </div>

                        <!-- Week 5 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 5 &bull; Sept 17-18</span>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-full bg-emerald-700 px-2.5 py-0.5 text-xs font-black text-white">Mentoring</span>
                                    <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Memorable experiences</span>
                                </div>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Cultural Dimensions and Communication Contexts</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #2
                            </div>
                        </div>

                        <!-- Week 6 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 6 &bull; Sept 24-25</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Shopping</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Verbal Communication Across Cultures</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #3
                            </div>
                        </div>

                        <!-- Week 7 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 7 &bull; Oct 1-2</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">RSU Stargate</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Nonverbal Communication Across Cultures</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #4
                            </div>
                        </div>

                        <!-- Week 8 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 8 &bull; Oct 15-16</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">My dream job</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Religion and Intercultural Communication</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE RSU GLOBAL! REFLECTION HOMEWORK #5
                            </div>
                        </div>

                        <!-- Week 9 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 9 &bull; Oct 22-23</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">RSU Stargate</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Stereotypes, Prejudice, Bias, and Cultural Representation</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #6
                            </div>
                        </div>

                        <!-- Week 10 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 10 &bull; Oct 29-30</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Childhood and school life</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Intercultural Conflict and Relationships</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #7
                            </div>
                        </div>

                        <!-- Week 11 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 11 &bull; Nov 5-6</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Advertisements</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Intercultural Communication in Education and the Workplace</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #8
                            </div>
                        </div>

                        <!-- Week 12 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 12 &bull; Nov 12-13</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">RSU Stargate</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Digital Intercultural Communication and Artificial Intelligence</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #9
                            </div>
                        </div>

                        <!-- Week 13 -->
                        <div class="schedule-card-hover rounded-xl border-2 border-purple-200 bg-purple-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span style="background-color: #5B2C6F;" class="rounded-md px-3 py-1 text-xs font-black text-white">Week 13 &bull; Nov 19-20</span>
                                <span class="rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-black text-white">Careers</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Developing Intercultural Competence in Practice</h3>
                            <div style="background-color: #5B2C6F;" class="mt-3 rounded-lg p-2.5 text-xs font-black text-white">
                                ONLINE PAL CENTER REFLECTION HOMEWORK #10
                            </div>
                        </div>

                        <!-- Week 14 -->
                        <div class="schedule-card-hover schedule-blue-theme rounded-xl border-2 border-blue-200 bg-blue-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="rounded-md bg-blue-700 px-3 py-1 text-xs font-black text-white">Week 14 &bull; Nov 26-27</span>
                                <span class="rounded-full bg-blue-700 px-2.5 py-0.5 text-xs font-black text-white">Summary & Reflections</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Dr. Edward Devere Bacon&rsquo;s Summary and Reflections on Intercultural Communication</h3>
                        </div>

                        <!-- Week 15 -->
                        <div class="schedule-card-hover schedule-blue-theme rounded-xl border-2 border-blue-200 bg-blue-50/40 p-5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span class="rounded-md bg-blue-700 px-3 py-1 text-xs font-black text-white">Week 15 &bull; Dec 3-4</span>
                                <span class="rounded-full bg-blue-700 px-2.5 py-0.5 text-xs font-black text-white">Final Presentations</span>
                            </div>
                            <h3 class="text-base font-extrabold text-slate-900">Final Presentations</h3>
                        </div>

                    </div>
                </section>

                <!-- 8. References & Resources Card -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 mt-10 mb-10">
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
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-10">
                    
                    <!-- Quick Navigation Links Card -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4 mb-10 transition-all duration-200 hover:shadow-md">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2.5">
                            Quick Navigation
                        </h4>
                        <nav class="space-y-2 text-xs font-bold">
                            <a href="#description" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] hover:translate-x-1.5 transition-all duration-200 border border-slate-100 hover:border-purple-200">
                                <span>Course Description</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#eligibility" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] hover:translate-x-1.5 transition-all duration-200 border border-slate-100 hover:border-purple-200">
                                <span>Eligibility & Pedagogy</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#objectives" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] hover:translate-x-1.5 transition-all duration-200 border border-slate-100 hover:border-purple-200">
                                <span>Course Objectives</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#assessment" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] hover:translate-x-1.5 transition-all duration-200 border border-slate-100 hover:border-purple-200">
                                <span>Assessment & Grading</span>
                                <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            <a href="#schedule" class="flex items-center justify-between rounded-xl px-4 py-3 text-slate-800 hover:bg-purple-50 hover:text-[#5B2C6F] hover:translate-x-1.5 transition-all duration-200 border border-slate-100 hover:border-purple-200">
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
                                <span class="text-xs font-bold text-purple-100">PDF &bull; Term 1 2026</span>
                            </div>
                            <h3 class="text-xl font-black text-white leading-snug pt-1">
                                Course Syllabus PDF
                            </h3>
                            <p class="text-xs text-purple-100 font-medium">
                                RSU/IRS 127: Intercultural Communication
                            </p>
                        </div>
                        
                        <div class="p-6 space-y-5 bg-purple-50/40">
                            <!-- Bulletproof Backend Download Route -->
                            <a 
                                href="{{ route('course127.download') }}" 
                                download="RSU 127 Course Syllabus.pdf" 
                                style="background-color: #D68910;"
                                class="flex w-full items-center justify-center gap-2.5 rounded-xl px-5 py-4 text-sm font-black text-white shadow-lg hover:bg-amber-600 hover:shadow-xl hover:scale-[1.02] transition-all duration-200 group border border-amber-300"
                            >
                                <svg class="h-6 w-6 text-white transition-transform group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Syllabus (PDF)
                            </a>

                            <!-- Bulletproof Backend Inline PDF Stream Route for New Tab -->
                            <div class="flex items-center justify-between text-xs font-bold text-slate-700 pt-3 border-t border-purple-200">
                                <span>File: PDF Document</span>
                                <a href="{{ route('course127.pdf') }}" target="_blank" rel="noopener noreferrer" class="text-[#5B2C6F] font-black hover:underline flex items-center gap-1">
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
