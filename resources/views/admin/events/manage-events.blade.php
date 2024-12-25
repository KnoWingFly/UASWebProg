@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-200">Manage Events</h1>
        <!-- Search Bar and Filter -->
        <div class="flex space-x-4">
            <input type="text" id="search-bar" placeholder="Search events..."
                class="px-4 py-2 rounded bg-[#1a1a1a] text-white placeholder-gray-400 focus:ring focus:ring-indigo-500">
            <select id="status-filter"
                class="px-4 py-2 rounded bg-[#1a1a1a] text-white focus:ring focus:ring-indigo-500">
                <option value="all">All</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        <div>
            <a href="{{ route('admin.events.create') }}"
                class="px-4 py-2 bg-[#ff4d4d] text-white font-medium rounded hover:bg-[#e13e3e] transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                Create Event
            </a>
            <a href="/admin/dashboard" class="mx-2 px-4 py-2 bg-[#ff4d4d] text-white font-medium rounded hover:bg-[#e13e3e] transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Event List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($events->isEmpty())
            <p class="text-gray-400 col-span-full">No events found. Start by creating one.</p>
        @else
            @foreach($events as $event)
                <div class="bg-[#1a1a1a] rounded-lg shadow-md overflow-hidden flex flex-col event-card w-full max-w-xs mx-auto"
                    data-event-name="{{ $event->name }}">
                    <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" class="w-full h-40 object-cover">
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
                    <div class="p-4 bg-[#151515] flex justify-between items-center space-x-2">
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="px-4 py-2 bg-[#ff4d4d] text-white text-sm rounded hover:bg-[#e13e3e] transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                            Edit
                        </a>
                        <button onclick="openDeleteModal({{ $event->id }})"
                            class="px-4 py-2 bg-[#e13e3e] text-white text-sm rounded hover:bg-[#ff4d4d] transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                            Delete
                        </button>
                        <a href="{{ route('admin.events.participants', $event) }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
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
        <div class="bg-[#1a1a1a] rounded-lg p-6 space-y-4 w-96">
            <h2 class="text-xl font-semibold text-gray-200">Are you sure you want to delete this event?</h2>
            <div class="flex justify-between">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <form id="deleteForm" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-[#ff4d4d] text-white rounded hover:bg-[#e13e3e] transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
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
        form.action = '/admin/events/' + eventId;
        modal.classList.remove('hidden'); // Show the modal
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }
    document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('search-bar');
    const statusFilter = document.getElementById('status-filter');
    const eventCards = document.querySelectorAll('.event-card');

    function normalizeText(text) {
        return text.toLowerCase().trim();
    }

    function filterEvents() {
        const query = normalizeText(searchBar.value);
        const status = statusFilter.value;
        let visibleCardCount = 0;

        eventCards.forEach(card => {
            // Extract event name
            const eventName = normalizeText(card.getAttribute('data-event-name') || '');

            // Extract registration status
            const registrationStatusElement = card.querySelector('p:last-of-type');
            const eventStatus = registrationStatusElement ? 
                normalizeText(registrationStatusElement.textContent.replace('Registration Status:', '').trim()) : 
                '';

            const matchesSearch = eventName.includes(query);
            const matchesStatus = 
                status === 'all' || 
                (status === 'open' && eventStatus.includes('open')) ||
                (status === 'closed' && eventStatus.includes('closed'));

            if (matchesSearch && matchesStatus) {
                card.style.display = 'flex';
                visibleCardCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Handle no results message
        const gridContainer = document.querySelector('.grid');
        const existingNoResultsMessage = gridContainer.querySelector('.no-results-message');

        if (visibleCardCount === 0) {
            if (!existingNoResultsMessage) {
                const noResultsMessage = document.createElement('p');
                noResultsMessage.classList.add('text-gray-400', 'col-span-full', 'no-results-message');
                noResultsMessage.textContent = 'No events found matching your search and filter criteria.';
                gridContainer.appendChild(noResultsMessage);
            }
        } else if (existingNoResultsMessage) {
            existingNoResultsMessage.remove();
        }
    }

    searchBar.addEventListener('input', filterEvents);
    statusFilter.addEventListener('change', filterEvents);
});
</script>
@endsection
