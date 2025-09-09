{{-- resources/views/admin/attendance/index.blade.php --}}
<x-layout>
    <div class="max-w-5xl mx-auto p-6">
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Attendance CSV Preview 📥</h1>

        <form action="{{ route('admin.attendance.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="csv" accept=".csv" class="block w-full border rounded p-2">
            @error('csv') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Preview</button>
        </form>
    </div>
</x-layout>
