
@props(['maxRegistrations', 'position'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold mb-4">Registration Queue Status</h3>
    
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="bg-gray-50 p-3 rounded">
            <span class="font-medium">Active Registrations:</span>
            <span class="ml-2">{{ cache()->get('active_registrations', 0) }}/{{ $maxRegistrations }}</span>
        </div>
        
        <div class="bg-gray-50 p-3 rounded">
            <span class="font-medium">Users Ahead of You:</span>
            <span class="ml-2">
                {{ max(0, $position - cache()->get('next_in_queue', 1)) }}
            </span>
        </div>
    </div>
</div>