<x-layout>
    {{-- Flash: success --}}
@if (session('success'))
  <div class="mb-4 rounded-md bg-green-50 p-3 text-green-800 border border-green-200">
    {{ session('success') }}
  </div>
@endif

{{-- Flash: error (string) --}}
@if (session('error'))
  <div class="mb-4 rounded-md bg-red-50 p-3 text-red-800 border border-red-200">
    {{ session('error') }}
  </div>
@endif

{{-- Validation / withErrors bag --}}
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
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Delete Users</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-2 mb-6">
            <div class="flex items-left space-x-4">
                <div>
                    <label for="email" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">Search by User Email</label>
                    <input type="text" name="email" id="email" value="{{ $request->email }}"
                        placeholder="Enter User Email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
                <div>
                    <label for="student_id" class="block text-xs lg:text-md ml-2 mb-2 font-semibold text-gray-600">Search by Student ID</label>
                    <input type="text" name="student_id" id="student_id" value="{{ $request->student_id }}"
                        placeholder="Enter Student ID"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm transition">
                </div>
                <div>
                    <button type="submit" class="block mt-6 w-full bg-[#7D3C98] text-white font-bold text-xs lg:text-sm py-3 px-4 rounded-lg transition">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Display Users -->
        @if ($users->count() > 0)
        <div class="w-full flex justify-center items-center mx-auto" >
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-[#7D3C98] text-white rounded-xl shadow-md">
                    <tr class="text-[10px] lg:text-base">
                        <th class="border border-gray-300 px-2 py-2">User ID</th>
                        <th class="border border-gray-300 px-2 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2 min-w-[150px]">Email</th>
                        <th class="border border-gray-300 px-4 py-2 min-w-[100px]">Role</th>
                        <th class="border border-gray-300 px-2 py-2 min-w-[100px]">Student ID</th>
                        <th class="border border-gray-300 px-2 py-2 min-w-[100px]">Line ID</th>

                        <!-- <th class="border border-gray-300 px-2 py-2">Phone Number</th> -->
                        <th class="border border-gray-300 px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->sortBy('id') as $user)
                        <tr class="text-[10px] lg:text-base hover:bg-gray-100 transition-colors duration-200">
                            <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->id }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $user->email }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $user->role }}</td>
                            <td class="border border-gray-300 px-2 py-2 text-center"> 
                                @if($user->role === 'student')
                                    {{ $user->students->first()->student_id ?? 'N/A' }}
                                @elseif($user->role === 'mentor')
                                    {{ $user->mentors->first()->mentor_id ?? 'N/A' }}
                                @elseif($user->role === 'team_leader')
                                    {{ $user->teamLeaders->first()->team_leader_id ?? 'N/A' }}
                                @elseif($user->role === 'admin')
                                    {{ $user->admins->first()->admin_id ?? 'N/A' }}
                                    
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-2 text-center"> {{ $user->line_id ?? 'N/A' }} </td>
                                
                            <td class="border border-gray-300 px-2 py-2 text-center">
                                <form method="POST"
                                    action="{{ route('admin.users.delete', $user->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-xs lg:text-sm text-white px-2 py-1 rounded-lg hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">No user found matching the search criteria.</p>
        @endif
    </div>
</x-layout>
