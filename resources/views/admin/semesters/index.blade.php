<x-layout>
@if (session('success'))
  <div class="mb-4 rounded-md bg-green-50 p-3 text-green-800 border border-green-200">
    {{ session('success') }}
  </div>
@endif

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
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Start a New Semester</h2>

        <form method="POST" action="{{ route('admin.semesters.store') }}" class="mb-8">
            @csrf
            @include('admin.semesters._form', ['prefill' => $defaults])
            <button type="submit" class="bg-[#7D3C98] text-white font-bold text-sm py-3 px-6 rounded-lg transition">
                Start new semester
            </button>
            <p class="text-xs text-gray-500 mt-2">Starting a new semester creates a new row and makes it current &mdash; nothing is deleted. Limits above are prefilled from the current semester; adjust as needed.</p>
        </form>

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Semesters</h2>

        @if ($semesters->count() > 0)
        <div class="w-full flex justify-center items-center mx-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-[10px] lg:text-base">
                        <th class="border border-gray-300 px-2 py-2">Name</th>
                        <th class="border border-gray-300 px-2 py-2">Start Date</th>
                        <th class="border border-gray-300 px-2 py-2">End Date</th>
                        <th class="border border-gray-300 px-2 py-2">Status</th>
                        <th class="border border-gray-300 px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semesters as $semester)
                    <tr class="text-center text-xs lg:text-sm">
                        <td class="border border-gray-300 px-2 py-2">{{ $semester->name }}</td>
                        <td class="border border-gray-300 px-2 py-2">{{ $semester->start_date->format('Y-m-d') }}</td>
                        <td class="border border-gray-300 px-2 py-2">{{ $semester->end_date->format('Y-m-d') }}</td>
                        <td class="border border-gray-300 px-2 py-2">
                            @if ($semester->is_current)
                                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Current</span>
                            @else
                                <span class="text-gray-400">Past</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-2 py-2 space-x-3">
                            <a href="{{ route('admin.semesters.edit', $semester) }}" class="text-[#7D3C98] font-semibold hover:underline">Edit limits</a>
                            @unless ($semester->is_current)
                            <form method="POST" action="{{ route('admin.semesters.activate', $semester) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-[#7D3C98] font-semibold hover:underline">Make current</button>
                            </form>
                            @endunless
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500">No semesters yet.</p>
        @endif
    </div>
</x-layout>
