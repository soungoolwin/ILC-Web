<x-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $uploadLink->name }}</h2>

        <div class="space-y-4">
            <p><strong>URL:</strong> <a href="{{ $uploadLink->url }}" class="text-blue-600" target="_blank">{{ $uploadLink->url }}</a></p>
            <p><strong>For Role:</strong> {{ ucfirst(str_replace('_', ' ', $uploadLink->for_role)) }}</p>
        </div>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('admin.file_upload_links.edit', $uploadLink) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
            <a href="{{ route('admin.forms.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back</a>
        </div>
    </div>
</x-layout>
