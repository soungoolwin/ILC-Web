<x-layout>
    <div class="flex justify-center text-2xl font-bold text-gray-800 mt-10 mb-6">
        Team Leader Links
    </div>
    <div class="flex justify-center text-l text-red-600 mb-4">
        Please ensure that you have completed all four forms before week 6.
    </div>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">

        <div class="flex  space-x-3 mt-4 items-center justify-center">
            <a href="insert link here"
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Pre-test
            </a>
            <button type="submit"
                class=" bg-[#7D3C98] w-1/4 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Completed
            </button>
        </div>


        <div class="flex  space-x-3 mt-4 items-center justify-center">
            <a href="insert link here"
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Questionnaire
            </a>
            <button type="submit"
                class="bg-[#7D3C98] w-1/4 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Completed
            </button>
        </div>


        <div class="flex space-x-3 mt-4 items-center justify-center">
                <a href="insert link here"
                    class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                    Download Consent Form // upload signed form
                </a>
                <button type="submit"
                    class="bg-[#7D3C98] w-1/4 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                    Completed
                </button>
        </div>


        <div class="flex mt-4">
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-3/4 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload your signed docx</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">docx only</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div> 
        </div>


        <div class="flex  space-x-3 mt-4 items-center justify-center">
                <a href="insert link here"
                    class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                    Post-test
                </a>
                <button type="submit"
                    class="bg-[#7D3C98] w-1/4 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                    Completed
                </button>

        </div>

    </div>


</script>
</x-layout>