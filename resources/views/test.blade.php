<x-layout>

    <!-- Main content with video -->
    <div class="container mx-auto py-8">
        <div class="mx-auto w-4/5">

            <!-- YouTube Video - Centered and Responsive -->
            <div class="w-full flex flex-col lg:flex-row justify-center mb-8">
                <aside class="w-full lg:w-1/2 mr-4 mb-4">
                <div class="flex flex-col items-left justify-left w-full bg-purple-100 p-4 shadow-md rounded-lg h-[300px] lg:h-[400px]">
                    <p> Download RSUGlobal! Newsletter Issue ( 001 ) <a href="{{ asset('images/News_September 2025.pdf') }}" download class="text-blue-600 underline mb-2 mt-2 hover:scale-105">
                        Here
                    </a></p>
                    <embed src="{{ asset('images/News_September 2025.pdf') }}#toolbar=0" type="application/pdf" width="100%" height="500px" class="mt-2 rounded shadow" />
                </div>
            </aside>
                <iframe class="w-full md:w-3/4 lg:w-2/3 aspect-video rounded-lg shadow-lg"
                        src="https://www.youtube.com/embed/rbr0DHSeyNw?si=6iKLSEYSv8j6Qv-z"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                </iframe>
            </div>
<!-- FAQ Section - Using accordion style as in the reference image -->
<div class="mb-8 text-xs md:text-base">
    <div class="mb-2">
        <button class="w-full flex   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onclick="toggleAccordion('faq1')">
            <span class="font-semibold text-left">"What is the RSU PAL Centre?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq1" class="hidden px-3 py-4 border-t">
            <p class="text-gray-700">Established in 2018 (as the RIC Language Center) by Dr. Edward Devere Bacon of Rangsit University International College, it was originally set up as a peer-assisted learning (PAL) center for the faculty to aid international students with their English communication skills. Fast forward to 6 years later, it is now Rangsit University's official PAL centre, where thousands of students come each week to develop their English skills. This is now a collaborative academic program between RELI and RIC, with Dr. Edward Devere Bacon (RIC) acting as Director, and Aj. Gary Ambito Torremucha (RELI) acting as Deputy Director.</p>
        </div>
    </div>

    <div class="mb-2">
        <button class="w-full flex gap-1   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onClick="toggleAccordion('faq2')">
            <span class="font-semibold  text-left">"How often do RIC students attend the RSU PAL Centre?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-lineCap="round" stroke-lineJoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq2" class="hidden px-3 py-4 border-t">
            <p class="mb-2 text-gray-700">In order to align with Rangsit University's motto of "Creating a giving and sharing society," RIC students who are enrolled in the following courses are expected to volunteer at the RSU PAL Centre for one hour each week for this 10-week program (from Week 4 to Week 13):</p>
            <ol class="italic pl-5 list-decimal mb-4 text-gray-700">
                <li>ENL/ILE 125: English for Global Exploration</li>
                <li>ENL/ILE 126: English in TED</li>
                <li>ENL/ILE 127: English at Work</li>
                <li>RSU/IRS 127: Intercultural Communication</li>
            </ol>
            <p class="text-gray-700">There are plans to expand this academic program to other courses next academic year (and every year thereafter) – with the eventual goal by the academic year of 2570 to have a minimum of 20,000 RSU/RIC students each year to attend this PAL centre.</p>
        </div>
    </div>

    <div class="mb-2">
        <button class="w-full flex gap-1   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onclick="toggleAccordion('faq3')">
            <span class="font-semibold text-left">"How do RSU students select their mentors?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq3" class="hidden px-3 py-4 border-t">
            <p class="text-gray-700">At the beginning of each academic term, groups of Thai students are randomly paired up with mentors in the International College. However, if students wish to have a specific mentor that is possible as well. If you wish to do this, please let a member of the student management team know and they can set this up for you. Additionally, by the Summer Term, we are hoping to have mentor profiles (with images) on the website, that way students can more easily select their mentors. Please stay tuned!</p>
        </div>
    </div>

    <div class="mb-2">
        <button class="w-full flex gap-1   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onclick="toggleAccordion('faq4')">
            <span class="font-semibold text-left">"Who should I contact for additional information about the RSU PAL Center?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq4" class="hidden px-3 py-4 border-t">
            <p class="mb-4 text-gray-700">If you would like more information about the RSU PAL Centre, please contact Poe Theingi Khaing (Helen).</p>
            <div class="flex flex-col md:flex-row items-center gap-4">
                <img src="/images/helen_line_qr.jpg" alt="Helen Line ID" class="w-[100px] h-[100px]"/>
                <a href="https://line.me/ti/p/i4bxITrUFu" class="underline text-blue-500 hover:text-blue-700 transition">helen05_ptk</a>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <button class="w-full flex gap-1   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onclick="toggleAccordion('faq5')">
            <span class="font-semibold text-left">"Where is the RSU PAL Centre located?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq5" class="hidden px-3 py-4 border-t">
            <p class="text-gray-700 font-bold">The RSU PAL Centre is located in Building 7 (Library Building), in room 101. The mailing address is the following: 52/347 Phahonyothin Rd, Tambon Lak Hok, Amphoe Mueang Pathum Thani, Chang Wat Pathum Thani 12000</p>
        </div>
    </div>

    <div class="mb-2">
        <button class="w-full flex gap-1   justify-between py-4 px-3 border rounded-md bg-white hover:bg-gray-50" onclick="toggleAccordion('faq6')">
            <span class="font-semibold text-left">"Has there been any academic research published regarding the RSU PAL Center?"</span>
            <svg class="w-5 h-5 min-w-5 min-h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div id="faq6" class="hidden px-3 py-4 border-t">
            <p class="mb-4 text-gray-700">Yes, as of now we have four papers published in academic journals. The following two papers are published in Thailand's TCI-indexed journals:</p>
            <ol class="italic pl-5 list-decimal mb-6 text-gray-700">
                <li>Bacon, E.D. (2020). Development of English Grammar and Writing Skills Based on Participation in a Peer-assisted Learning Center. Human, Behavior and Society, 21(2), 81-89.</li>
                <li>Bacon, E.D., Boundy, T. (2020). Utilizing Peer Feedback by Synthesizing a Peer-Assisted Learning Center with an English Course to Develop English Grammar and Academic Writing Skills. Rangsit Journal of Educational Studies, 7(1), 34-45. DOI: 10.14456/rjes.2020.11</li>
            </ol>

            <p class="mb-4 text-gray-700">The following two papers are published in international Scopus-indexed journals:</p>
            <ol class="italic pl-5 list-decimal mb-6 text-gray-700">
                <li>Bacon, E.D., Satienchayakorn, N. & Prakaiborisuth, P. (2021). Integrating Seamless Learning within a Peer-Assisted Learning Center to Develop Student English Academic Writing Skills. rEFLections, 28(2), 147-167.</li>
                <li>Bacon, E.D., and Maneerutt, G. (2024). Enhancing EFL Academic Writing through AI and Peer-assisted Learning. Journal of Institutional Research South East Asia, 22(3), 282-314.</li>
            </ol>
            <p class="text-gray-700">There are ambitious plans to have additional academic papers published in other international Scopus-index journals by the end of 2025!</p>
        </div>
    </div>
</div>
</div>
</div>

<script>
function toggleAccordion(id) {
const element = document.getElementById(id);
if(element.classList.contains('hidden')) {
    element.classList.remove('hidden');
} else {
    element.classList.add('hidden');
}
}
</script>
</x-layout>
