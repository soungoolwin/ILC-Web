<x-layout>
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Forms Management</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.forms.index') }}" class="flex space-x-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-600">Form Type</label>
                <select name="form_type" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Types</option>
                    @foreach(['pretest', 'posttest', 'questionnaire', 'consent'] as $type)
                        <option value="{{ $type }}" {{ request('form_type') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600">For Role</label>
                <select name="for_role" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">All Roles</option>
                    @foreach(['student', 'mentor', 'team_leader'] as $role)
                        <option value="{{ $role }}" {{ request('for_role') === $role ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filter</button>
            </div>
        </form>

        <!-- Create New Form Button -->
        <a href="{{ route('admin.forms.create') }}"
            class="bg-green-600 text-white px-4 py-2 rounded-lg inline-block mb-4">
            Create New Form
        </a>

        <!-- Grouped Forms Table -->
        @php
            $grouped = $forms->groupBy('for_role');
        @endphp

        @forelse ($grouped as $role => $group)
            <h3 class="text-xl font-semibold text-purple-700 mt-6 mb-2">
                {{ ucfirst(str_replace('_', ' ', $role)) }}
            </h3>

            <table class="w-full table-auto border border-gray-300 mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Description (URL)</th>
                        <th class="border px-4 py-2">Form Type</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group as $form)
                        <tr>
                            <td class="border px-4 py-2">{{ $form->form_name }}</td>
                            <td class="border px-4 py-2">{{ $form->form_description }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($form->form_type) }}</td>
                            <td class="border px-4 py-2">
                                {{ $form->is_active ? 'Active' : 'Inactive' }}
                            </td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('admin.forms.edit', $form->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.forms.destroy', $form->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this form?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @empty
            <p class="text-gray-600">No forms found.</p>
        @endforelse
    </div>
</x-layout>
