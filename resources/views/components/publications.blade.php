<x-layout>
    <header class="flex w-full justify-center bg-[#7D3C98] text-center">
        <h1 class="m-6 text-center text-4xl font-thin text-white">
            RSUGlobal! Portal
        </h1>
    </header>
    <nav class="flex w-full justify-start px-4 py-2">
        <a
            href="{{ route("guest") }}"
            class="px-4 py-4 text-sm text-[#7D3C98] hover:underline"
        >
            &larr; Go back to Home
        </a>
    </nav>
    <body class="flex flex-col items-center">
        <div class="mx-auto mb-6 mt-2 w-full px-4 sm:px-6 lg:w-11/12 xl:w-5/6">
            {{-- Title & Description --}}
            <div class="mb-4 rounded-lg bg-purple-100 p-5 shadow-md">
                <h2 class="mb-2 text-2xl font-semibold text-[#7D3C98]">
                    RSU Global! Research Publications
                </h2>
                <p class="text-sm leading-relaxed text-gray-700">
                    Below is the list of all the research papers published by
                    Director Dr. Edward Devere Bacon (who is also the founder)
                    and Deputy-Director Aj. Gary Ambito Torremucha of RSU
                    Global!, which is the official peer-assisted learning (PAL)
                    center for Rangsit University.
                </p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg shadow-md">
                <table class="w-full border-collapse bg-white text-sm">
                    <thead>
                        <tr class="bg-[#7D3C98] text-white">
                            <th
                                class="w-10 px-3 py-3 text-center font-semibold"
                            >
                                No.
                            </th>
                            <th class="px-4 py-3 text-left font-semibold">
                                Published Research Paper
                            </th>
                            <th
                                class="w-36 px-3 py-3 text-center font-semibold"
                            >
                                Ranking
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $papers = [
                                [
                                    "no" => 1,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2026). Peer-assisted learning as a platform for intercultural development among Thai students in applied sciences, technology, and health sciences. In <em>Proceedings of the 11th RSU International Research Conference</em>. Rangsit University, Pathum Thani, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 2,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2026). Peer-Assisted Learning as a Platform for Intercultural Engagement: Evidence from Thai Health Sciences and Business Administration Students. In <em>Proceedings of the 11th RSU International Research Conference</em>. Rangsit University, Pathum Thani, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 3,
                                    "citation" => 'Bacon, E. D., & Torremucha, G. A. (2026). Intercultural Engagement through Peer-Assisted Learning: Thai Students\' Experiences in Applied Digital and Service Disciplines. In <em>Proceedings of the 11th RSU International Research Conference</em>. Rangsit University, Pathum Thani, Thailand.',
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 4,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2026). Beyond Academic Support: Peer-Assisted Learning and Intercultural Engagement in Thai Business Education. In <em>Proceedings of the 11th RSU International Research Conference</em>. Rangsit University, Pathum Thani, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 5,
                                    "citation" => "Bacon, E. D., & De Guzman-Laddawan, C. (2026). Engaging with Global Englishes Through Peer-Assisted Learning: A Controlled Mixed-Methods Study of Burmese International Students as Peer Mentors in a Thai University. In <em>Proceedings of the 11th RSU International Research Conference</em>. Rangsit University, Pathum Thani, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 6,
                                    "citation" => "Bacon, E. D., & Maneerutt, G. (2026). Navigating cultural transitions: the impact of peer-assisted learning on Burmese Communication Arts and Hospitality students in Thailand. <em>Mentoring &amp; Tutoring: Partnership in Learning</em>, 1–21.",
                                    "doi" => "https://doi.org/10.1080/13611267.2026.2664600",
                                    "ranking" => "Scopus Q2",
                                ],
                                [
                                    "no" => 7,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2026). Self-reported intercultural change through peer-assisted learning within internationalization at home: Evidence from communication programs. In <em>Proceedings of the 5th Thammasat University International ELT Conference 2026</em>. Thammasat University, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 8,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2026). Self-Reported Intercultural Change Through Peer-Assisted Learning within Internationalization at Home: Evidence from Communication Programs. In <em>Proceedings of the 5th Thammasat University International ELT Conference 2026</em>. Thammasat University, Thailand.",
                                    "doi" => null,
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 9,
                                    "citation" => "Torremucha G., & Bacon E. (2026). Cultural Integration Through Peer Collaboration: How PAL Programs Facilitate the Adaptation of Burmese Biomedical Science Students in Thailand. ISSN: 2186-5892 – <em>The Asian Conference on Education 2025: Official Conference Proceedings</em> (pp. 607–622).",
                                    "doi" => "https://doi.org/10.22492/issn.2186-5892.2026.47",
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 10,
                                    "citation" => "Bacon E., & Torremucha G. (2026). Coding Connections: Intercultural Competence Through Peer-Assisted Learning Among Digital Media and Technology Students. ISSN: 2186-5892 – <em>The Asian Conference on Education 2025: Official Conference Proceedings</em> (pp. 893–906).",
                                    "doi" => "https://doi.org/10.22492/issn.2186-5892.2026.68",
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 11,
                                    "citation" => "Bacon, E.D. & Torremucha, G.A. (2025). Fostering global digital citizenship: How peer collaboration shapes intercultural competence among Burmese ICT students. <em>Journal of Institutional Research South East Asia</em>, 23(3), 193–232.",
                                    "doi" => null,
                                    "ranking" => "Scopus Q4",
                                ],
                                [
                                    "no" => 12,
                                    "citation" => "Bacon, E. D., & Torremucha, G. A. (2025). Designing cultural bridges: a participatory Action research study on peer-assisted learning and intercultural competence in design education. <em>CoDesign</em>, 1–25.",
                                    "doi" => "https://doi.org/10.1080/15710882.2025.2571801",
                                    "ranking" => "Scopus Q1",
                                ],
                                [
                                    "no" => 13,
                                    "citation" => 'Bacon E., & Torremucha G. (2025). Fostering Leadership and Cultural Integration: Burmese Team Leaders\' Role in Peer-Assisted Learning Among Science and Technology Students. ISSN: 2186-229X – <em>The Asian Conference on Arts &amp; Humanities 2025 Official Conference Proceedings</em> (pp. 299–313).',
                                    "doi" => "https://doi.org/10.22492/issn.2186-229X.2025.24",
                                    "ranking" => "International Conference",
                                ],
                                [
                                    "no" => 14,
                                    "citation" => "Bacon, E.D., and Maneerutt, G. (2024). Enhancing EFL Academic Writing through AI and Peer-assisted Learning. <em>Journal of Institutional Research South East Asia</em>, 22(3), 282–314.",
                                    "doi" => null,
                                    "ranking" => "Scopus Q4",
                                ],
                                [
                                    "no" => 15,
                                    "citation" => "Bacon, E. D., Satienchayakorn, N., & Prakaiborisuth, P. (2021). Integrating Seamless Learning within a Peer-Assisted Learning Center to Develop Student English Academic Writing Skills. <em>rEFLections</em>, 28(2), 147–167.",
                                    "doi" => "https://doi.org/10.61508/refl.v28i2.251147",
                                    "ranking" => "Scopus Q2",
                                ],
                                [
                                    "no" => 16,
                                    "citation" => "Bacon, E. D., and Boundy, T. (2020). Utilizing peer feedback by synthesizing a peer-assisted learning center with an English Course to develop English grammar and academic writing skills. <em>Rangsit Journal of Educational Studies</em>, 7(1), 34–45.",
                                    "doi" => "https://doi.org/10.14456/rjes.2020.11",
                                    "ranking" => "TCI Tier 2",
                                ],
                                [
                                    "no" => 17,
                                    "citation" => "Bacon, E. D. (2020). Development of English grammar and writing skills based on participation in a peer-assisted learning center. <em>Human Behavior, Development and Society</em>, 21(2), 81–89.",
                                    "doi" => null,
                                    "ranking" => "TCI Tier 1",
                                ],
                            ];

                            $rankingStyles = [
                                "Scopus Q1" => "border border-yellow-300 bg-yellow-100 text-yellow-800",
                                "Scopus Q2" => "border border-green-300 bg-green-100 text-green-800",
                                "Scopus Q4" => "border border-blue-300 bg-blue-100 text-blue-800",
                                "International Conference" => "border border-purple-300 bg-purple-100 text-purple-800",
                                "TCI Tier 1" => "border border-orange-300 bg-orange-100 text-orange-800",
                                "TCI Tier 2" => "border border-orange-200 bg-orange-50 text-orange-700",
                            ];
                        @endphp

                        @foreach ($papers as $index => $paper)
                            <tr
                                class="{{ $index % 2 === 0 ? "bg-white" : "bg-purple-50" }} border-b border-gray-200 transition-colors hover:bg-purple-100"
                            >
                                <td
                                    class="px-3 py-3 text-center font-medium text-gray-500"
                                >
                                    {{ $paper["no"] }}
                                </td>
                                <td
                                    class="px-4 py-3 leading-relaxed text-gray-800"
                                >
                                    {!! $paper["citation"] !!}
                                    @if ($paper["doi"])
                                        <a
                                            href="{{ $paper["doi"] }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="ml-1 break-all text-xs text-blue-600 underline hover:text-blue-800"
                                        >
                                            {{ $paper["doi"] }}
                                        </a>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="{{ $rankingStyles[$paper["ranking"]] ?? "bg-gray-100 text-gray-700" }} inline-block px-2 py-1 text-xs font-semibold"
                                    >
                                        {{ $paper["ranking"] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</x-layout>
