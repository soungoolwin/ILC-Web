<x-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h2 class="text-xl font-bold mb-4">Edit Upload Link</h2>

        <form action="{{ route('admin.file_upload_links.update', $fileUploadLink) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" value="{{ old('name', $fileUploadLink->name) }}" required>
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold">URL</label>
                <input type="url" name="url" class="w-full border rounded p-2" value="{{ old('url', $fileUploadLink->url) }}" required>
                @error('url') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-semibold">For Role</label>
                <select name="for_role" class="w-full border rounded p-2" required>
                    @foreach (['student', 'mentor', 'team_leader'] as $role)
                        <option value="{{ $role }}" {{ $fileUploadLink->for_role === $role ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role)) }}
                        </option>
                    @endforeach
                </select>
                @error('for_role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </form>
    </div>
</x-layout>
