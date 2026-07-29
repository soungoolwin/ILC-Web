<x-layout>
@if ($errors->any())
  <div class="mb-4 rounded-md bg-red-50 p-3 text-red-800 border border-red-200">
    <ul class="list-disc list-inside text-sm">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

    <div class="w-full bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit '{{ $semester->name }}'</h2>

        <form method="POST" action="{{ route('admin.semesters.update', $semester) }}">
            @csrf
            @method('PUT')
            @include('admin.semesters._form', ['prefill' => $semester])
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-[#7D3C98] text-white font-bold text-sm py-3 px-6 rounded-lg transition">
                    Save changes
                </button>
                <a href="{{ route('admin.semesters.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Back to semesters</a>
            </div>
        </form>
    </div>
</x-layout>
