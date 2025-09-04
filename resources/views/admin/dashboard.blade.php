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
    <div class="flex flex-col items-center justify-center w-full lg:w-full mx-auto bg-[#7D3C98] p-4 shadow-md mt-2 mb-3">
        <div class="flex flex-col justify-center items-center bg-[#7D3C98] w-full lg:w-1/2 ">
            <div class=" flex max-w-xs justify-center bg-white hover:shadow-lg hover:scale-105 rounded-md">
                <a href="https://tinyurl.com/WebsiteTeamSurvey"><img src="/images/webTeamSurvey.png" alt="web team survey" class="w-32 h-auto p-2" ></a>
            </div>
        <a href="https://tinyurl.com/WebsiteTeamSurvey" class="text-center text-white text-lg mb-2 mt-2 text-[28px] hover:underline hover:scale-105">Web Team Survey</a>
        <p class="text-[12px] text-white text-center text-[12px]">Please fill out this survey to help us improve the RSU PAL Centre website and services. When answering the questions, please provide as much detail as possible instead of yes and no only. We appreciate your feedback!</p>
</div>
</div>
        <h2 class="text-center mb-2 mt-2 text-[28px] italic">RSUGlobal! PAL Center</h2>
        {{-- Youtube Video --}}
        <div class="flex flex-col w-full lg:w-1/2 px-2 justify-center items-center mx-auto">
            <iframe class="aspect-video" src="https://www.youtube.com/embed/rbr0DHSeyNw?si=6iKLSEYSv8j6Qv-z" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
            </iframe>

        <div class="w-full flex flex-wrap items-center justify-center gap-2 mt-2 ml-2 mr-2 mb-6">
            <a href="{{ route('admin.mentor_students_timetable') }}"class=" text-center block bg-[#7D3C98] px-3 py-3 lg:px-4 lg:py-2 text-xs lg:text-lg text-white hover:bg-[#683280] rounded-md transition-colors break-words">
                Mentor-Student Timetables
            </a>
            <a href="{{ route('admin.team_leaders_timetable') }}"class=" text-center block bg-[#7D3C98] px-3 py-3 lg:px-4 lg:py-2 text-xs lg:text-lg text-white hover:bg-[#683280] rounded-md transition-colors">
                TeamLeader Timetables
            </a>
            <a href="{{ route('admin.forms.index') }}"class=" text-center block bg-[#7D3C98] px-3 py-3 lg:px-4 lg:py-2 text-xs lg:text-lg text-white hover:bg-[#683280]  rounded-md transition-colors">
                Manage Forms
            </a>
            <a href="{{ route('admin.forms.tracking') }}"class=" text-center block bg-[#7D3C98] px-3 py-3 lg:px-4 lg:py-2 text-xs lg:text-lg text-white hover:bg-[#683280]  rounded-md transition-colors">
                Track Form Completion
            </a>
        </div>
    </div>
</x-layout>
