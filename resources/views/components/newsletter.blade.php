<x-layout>
    @auth
        <header class="flex w-full bg-[#7D3C98] text-center justify-center">
            <h1 class="text-center text-4xl font-thin text-white m-6"> RSUGlobal! Portal</h1>
</header>
<body class="flex justify-evenly items-center flex-col">
        <div class="flex flex-col items-center justify-center sm:w-full lg:w-3/4 mx-auto bg-purple-100 p-4 shadow-md mt-2 mb-3 rounded-lg px-2">
            <p> Download October Newsletter <a href="{{ asset('images/News_October 2025.pdf') }}" download class="text-blue-600 underline mb-2 mt-2 hover:scale-105">
                Here
            </a></p>
            <embed src="{{ asset('images/News_October 2025.pdf') }}#toolbar=0" type="application/pdf" width="100%" height="600px" class="mt-2 rounded shadow" />
        </div>
        <div class="flex flex-col items-center justify-center sm:w-full lg:w-3/4 mx-auto bg-purple-100 p-4 shadow-md mt-2 mb-3 rounded-lg px-2">
            <p class="font-thin text-4xl mb-2 bg-white-200"> Download All Newsletters </p>
            <div class="border-t border-gray-300 w-full my-4"></div>
            <p class="font-thin text-lg mb-2"><a href="{{ asset('images/News_September 2025.pdf') }}" download class="text-blue-600 underline mb-2 mt-2 hover:scale-105"> 
                RSUGlobal! Newsletter Issue ( 001 ) - September 2025
            </a></p>
            <p class="font-thin text-lg mb-2"><a href="{{ asset('images/News_October 2025.pdf') }}" download class="text-blue-600 underline mb-2 mt-2 hover:scale-105"> 
                RSUGlobal! Newsletter Issue ( 002 ) - October 2025
            </a></p>
            </div>
        </div>
</body>
    @else
        <div class="text-center mt-8 text-red-600">
            Please log in to view the newsletter.
        </div>
    @endauth
</x-layout>