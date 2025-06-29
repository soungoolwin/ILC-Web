<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Details: {{ $form->form_name }}</h2>

        <div class="space-y-4 mb-6">
            <div>
                <label for="form_name" class="block text-sm font-semibold text-gray-600">Form Name</label>
                <input type="text" id="form_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" value="{{ $form->form_name }}" disabled>
            </div>

            <div>
                <label for="form_description" class="block text-sm font-semibold text-gray-600">Form Description</label>
                <textarea id="form_description" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" disabled>{{ $form->form_description }}</textarea>
            </div>

            <div class="flex items-center space-x-4">
                <div>
                    <label for="is_active" class="block text-sm font-semibold text-gray-600">Is Active</label>
                    <input type="checkbox" id="is_active" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" {{ $form->is_active ? 'checked' : '' }} disabled>
                </div>
                <div>
                    <label for="is_mandatory" class="block text-sm font-semibold text-gray-600">Is Mandatory</label>
                    <input type="checkbox" id="is_mandatory" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition" {{ $form->is_mandatory ? 'checked' : '' }} disabled>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.forms.index') }}" class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg transition">
            Back to Forms List
        </a>
    </div>
</x-layout>
