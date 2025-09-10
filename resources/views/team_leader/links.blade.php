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
        Team Leader Links
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
            @foreach($forms['pretest'] as $form)
            <div class="flex space-x-3 items-center justify-center">
                <a href="{{ $form->form_description }}" target="_blank"
                   class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                    {{ $form->form_name }}
                </a>

                @php $isDone = !empty($completion['pretest'][$form->id] ?? false); @endphp

                @if($isDone)
                    <h3 class="inline-flex text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</h3>
                    <form action="{{ route('team_leader.forms.undo', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                            Undo
                        </button>
                    </form>
                @else
                    <h3 class="inline-flex text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</h3>
                    <form action="{{ route('team_leader.forms.complete', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        <button type="submit"
                                class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                            Completed
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        @endif


        {{-- Questionnaire --}}
        @if(isset($forms['questionnaire']))
            @foreach($forms['questionnaire'] as $form)
            <div class="flex space-x-3 items-center justify-center">
                <a href="{{ $form->form_description }}" target="_blank"
                   class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                    {{ $form->form_name }}
                </a>

                @php $isDone = !empty($completion['questionnaire'][$form->id] ?? false); @endphp

                @if($isDone)
                    <h3 class="inline-flex text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</h3>
                    <form action="{{ route('team_leader.forms.undo', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">Undo</button>
                    </form>
                @else
                    <h3 class="inline-flex text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</h3>
                    <form action="{{ route('team_leader.forms.complete', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        <button type="submit" class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">Completed</button>
                    </form>
                @endif
            </div>
            @endforeach
        @endif


        {{-- Consent Form --}}
        @if(isset($forms['consent']))
            @foreach($forms['consent'] as $form)
                <div class="flex space-x-3 items-center justify-center">
                    <a href="{{ $form->form_description }}" target="_blank"
                       class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                       {{ $form->form_name }}
                    </a>

                    @php $isDone = !empty($completion['consent'][$form->id] ?? false); @endphp

                    @if($isDone)
                        <h3 class="inline-flex text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">Completed</h3>
                        <form action="{{ route('team_leader.forms.undo', $form->id) }}" method="POST" class="w-1/4">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                                Undo
                            </button>
                        </form>
                    @else
                        <h3 class="inline-flex text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">Incomplete</h3>
                        <form action="{{ route('team_leader.forms.complete', $form->id) }}" method="POST" class="w-1/4">
                            @csrf
                            <button type="submit"
                                    class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                                Completed
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        @endif

                <!-- Upload link(s) matching this form's NAME 
                @php
                    $matchedLinks = isset($fileUploadLinks) ? $fileUploadLinks->where('name', $form->name) : collect();
                @endphp
                @if($matchedLinks->isNotEmpty())
                    <label class="block text-sm text-gray-600 mt-6">
                        Upload the consent form
                        <span class="block mt-1 space-y-1">
                            @foreach($matchedLinks as $upl)
                                <a href="{{ $upl->url }}" class="text-blue-500 hover:underline block" target="_blank">
                                    {{ $upl->name }}
                                </a>
                            @endforeach
                        </span>
                    </label>
                @endif -->

        {{-- Post-test --}}
        @if(isset($forms['posttest']) && count($forms['posttest']) > 0)
            @foreach($forms['posttest'] as $form)
            <div class=" flex space-x-3 items-center justify-center">
                <a href="{{ $form->form_description }}" target="_blank"
                   class="flex-auto bg-white border-2 border-[#7D3C98] w-1/2 text-[#7D3C98] underline hover:bg-[#7D3C98] hover:text-white font-semibold py-2 px-4 rounded-lg transition duration-600 ease-in-out">
                    {{ $form->form_name }}
                </a>

                @php $isDone = !empty($completion['posttest'][$form->id] ?? false); @endphp

                @if($isDone)
                    <h3 class="inline-flex text-green-600 text-[10px] font-bold py-1 px-1 bg-green-100 rounded-lg absolute right-1/3 lg:right-[550px]">
                        Completed
                    </h3>
                    <form action="{{ route('team_leader.forms.undo', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-500 text-white font-bold py-2 px-2 rounded-lg hover:bg-red-600 transition">
                            Undo
                        </button>
                    </form>
                @else
                    <h3 class="inline-flex text-red-600 text-[10px] font-bold py-1 px-1 bg-red-100 rounded-lg absolute right-1/3 lg:right-[550px]">
                        Incomplete
                    </h3>
                    <form action="{{ route('team_leader.forms.complete', $form->id) }}" method="POST" class="w-1/4">
                        @csrf
                        <button type="submit"
                                class="w-full bg-[#158a00] text-white font-bold py-2 px-2 rounded-lg hover:bg-[#0f6100] transition">
                            Completed
                        </button>
                    </form>
                @endif
            </div>
            @endforeach
        @endif

    </div>
</x-layout>
