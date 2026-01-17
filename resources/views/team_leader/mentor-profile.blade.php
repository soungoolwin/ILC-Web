<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
        <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-center">
                    <h1 class="text-xl font-semibold text-gray-900">Mentor Profile</h1>
                </div>
            </div>
        <div class="px-6 py-6">
                <!-- Profile Information -->
                <div class="space-y-6">
                    <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Name:</label>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200"><span>{{ $mentor->user->name }}</span></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nickname:</label>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200"><span>{{ $mentor->user->nickname }}</span></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Email:</label>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200"><span>{{ $mentor->user->email }}</span></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Line ID:</label>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200"><span>{{ $mentor->user->line_id ?? 'N/A' }}</span></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number:</label>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200"><span>{{ $mentor->user->phone_number ?? 'N/A' }}</span></div>
            </div>
        </div>
        </div>
</div>
    </div>
</div>
</x-layout>
