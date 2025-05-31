<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-center">
                    <h1 class="text-xl font-semibold text-gray-900">Student Profile</h1>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="px-6 py-6">
                <!-- Profile Information -->
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->user->name ?? 'Student Name' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->user->nickname ?? 'Student' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Student ID</label>
                            <div class="bg-green-50 rounded-lg px-4 py-3 border-2 border-green-200">
                                <span class="text-gray-900">{{ $student->student_id ?? '65000000' }}</span>
                            </div>
                        </div>
                        <!-- Faculty Display in View Mode -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->user->faculty ?? 'Not specified' }}</span>
                            </div>
                        </div>

                        <!-- Languages Display in View Mode -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Languages</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                @if(!empty($student->user->language) && !empty($student->user->level))
                                    @php
                                        $languages = explode(',', $student->user->language);
                                        $levels = explode(',', $student->user->level);
                                    @endphp
                                    @foreach($languages as $index => $language)
                                        <div class="flex justify-between items-center py-1">
                                            <span class="text-gray-900">{{ $language }}</span>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ isset($levels[$index]) ? $levels[$index] : '' }}
                                            </span>
                                        </div>
                                        @if(!$loop->last)<hr class="my-1">@endif
                                    @endforeach
                                @else
                                    <span class="text-gray-500 italic">No languages specified</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->user->email ?? 'student@su.ac.th' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Line ID</label>
                            <div class="bg-blue-50 rounded-lg px-4 py-3 border-2 border-blue-200">
                                <span class="text-gray-900">{{ $student->user->line_id ?? 'student123' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->user->phone_number ?? '0630000000' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
