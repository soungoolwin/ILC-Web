{{-- resources/views/admin/attendance/index.blade.php --}}
<x-layout>
    <div class="max-w-5xl mx-auto p-6">
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">Upload Attendance Files 📤</h1>
        <p class="text-gray-600 mb-6">Please upload both the check-in and check-out CSV files to process the attendance records.</p>

        <form action="{{ route('admin.attendance.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-6 border p-6 rounded-lg shadow-sm bg-white">
            @csrf
            
            {{-- Check-in File Input --}}
            <div>
                <label for="check_in_csv" class="block font-semibold text-gray-700 mb-2">1. Check-in File</label>
                <input type="file" name="check_in_csv" id="check_in_csv" accept=".csv,text/csv" required
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                @error('check_in_csv') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Check-out File Input --}}
            <div>
                <label for="check_out_csv" class="block font-semibold text-gray-700 mb-2">2. Check-out File</label>
                <input type="file" name="check_out_csv" id="check_out_csv" accept=".csv,text/csv" required
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-green-50 file:text-green-700
                              hover:file:bg-green-100">
                @error('check_out_csv') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Process Attendance
            </button>
        </form>
    </div>
</x-layout>