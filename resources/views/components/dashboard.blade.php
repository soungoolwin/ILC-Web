<x-layout>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-6">
            {{ session('success') }}
        </div>
    @endif
    <h1>This is Dashboard for all users</h1>
</x-layout>
