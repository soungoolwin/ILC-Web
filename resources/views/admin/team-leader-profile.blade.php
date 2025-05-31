{{-- filepath: /home/nastrona/Music/ILC-Web/resources/views/admin/team-leader-profile.blade.php --}}
<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-100">

                    <h1 class="text-xl font-semibold text-gray-900">Team Leader Profile</h1>


            </div>



            <!-- Profile Content -->
            <div class="px-6 py-6">
                <!-- Profile Picture Section -->
                <div class="mb-8">
                    <!-- View Mode Profile Picture -->
                    <div id="view-profile-picture" class="flex justify-center mb-4">
                        <div class="relative">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200">
                                @if (optional($teamLeader)->teamleader_image)
                                    <img src="{{ asset('teamleader_image/' . $teamLeader->teamleader_image) }}" alt="Team Leader Image"
                                        class="w-full h-full rounded-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>

                <!-- View Mode -->
                <div id="view-mode" class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->user->name ?? 'John Leader' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->user->nickname ?? 'John' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Team Leader ID</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->team_leader_id ?? 'TL001' }}</span>
                            </div>
                        </div>
                        <!-- Faculty Display in View Mode -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->user->faculty ?? 'Not specified' }}</span>
                            </div>
                        </div>

                        <!-- Languages Display in View Mode -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Languages</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                @if(!empty($teamLeader->user->language) && !empty($teamLeader->user->level))
                                    @php
                                        $languages = explode(',', $teamLeader->user->language);
                                        $levels = explode(',', $teamLeader->user->level);
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
                                <span class="text-gray-900">{{ $teamLeader->user->email ?? 'johnleader@su.ac.th' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Line ID</label>
                            <div class="bg-blue-50 rounded-lg px-4 py-3 border-2 border-blue-200">
                                <span class="text-gray-900">{{ $teamLeader->user->line_id ?? 'leader123' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->user->phone_number ?? '0632222222' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode Form -->
                <form id="edit-mode" method="POST" action="{{ route('team_leader.update') }}" enctype="multipart/form-data" class="hidden space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input for profile picture -->
                    <input type="file" name="profile_picture" id="profile-picture-form-input" class="hidden">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $teamLeader->user->name ?? 'John Leader') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nickname" class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                        <input type="text" name="nickname" id="nickname"
                               value="{{ old('nickname', $teamLeader->user->nickname ?? 'John') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('nickname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="team_leader_id" class="block text-sm font-medium text-gray-500 mb-1">Team Leader ID</label>
                        <input type="text" name="team_leader_id" id="team_leader_id"
                               value="{{ old('team_leader_id', $teamLeader->team_leader_id ?? 'TL001') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('team_leader_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Faculty Field in Edit Mode -->
                    <div>
                        <label for="faculty" class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                        <input type="text" name="faculty" id="faculty"
                               value="{{ old('faculty', $student->faculty ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('faculty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Language Field in Edit Mode -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-500 mb-1">Languages (comma-separated)</label>
                        <input type="text" name="language" id="language"
                               value="{{ old('language', $student->language ?? '') }}"
                               placeholder="English,Burmese"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Example: English,Burmese</p>
                        @error('language')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Level Field in Edit Mode -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-500 mb-1">Proficiency Levels (comma-separated)</label>
                        <input type="text" name="level" id="level"
                               value="{{ old('level', $student->level ?? '') }}"
                               placeholder="B2,Native"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Example: B2,Native (match the order of your languages)</p>
                        @error('level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $teamLeader->user->email ?? 'johnleader@su.ac.th') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="line_id" class="block text-sm font-medium text-gray-500 mb-1">Line ID</label>
                        <input type="text" name="line_id" id="line_id"
                               value="{{ old('line_id', $teamLeader->user->line_id ?? 'leader123') }}"
                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-blue-50">
                        @error('line_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $teamLeader->user->phone_number ?? '0632222222') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Update Section -->
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Update Password</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-500 mb-1">Current Password</label>
                                <input type="password" name="current_password" id="current_password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-500 mb-1">New Password</label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-500 mb-1">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
