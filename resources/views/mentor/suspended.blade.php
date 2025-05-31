<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 w-1/2">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Profile Information</h2>
        </div>
        <div id="profile-info" class="mt-6 space-y-4 ">
            <div>
                <label class="text-sm font-medium text-gray-500">Mentor Sem:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->mentor_sem}}</p>
            </div>
        </div>
    </div>
</x-layout>
