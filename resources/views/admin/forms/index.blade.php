<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Management</h2>

        <p>Debug: {{ $uploadLink->id ?? 'No model found' }}</p>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.forms.index') }}" class="flex space-x-4 mb-6">
            <div class="flex items-left space-x-3">
                <div>
                <label class="block text-xs lg:text-sm font-semibold text-gray-600">Form Type</label>
                <select name="form_type" class="w-full text-xs lg:text-sm border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    <option value="">All Types</option>
                    @foreach(['pretest', 'posttest', 'questionnaire', 'consent'] as $type)
                        <option value="{{ $type }}" {{ request('form_type') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
                </div>
            

            <div>
                <label class="block text-xs lg:text-sm font-semibold text-gray-600">For Role</label>
                <select name="for_role" class="w-full text-xs lg:text-sm border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                    <option value="">All Roles</option>
                    @foreach(['student', 'mentor', 'team_leader'] as $role)
                        <option value="{{ $role }}" {{ request('for_role') === $role ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="block mt-4 w-full bg-[#7D3C98] text-white font-bold text-xs lg:text-sm py-2 px-4 rounded-lg transition">Filter</button>
            </div>
        </div>
        </form>

        <!-- Create New Form Button -->
        <a href="{{ route('admin.forms.create') }}"
            class="bg-[#008000] text-xs lg:text-base text-white px-4 py-2 rounded-lg inline-block mb-4">
            Create New Form
        </a>

        <!-- Create New Upload Link Button -->
        <a href="{{ route('admin.file_upload_links.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Create New File Upload Link
        </a>

        <!-- Grouped Forms Table -->
        @php
            $grouped = $forms->groupBy('for_role');
        @endphp

        @forelse ($grouped as $role => $group)
        <div class=" w-full flex justify-center items-center mx-auto">
            <table class=" table-auto text-[10px] lg:text-base w-full border-collapse border border-gray-300">
                <caption class="text-lg font-semibold text-[#7D3C98] mb-4">
                    Created Forms for {{ ucfirst(str_replace('_', ' ', $role)) }}s
                </caption>
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-[10px] lg:text-base text-white">
                        <th class="border px-2 py-2">Name</th>
                        <th class="border w-1/2 px-4 py-2">Description (URL)</th>
                        <th class="border px-2 py-2">Form Type</th>
                        <th class="border px-2 py-2">Status</th>
                        <th class="border px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group as $form)
                        <tr class="text-[10px] lg:text-base hover:bg-gray-100 transition-colors duration-200">
                            <td class="border px-4 py-2">{{ $form->form_name }}</td>
                            <td class="border w-1/2 px-4 py-2 break-all">{{ $form->form_description }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($form->form_type) }}</td>
                            <td class="border px-4 py-2">
                                {{ $form->is_active ? 'Active' : 'Inactive' }}
                            </td>
                            <td class="flex-column border px-4 py-2 font-semibold items-left">
                                <a href="{{ route('admin.forms.edit', $form->id) }}" class="block text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.forms.destroy', $form->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this form?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @empty
            <p class="text-gray-600">No forms found.</p>
        @endforelse

        <!-- Upload Links Table -->
        <table class="w-full mt-6 table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">URL</th>
                    <th class="p-2 border">For Role</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uploadLinks as $fileUploadLink)
                    <tr class="border-t text-sm text-gray-800">
                        <td class="p-2">{{ $fileUploadLink->name }}</td>
                        <td class="p-2 break-all text-blue-600">
                            <a href="{{ $fileUploadLink->url }}" target="_blank">{{ $fileUploadLink->url }}</a>
                        </td>
                        <td class="p-2 capitalize">{{ str_replace('_', ' ', $fileUploadLink->for_role) }}</td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('admin.file_upload_links.edit', $fileUploadLink) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.file_upload_links.destroy', $fileUploadLink) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Are you sure you want to delete this upload link?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-layout>
