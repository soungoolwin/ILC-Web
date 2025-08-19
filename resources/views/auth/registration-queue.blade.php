<x-guest-layout>
    <div class="max-w-md mx-auto mt-8">
        <x-queue-status :maxRegistrations="2" :position="$position" />

        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Registration Queue
            </h2>

            <div class="text-center">
                <p class="text-lg mb-4">
                    Your position in queue: <span class="font-bold">{{ $position }}</span>
                </p>

                <div class="mb-6 relative pt-1">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"
                             style="width: {{ min(100, ($position - cache()->get('next_in_queue', 1) + 1) * 20) }}%">
                        </div>
                    </div>
                </div>

                <p class="text-gray-600 text-sm mb-4">
                    Estimated wait time: {{ ($position - cache()->get('next_in_queue', 1) + 1) * 5 }} minutes
                </p>

                <div class="animate-pulse">
                    <div class="h-2 bg-blue-200 rounded"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshQueueStatus() {
            fetch('/check-queue-status')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'active') {
                        window.location.reload();
                    }
                });
        }

        setInterval(refreshQueueStatus, 5000);
    </script>
</x-guest-layout>