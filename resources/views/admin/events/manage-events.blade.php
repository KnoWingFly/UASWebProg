@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-200">Manage Events</h1>
        <a href="{{ route('admin.events.create') }}"
            class="px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700">
            Create Event
        </a>
    </div>

    <!-- Event List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($events->isEmpty())
            <p class="text-gray-400 col-span-full">No events found. Start by creating one.</p>
        @else
            @foreach($events as $event)
                <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col">
                    <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover">
                    <div class="p-4 flex-grow">
                        <h2 class="text-xl font-semibold text-gray-200">{{ $event->name }}</h2>
                        <p class="text-gray-400 mt-2">Participants:
                            <span class="font-medium text-gray-300">
                                {{ $event->participants->count() }}/{{ $event->participant_limit }}
                            </span>
                        </p>
                        <p class="text-gray-400 mt-2">Registration Start:</p>
                        <p class="text-sm text-gray-300">
                            Date: <span
                                class="font-medium">{{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y') }}</span><br>
                            Time: <span
                                class="font-medium">{{ \Carbon\Carbon::parse($event->registration_start)->format('h:i A') }}</span>
                        </p>
                        <p class="text-gray-400 mt-2">Registration End:</p>
                        <p class="text-sm text-gray-300">
                            Date: <span
                                class="font-medium">{{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y') }}</span><br>
                            Time: <span
                                class="font-medium">{{ \Carbon\Carbon::parse($event->registration_end)->format('h:i A') }}</span>
                        </p>
                        <p class="text-gray-400 mt-2">Registration Status:</p>
                        <p class="text-sm text-gray-300">{{ $event->registration_status }}</p>

                    </div>
                    <div class="p-4 bg-gray-700 flex justify-between items-center space-x-2">
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                            Edit
                        </a>
                        <button onclick="openDeleteModal({{ $event->id }})"
                            class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Delete
                        </button>
                        <a href="{{ route('admin.events.participants', $event) }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                            Details
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-gray-800 rounded-lg p-6 space-y-4 w-96">
            <h2 class="text-xl font-semibold text-gray-200">Are you sure you want to delete this event?</h2>
            <div class="flex justify-between">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <form id="deleteForm" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(eventId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = '/admin/events/' + eventId; // Update the form action URL dynamically
        modal.classList.remove('hidden'); // Show the modal
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden'); // Hide the modal
    }
</script>
@endsection