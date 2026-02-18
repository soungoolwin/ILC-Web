<x-layout>
    <header class="flex w-full justify-center bg-[#7D3C98] text-center">
        <h1 class="m-6 text-center text-4xl font-thin text-white">
            RSUGlobal! Portal
        </h1>
    </header>
    <body class="flex flex-col items-center justify-evenly">
        <div
            class="mx-auto mb-3 mt-2 flex flex-col items-center justify-center rounded-lg bg-purple-100 p-4 px-2 shadow-md sm:w-full lg:w-3/4"
        >
            <p>
                Download November Newsletter
                <a
                    href="{{ asset("images/News_November 2025.pdf") }}"
                    download
                    class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                >
                    Here
                </a>
            </p>
            <embed
                src="{{ asset("images/News_November 2025.pdf") }}#toolbar=0"
                type="application/pdf"
                width="100%"
                height="600px"
                class="mt-2 rounded shadow"
            />
        </div>
        <div
            class="items-left mx-auto mb-3 mt-2 flex flex-row justify-center rounded-lg bg-purple-100 p-4 px-2 shadow-md sm:w-full lg:w-3/4"
        >
            <div
                class="items-left justify-left w-1/2 flex-row border-r border-gray-300 bg-purple-100 p-4"
            >
                <p class="bg-white-200 mb-2 text-xl font-thin">
                    Download All Newsletters
                </p>
                <p class="mb-2 text-xs font-thin">
                    <a
                        href="{{ asset("images/News_September 2025.pdf") }}"
                        download
                        class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                    >
                        RSUGlobal! Newsletter Issue ( 001 ) - September 2025
                    </a>
                </p>
                <p class="mb-2 text-xs font-thin">
                    <a
                        href="{{ asset("images/News_October 2025.pdf") }}"
                        download
                        class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                    >
                        RSUGlobal! Newsletter Issue ( 002 ) - October 2025
                    </a>
                </p>
                <p class="mb-2 text-xs font-thin">
                    <a
                        href="{{ asset("images/News_November 2025.pdf") }}"
                        download
                        class="mb-2 mt-2 text-blue-600 underline hover:scale-105"
                    >
                        RSUGlobal! Newsletter Issue ( 003 ) - November 2025
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
