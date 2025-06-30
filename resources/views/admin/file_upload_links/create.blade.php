<x-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Create Upload Link</h2>

        <form action="{{ route('admin.file_upload_links.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold">Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold">URL</label>
                <input type="url" name="url" class="w-full border rounded p-2" value="{{ old('url') }}" required>
                @error('url') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold">For Role</label>
                <select name="for_role" class="w-full border rounded p-2" required>
                    <option value="">Select Role</option>
                    @foreach (['student', 'mentor', 'team_leader'] as $role)
                        <option value="{{ $role }}" {{ old('for_role') === $role ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
                @error('for_role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save</button>
        </form>
    </div>
</x-layout>
