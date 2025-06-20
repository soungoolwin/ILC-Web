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

    <div class="flex justify-center text-2xl font-bold text-gray-800 mt-10 mb-6">
        Student Links
    </div>
    <div class="flex justify-center text-l text-red-600 mb-4">
        Please ensure that you have completed all forms before week 6.
    </div>

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 space-y-6">
        {{-- Pre-test --}}
        @if(isset($forms['pretest']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['pretest']->form_description }}" target="_blank"
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Pre-test
            </a>
            @if(!empty($completion['pretest']))
                <form action="{{ route('student.forms.undo', $forms['pretest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                <span class="text-green-600 font-bold">✔ Completed</span>
            @else
                <form action="{{ route('student.forms.complete', $forms['pretest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
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
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Questionnaire
            </a>
            @if(!empty($completion['questionnaire']))
                <form action="{{ route('student.forms.undo', $forms['questionnaire']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                <span class="text-green-600 font-bold">✔ Completed</span>
            @else
                <form action="{{ route('student.forms.complete', $forms['questionnaire']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif

        {{-- Consent Form --}}
        @if(isset($forms['consent']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['consent']->form_description }}" target="_blank"
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Download Consent Form (upload signed version)
            </a>
            @if(!empty($completion['consent']))
                <form action="{{ route('student.forms.undo', $forms['consent']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                <span class="text-green-600 font-bold">✔ Completed</span>
            @else
                <form action="{{ route('student.forms.complete', $forms['consent']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif

        {{-- Post-test --}}
        @if(isset($forms['posttest']))
        <div class="flex space-x-3 items-center justify-center">
            <a href="{{ $forms['posttest']->form_description }}" target="_blank"
                class="block bg-[#7D3C98] w-1/2 text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                Post-test
            </a>
            @if(!empty($completion['posttest']))
                <form action="{{ route('student.forms.undo', $forms['posttest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-600 transition">
                        Undo
                    </button>
                </form>
                <span class="text-green-600 font-bold">✔ Completed</span>
            @else
                <form action="{{ route('student.forms.complete', $forms['posttest']->id) }}" method="POST" class="w-1/4">
                    @csrf
                    <button type="submit"
                        class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg hover:bg-[#701b94] transition">
                        Completed
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</x-layout>
