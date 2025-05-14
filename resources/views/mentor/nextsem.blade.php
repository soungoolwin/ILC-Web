<!-- filepath: /home/nastrona/Music/ILC-Web/resources/views/mentor/nextsem.blade.php -->
<x-layout>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 w-1/2">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Mentor Eligibility Check</h2>
        </div>
        <div id="profile-info" class="mt-6 space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-500">Current Semester Count:</label>
                <p class="text-lg font-semibold text-gray-800">{{ $mentor->mentor_sem }}</p>
            </div>
            <p class="text-gray-700 mt-4">Would you like to continue as a mentor for the next semester?</p>
            <div class="flex space-x-4 mt-6">
                <form action="{{ route('mentor.confirmNextSemester') }}" method="POST">
                    @csrf
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="btn btn-primary">Yes, I want to continue</button>
                </form>
                <form action="{{ route('mentor.confirmNextSemester') }}" method="POST">
                    @csrf
                    <input type="hidden" name="confirm" value="no">
                    <button type="submit" class="btn btn-danger">No, I do not want to continue</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>