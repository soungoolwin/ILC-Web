<x-layout>
    <div class="min-h-screen bg-gray-50 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-white px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900">Your Profile</h1>
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
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div id="profile-picture-container" class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            @if(isset($user->profile_picture) && $user->profile_picture)
                                <img id="profile-image" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-full h-full rounded-full object-cover">
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

                <!-- View Mode -->
                <div id="view-mode" class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->name ?? 'John Doe' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nickname</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->nickname ?? 'John' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Student ID</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->student_id ?? '65000000' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->email ?? 'johndoe.s65@su.ac.th' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Line ID</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border-2 border-gray-200">
                                <span class="text-gray-900">{{ $user->line_id ?? 'id12345' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $user->phone_number ?? '0630000000' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->faculty ?? 'ICT' }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Language Level</label>
                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                <span class="text-gray-900">{{ $student->language_level ?? 'ICT' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode Form -->
                <form id="edit-mode" method="POST" action="{{ route('student.update') }}" enctype="multipart/form-data" class="hidden space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Hidden input for profile picture -->
                    <input type="file" name="profile_picture" id="profile-picture-form-input" class="hidden">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name', $user->name ?? 'John Doe') }}"
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
                        <label for="student_id" class="block text-sm font-medium text-gray-500 mb-1">Student ID</label>
                        <input type="text" name="student_id" id="student_id"
                               value="{{ old('student_id', $student->student_id ?? '65000000') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('student_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', $user->email ?? 'johndoe.s65@su.ac.th') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="line_id" class="block text-sm font-medium text-gray-500 mb-1">Line ID</label>
                        <input type="text" name="line_id" id="line_id"
                               value="{{ old('line_id', $user->line_id ?? 'id12345') }}"
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors ">
                        @error('line_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $user->phone_number ?? '0630000000') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('phone_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="faculty" class="block text-sm font-medium text-gray-500 mb-1">Faculty</label>
                        <input type="text" name="faculty" id="faculty"
                               value="{{ old('faculty', $student->faculty ?? 'ICT') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('faculty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="language_level" class="block text-sm font-medium text-gray-500 mb-1">Language Level</label>
                        <input type="text" name="language_level" id="language_level"
                               value="{{ old('language_level', $student->language_level ?? 'ICT') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        @error('language_level')
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
                                class="w-full bg-gray-400 hover:bg-gray-500 text-white font-medium py-3 px-4 rounded-lg transition-colors focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Save
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
            const profilePictureContainer = document.getElementById('profile-picture-container');
            const profilePictureInput = document.getElementById('profile-picture-input');
            const profilePictureFormInput = document.getElementById('profile-picture-form-input');
            const profileImage = document.getElementById('profile-image');
            const cameraIcon = document.getElementById('camera-icon');

            let isEditMode = false;

            // Toggle between view and edit mode
            editToggleBtn.addEventListener('click', function() {
                isEditMode = !isEditMode;

                if (isEditMode) {
                    viewMode.classList.add('hidden');
                    editMode.classList.remove('hidden');
                    editBtnText.textContent = 'Cancel';
                } else {
                    viewMode.classList.remove('hidden');
                    editMode.classList.add('hidden');
                    editBtnText.textContent = 'Edit';
                }
            });

            // Profile picture upload handling
            profilePictureContainer.addEventListener('click', function() {
                if (isEditMode) {
                    profilePictureInput.click();
                }
            });

            profilePictureInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Update the form input
                    profilePictureFormInput.files = e.target.files;

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

            // Update cursor style based on mode
            function updateProfilePictureCursor() {
                if (isEditMode) {
                    profilePictureContainer.style.cursor = 'pointer';
                } else {
                    profilePictureContainer.style.cursor = 'default';
                }
            }

            // Initial cursor setup
            updateProfilePictureCursor();

            // Update cursor when mode changes
            const originalToggleClick = editToggleBtn.onclick;
            editToggleBtn.addEventListener('click', function() {
                setTimeout(updateProfilePictureCursor, 0);
            });
        });
    </script>
</x-layout>
