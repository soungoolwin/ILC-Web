<x-layout>
    
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-center text-xl lg:text-2xl font-bold text-gray-800 mt-10 mb-6">
        Student Links
    </div>
    <p class="flex justify-center text-center text-lg lg:text-xl font-semibold italic text-red-600 mb-4 mx-1">
        Please ensure that you have completed all forms before week 6.
    </p>
    <p class="flex justify-center text-center text-xs lg:text-sm text-gray-600 mb-4">
        You can access the forms by clicking respective buttons below.
        Make sure that you clicked "Completed" after you finish each form.
        <br>
         If you need to redo a form, click "Undo".
    </p>

    <div class="text-xs lg:text-sm max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 space-y-6">
        {{-- Pre-test --}}
        @if(isset($forms['pretest']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['pretest']->form_description }}" target="_blank"
                class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                Pre-test
            </a>
            @if(!empty($completion['pretest']))
                <span class="text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</span>
                <form action="{{ route('student.forms.undo', $forms['pretest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                
            @else
            <span class="text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</span>
                <form action="{{ route('student.forms.complete', $forms['pretest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif

        {{-- Questionnaire --}}
        @if(isset($forms['questionnaire']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['questionnaire']->form_description }}" target="_blank"
                class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                Questionnaire
            </a>
            @if(!empty($completion['questionnaire']))
            <span class="text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</span>
                <form action="{{ route('student.forms.undo', $forms['questionnaire']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                
            @else
            <span class="text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</span>
                <form action="{{ route('student.forms.complete', $forms['questionnaire']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif

        {{-- Consent Form --}}
        @if(isset($forms['consent']))
        <div id="studentConsent" class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['consent']->form_description }}" target="_blank"
                class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                Download Consent Form
            </a>
            @if(!empty($completion['consent']))
            <span class="text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</span>
                <form action="{{ route('student.forms.undo', $forms['consent']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                
            @else
            <span class="text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</span>
                <form action="{{ route('student.forms.complete', $forms['consent']->id) }}" method="POST" class="w-1/4">
                    @csrf
                   <button type="submit"
                        class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>

            <label for="studentConsent" class="text-sm text-gray-600 mt-6">
                Please upload the signed consent form 
                <span>
                    @if(!empty($fileUploadLink->url))
                    <a href="{{ $fileUploadLink->url }}" class="text-blue-500 hover:underline" target="_blank">here</a>
                    @endif
                </span>
            </label>

        {{-- File Upload --}}
        <div class="flex mt-4 hidden">
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-3/4 h-64 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4v16h16V4H4zm4 8h8m-4-4v8"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload your signed docx</span> or drag and drop</p>
                        <p class="text-xs text-gray-500">docx only</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" />
                </label>
            </div> 
        </div>
        @endif

        {{-- Post-test --}}
        @if(isset($forms['posttest']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['posttest']->form_description }}" target="_blank"
                class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                Post-test
            </a>
            @if(!empty($completion['posttest']))
            <span class="text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</span>
                <form action="{{ route('student.forms.undo', $forms['posttest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                
            @else
            <span class="text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</span>
                <form action="{{ route('student.forms.complete', $forms['posttest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</x-layout>
