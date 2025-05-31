<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900">Team Leader Profile</h1>
                    <button id="edit-toggle-btn" class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                        <span id="edit-btn-text">Edit</span>
                    </button>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mx-6 mt-4 rounded">
                    <div class="text-green-700 text-sm">{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mx-6 mt-4 rounded">
                    <div class="text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Profile Content -->
            <div class="px-6 py-6">
                <!-- Profile Picture Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Profile Picture</h3>
                    
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

                    <!-- Edit Mode Profile Picture Upload -->
                    <div id="edit-profile-picture" class="hidden">
                        <div class="flex justify-center mb-4">
                            <div class="relative">
                                <div id="profile-picture-container" class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                                    @if (optional($teamLeader)->teamleader_image)
                                        <img id="profile-image" src="{{ asset('teamleader_image/' . $teamLeader->teamleader_image) }}" alt="Team Leader Image" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <svg id="camera-icon" class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <input type="file" id="profile-picture-input" accept="image/*" class="hidden">
                            </div>
                        </div>

                        <!-- Separate Upload Form for Profile Picture -->
                        <form method="POST" action="{{ route('team_leader.image.upload') }}" enctype="multipart/form-data" class="flex flex-col items-center space-y-3">
                            @csrf
                            <div class="flex items-center space-x-2 w-full max-w-sm">
                                <input type="file" name="teamleader_image" accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border file:border-gray-300 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 transition-colors">
                                <button type="submit"
                                    class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 whitespace-nowrap">
                                    Upload
                                </button>
                            </div>
                            @error('teamleader_image')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>

                <!-- View Mode -->
                <div id="view-mode" class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->name ?? 'John Leader' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->nickname ?? 'John' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Team Name</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->team_name ?? 'Team Alpha' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Team Description</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $teamLeader->team_description ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->email ?? 'johnleader@su.ac.th' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->phone_number ?? '0631111111' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode Form -->
                <form id="edit-mode" method="POST" action="{{ route('team_leader.update') }}" enctype="multipart/form-data" class="hidden space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name ?? 'John Leader') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nickname" class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                        <input type="text" name="nickname" id="nickname"
                               value="{{ old('nickname', $user->nickname ?? 'John') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('nickname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="team_name" class="block text-sm font-medium text-gray-500 mb-1">Team Name</label>
                        <input type="text" name="team_name" id="team_name"
                               value="{{ old('team_name', $teamLeader->team_name ?? 'Team Alpha') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('team_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="team_description" class="block text-sm font-medium text-gray-500 mb-1">Team Description</label>
                        <textarea name="team_description" id="team_description"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">{{ old('team_description', $teamLeader->team_description ?? 'N/A') }}</textarea>
                        @error('team_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $user->email ?? 'johnleader@su.ac.th') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $user->phone_number ?? '0631111111') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    <div class="pt-6">
                        <button type="submit"
                                class="w-full bg-gray-400 hover:bg-gray-500 text-white font-medium py-3 px-4 rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editToggleBtn = document.getElementById('edit-toggle-btn');
            const editBtnText = document.getElementById('edit-btn-text');
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            const viewProfilePicture = document.getElementById('view-profile-picture');
            const editProfilePicture = document.getElementById('edit-profile-picture');
            const profilePictureContainer = document.getElementById('profile-picture-container');
            const profilePictureInput = document.getElementById('profile-picture-input');
            const profileImage = document.getElementById('profile-image');
            const cameraIcon = document.getElementById('camera-icon');

            let isEditMode = false;

            // Toggle between view and edit mode
            editToggleBtn.addEventListener('click', function() {
                isEditMode = !isEditMode;

                if (isEditMode) {
                    viewMode.classList.add('hidden');
                    editMode.classList.remove('hidden');
                    viewProfilePicture.classList.add('hidden');
                    editProfilePicture.classList.remove('hidden');
                    editBtnText.textContent = 'Cancel';
                } else {
                    viewMode.classList.remove('hidden');
                    editMode.classList.add('hidden');
                    viewProfilePicture.classList.remove('hidden');
                    editProfilePicture.classList.add('hidden');
                    editBtnText.textContent = 'Edit';
                }
            });

            // Profile picture upload handling (only in edit mode)
            if (profilePictureContainer) {
                profilePictureContainer.addEventListener('click', function(e) {
                    if (isEditMode) {
                        profilePictureInput.click();
                    }
                });
            }

            // Handle file selection for preview
            if (profilePictureInput) {
                profilePictureInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Preview the image
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (profileImage) {
                                profileImage.src = e.target.result;
                            } else {
                                // Create new image element if it doesn't exist
                                const img = document.createElement('img');
                                img.id = 'profile-image';
                                img.src = e.target.result;
                                img.alt = 'Profile Picture';
                                img.className = 'w-full h-full rounded-full object-cover';

                                // Hide camera icon and show image
                                if (cameraIcon) {
                                    cameraIcon.style.display = 'none';
                                }
                                profilePictureContainer.appendChild(img);
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-layout>