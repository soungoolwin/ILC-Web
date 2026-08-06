<x-layout>
    @php
        $pdfPath = public_path('images/RSU 127 Course Syllabus.pdf');
        if (!file_exists($pdfPath)) {
            $pdfPath = public_path('images/RSU_127_Course_Syllabus.pdf');
        }
        $pdfBase64 = file_exists($pdfPath) ? base64_encode(file_get_contents($pdfPath)) : '';
        $pdfEmbedSrc = 'data:application/pdf;base64,' . $pdfBase64 . '#toolbar=0';
    @endphp

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
    <body class="flex flex-col items-center justify-evenly">
        <!-- Main Purple Container Box -->
        <div
            class="mx-auto mb-3 mt-2 flex flex-col items-center justify-center rounded-lg bg-purple-100 p-4 px-2 shadow-md sm:w-full lg:w-3/4"
        >
            <p>
                Download RSU/IRS 127 Course Syllabus
                <a
                    href="{{ asset("images/RSU 127 Course Syllabus.pdf") }}"
                    download
                    class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                >
                    Here
                </a>
            </p>

            <!-- Native Embedded PDF Tag with Base64 Payload -->
            <embed
                src="{{ $pdfEmbedSrc }}"
                type="application/pdf"
                width="100%"
                height="600px"
                class="mt-2 rounded shadow"
            />
        </div>

        <!-- Bottom Secondary Links Box -->
        <div
            class="items-left mx-auto mb-3 mt-2 flex flex-row justify-center rounded-lg bg-purple-100 p-4 px-2 shadow-md sm:w-full lg:w-3/4"
        >
            <div
                class="items-left justify-left w-1/2 flex-row border-r border-gray-300 bg-purple-100 p-4"
            >
                <p class="bg-white-200 mb-2 text-xl font-thin">
                    RSU/IRS 127 Course Syllabus
                </p>
                <p class="mb-2 text-xs font-thin">
                    <a
                        href="{{ asset("images/RSU 127 Course Syllabus.pdf") }}"
                        download
                        class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                    >
                        RSU/IRS 127: Intercultural Communication Course Syllabus
                    </a>
                </p>
            </div>
            <div
                class="items-left justify-left w-1/2 flex-row bg-purple-100 p-4"
            >
                <p class="bg-white-200 mb-2 text-xl font-thin">
                    Additional Links
                </p>
            </div>
        </div>
    </body>
</x-layout>
