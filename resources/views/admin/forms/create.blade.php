<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Form</h2>

        <form action="{{ route('admin.forms.store') }}" method="POST">
            @csrf
            <div class="space-y-4 mb-6">

                <!-- Form Name -->
                <div>
                    <label for="form_name" class="block text-sm font-semibold text-gray-600">Form Name</label>
                    <input type="text" name="form_name" id="form_name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        value="{{ old('form_name') }}" required>
                </div>

                <!-- Form Description -->
                <div>
                    <label for="form_description" class="block text-sm font-semibold text-gray-600">Insert Form (URL)</label>
                    <textarea name="form_description" id="form_description"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition"
                        required>{{ old('form_description') }}</textarea>
                </div>

                <!-- Form Type -->
                <div>
                    <label for="form_type" class="block text-sm font-semibold text-gray-600">Form Type</label>
                    <select name="form_type" id="form_type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
                        <option value="">Select Form Type</option>
                        @foreach (['pretest', 'posttest', 'questionnaire', 'consent'] as $type)
                            <option value="{{ $type }}" {{ old('form_type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- For Role -->
                <div>
                    <label for="for_role" class="block text-sm font-semibold text-gray-600">Target Role</label>
                    <select name="for_role" id="for_role"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400">
                        <option value="" required>Select target role</option>
                        @foreach (['student', 'mentor', 'team_leader'] as $role)
                            <option value="{{ $role }}" {{ old('for_role') === $role ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $role)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Flags -->
                <div class="flex justify-center space-x-8 mt-4">
                    <div>
                        <label for="is_active" class="text-sm font-semibold text-gray-600">Is Active</label>
                        <input type="checkbox" name="is_active" id="is_active" class="rounded-lg"
                            {{ old('is_active') ? 'checked' : '' }}>
                    </div>

                    <div>
                        <label for="is_mandatory" class="text-sm font-semibold text-gray-600">Is Mandatory</label>
                        <input type="checkbox" name="is_mandatory" id="is_mandatory" class="rounded-lg"
                            {{ old('is_mandatory') ? 'checked' : '' }}>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-[#7D3C98] text-white font-bold py-2 px-4 rounded-lg transition">
                    Create Form
                </button>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul class="list-disc pl-6 text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </form>
    </div>
</x-layout>
