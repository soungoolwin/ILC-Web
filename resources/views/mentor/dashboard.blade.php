<x-layout>
    <!-- Error Message -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-md mb-6">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
            {{ session('success') }}
        </div>
    @endif
    <div>
        {{-- Youtube Video --}}
        <iframe
            class="w-1/2 m-auto aspect-video"
            src="https://www.youtube.com/embed/XHOmBV4js_E"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
        <div class=" w-4/5 m-auto p-2 mb-4 text-[12px] mt-5">
            <div id="accordion-collapse-timetable" data-accordion="collapse" class="w-4/5 flex m-auto flex-row gap-1">
                {{-- First Item --}}
                <div class="w-full">
                    <h2 id="accordion-collapse-heading-1">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                                data-accordion-target="#accordion-collapse-body-1"
                                aria-expanded="false"
                                aria-controls="accordion-collapse-body-1">
                            <span>Monday</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>

                    <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1 ">
                        <div class="p-5 border border-b-0 border-gray-200">
                            <p class="mb-2 text-gray-500">
                                <p>09:00 - 11:00 (5 Mentors)</p>
          <p>11:00 - 12:00 (20 Mentors)</p>
          <p>12:00 - 13:00 (20 Mentors)</p>
          <p>13:00 - 14:00 (20 Mentors)</p>
          <p>14:00 - 15:00 (20 Mentors)</p>
          <p>15:00 - 16:00 (20 Mentors)</p>
          <p>16:00 - 17:00 (20 Mentors)</p>
          <p>17:00 - 18:00 (-)</p>
          <p>18:00 - 19:00 (-)</p>
          <p>19:00 - 20:00 (-)</p>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Second Item --}}
                <div class="w-full">
                    <h2 id="accordion-collapse-heading-2">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                                data-accordion-target="#accordion-collapse-body-2"
                                aria-expanded="false"
                                aria-controls="accordion-collapse-body-2">
                            <span>Tuesday</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                        <div class="p-5 border border-b-0 border-gray-200">
                            <p class="mb-2 text-gray-500">
                                <p>09:00 - 11:00 (5 Mentors)</p>
          <p>11:00 - 12:00 (20 Mentors)</p>
          <p>12:00 - 13:00 (20 Mentors)</p>
          <p>13:00 - 14:00 (20 Mentors)</p>
          <p>14:00 - 15:00 (20 Mentors)</p>
          <p>15:00 - 16:00 (20 Mentors)</p>
          <p>16:00 - 17:00 (20 Mentors)</p>
          <p>17:00 - 18:00 (-)</p>
          <p>18:00 - 19:00 (-)</p>
          <p>19:00 - 20:00 (-)</p>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Third Item --}}
                <div class="w-full">
                    <h2 id="accordion-collapse-heading-3">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                                data-accordion-target="#accordion-collapse-body-3"
                                aria-expanded="false"
                                aria-controls="accordion-collapse-body-3">
                            <span>Wednesday</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                        <div class="p-5 border border-b-0 border-gray-200">
                            <p class="mb-2 text-gray-500">
                                <p>09:00 - 11:00 (5 Mentors)</p>
          <p>11:00 - 12:00 (20 Mentors)</p>
          <p>12:00 - 13:00 (20 Mentors)</p>
          <p>13:00 - 14:00 (20 Mentors)</p>
          <p>14:00 - 15:00 (20 Mentors)</p>
          <p>15:00 - 16:00 (20 Mentors)</p>
          <p>16:00 - 17:00 (20 Mentors)</p>
          <p>17:00 - 18:00 (-)</p>
          <p>18:00 - 19:00 (-)</p>
          <p>19:00 - 20:00 (-)</p>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Fourth Item --}}
                <div class="w-full">
                    <h2 id="accordion-collapse-heading-4">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                                data-accordion-target="#accordion-collapse-body-4"
                                aria-expanded="false"
                                aria-controls="accordion-collapse-body-4">
                            <span>Thursday</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-4">
                        <div class="p-5 border border-b-0 border-gray-200">
                            <p class="mb-2 text-gray-500">
                                <p>09:00 - 11:00 (5 Mentors)</p>
          <p>11:00 - 12:00 (20 Mentors)</p>
          <p>12:00 - 13:00 (20 Mentors)</p>
          <p>13:00 - 14:00 (20 Mentors)</p>
          <p>14:00 - 15:00 (20 Mentors)</p>
          <p>15:00 - 16:00 (20 Mentors)</p>
          <p>16:00 - 17:00 (20 Mentors)</p>
          <p>17:00 - 18:00 (-)</p>
          <p>18:00 - 19:00 (-)</p>
          <p>19:00 - 20:00 (-)</p>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- Fifth Item --}}
                <div class="w-full">
                    <h2 id="accordion-collapse-heading-5">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                                data-accordion-target="#accordion-collapse-body-5"
                                aria-expanded="false"
                                aria-controls="accordion-collapse-body-5">
                            <span>Friday</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5">
                        <div class="p-5 border border-b-0 border-gray-200">
                            <p class="mb-2 text-gray-500">
                                <p>09:00 - 11:00 (5 Mentors)</p>
          <p>11:00 - 12:00 (20 Mentors)</p>
          <p>12:00 - 13:00 (20 Mentors)</p>
          <p>13:00 - 14:00 (20 Mentors)</p>
          <p>14:00 - 15:00 (20 Mentors)</p>
          <p>15:00 - 16:00 (20 Mentors)</p>
          <p>16:00 - 17:00 (20 Mentors)</p>
          <p>17:00 - 18:00 (-)</p>
          <p>18:00 - 19:00 (-)</p>
          <p>19:00 - 20:00 (-)</p>
                            </p>
                        </div>
                    </div>
                </div>


            </div>


          </div>
        {{-- Accordion----------- --}}
        <div id="accordion-collapse" data-accordion="collapse" class="w-4/5 mx-auto mb-6">
            {{-- Sixth Item --}}
            <h2 id="accordion-collapse-heading-6">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-6"
                        aria-expanded="false"
                        aria-controls="accordion-collapse-body-6">
                    <span>What is the RANGSIT UNIVERSITY International College Language Center?</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-6" class="hidden" aria-labelledby="accordion-collapse-heading-6">
                <div class="p-5 border border-b-0 border-gray-200">
                    <p class="mb-2 text-gray-500">The Rangsit University International College Language Center is a dedicated facility designed to support students in improving their language skills. It offers various services such as language courses, peer mentoring programs, and resources to enhance proficiency in English and other languages. The center aims to help students succeed academically and professionally by fostering effective communication skills in a multicultural environment.</p>
                </div>
            </div>

            {{-- Seventh Item --}}
            <h2 id="accordion-collapse-heading-7">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-7"
                        aria-expanded="false"
                        aria-controls="accordion-collapse-body-7">
                    <span>How many times does a student from RIC have to do peer mentor?</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-7" class="hidden" aria-labelledby="accordion-collapse-heading-7">
                <div class="p-5 border border-b-0 border-gray-200">
                    <p class="mb-2 text-gray-500">A student from RIC is required to participate in peer mentoring two times during their academic journey. This applies to students enrolled in language courses such as ILE 125, 126, 127, 128, and THA 125, 126. While students must complete all five language courses as part of their curriculum, they only need to engage in mentoring for two semesters over their four-year academic program.</p>
                </div>
            </div>

            {{-- Eighth Item --}}
            <h2 id="accordion-collapse-heading-8">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-8"
                        aria-expanded="false"
                        aria-controls="accordion-collapse-body-8">
                    <span>How does a mentor choose the student?</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-8" class="hidden" aria-labelledby="accordion-collapse-heading-8">
                <div class="p-5 border border-t-0 border-gray-200">
                    <p class="mb-2 text-gray-500">A mentor does not choose the student. Instead, students select their mentor based on the mentor's available schedule. This ensures that the mentoring sessions align with the students' timetable and preferences.</p>
                </div>
            </div>
            {{-- Ninth Item --}}
            <h2 id="accordion-collapse-heading-9">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-9"
                        aria-expanded="false"
                        aria-controls="accordion-collapse-body-9">
                    <span>Who do I have to contact for additional questions?</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-9" class="hidden" aria-labelledby="accordion-collapse-heading-9">
                <div class="p-5 border border-b-0 border-gray-200 ">
                    <p class="mb-2 text-gray-500"><span class="font-bold">For students from the Thai program:</span></br>

                        Please contact Ajarn Eddie and his assistant team.</br>
                        Ajarn Eddie: LINE ID: *****, Email: *****</br>
                        Assistant Team: LINE ID: *****, Email: *****</br></br>

                        <span class="font-bold">For students from RIC:</span></br>

                        You can contact Ajarn Eddie, Ajarn Gary, and their assistant team.</br>
                        Ajarn Eddie: LINE ID: *****, Email: *****</br>
                        Ajarn Gary: LINE ID: *****, Email: *****</br>
                        Assistant Team: LINE ID: *****, Email: *****</p>
                </div>
            </div>
            {{-- Tenth Item --}}
            <h2 id="accordion-collapse-heading-10">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100"
                        data-accordion-target="#accordion-collapse-body-10"
                        aria-expanded="false"
                        aria-controls="accordion-collapse-body-10">
                    <span>Where is ILC located?</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-10" class="hidden" aria-labelledby="accordion-collapse-heading-10">
                <div class="p-5 border border-b-0 border-gray-200 ">
                    <p class="mb-2 text-gray-500"><span class="font-bold">Room-100, Building 7</span>, 52/347 Phahonyothin Rd, Tambon Lak Hok, Amphoe Mueang Pathum Thani, Chang Wat Pathum Thani 12000</p>
                </div>
            </div>

        </div>
    </div>
</x-layout>
