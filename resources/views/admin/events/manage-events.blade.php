@extends('layouts.admin')

@section('content')
<div class="p-3 sm:p-6 space-y-4 sm:space-y-6 opacity-0" id="mainContent">
    
    <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:justify-between sm:items-center">
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-200 translate-y-4 opacity-0" id="pageTitle">Manage Events</h1>
        
        <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4 translate-y-4 opacity-0 w-full sm:w-auto" id="controls">
            <input type="text" id="search-bar" placeholder="Search events..."
                class="w-full sm:w-64 px-4 py-2 rounded bg-[#1a1a1a] text-white placeholder-gray-400 border border-transparent focus:border-[#ff4d4d] transition-colors duration-300">
            <select id="status-filter"
                class="w-full sm:w-32 px-4 py-2 rounded bg-[#1a1a1a] text-white border border-transparent focus:border-[#ff4d4d] transition-colors duration-300">
                <option value="all">All</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        <div class="translate-y-4 opacity-0" id="actionButtons">
            <a href="{{ route('admin.events.create') }}"
                class="px-4 py-2 bg-[#ff4d4d] text-white font-medium rounded hover:bg-opacity-90 transition-all duration-300 inline-block hover:-translate-y-1">
                Create Event
            </a>
            <a href="/admin/dashboard" 
                class="mx-2 px-4 py-2 bg-blue-500 text-white font-medium rounded hover:bg-opacity-90 transition-all duration-300 inline-block hover:-translate-y-1">
                Back to Dashboard
        </a>
        </div>
    </div>

    <!-- Event List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="eventGrid">
        @if($events->isEmpty())
            <p class="text-gray-400 col-span-full opacity-0" id="noEventsMessage">No events found. Start by creating one.</p>
        @else
            @foreach($events as $event)
                <div class="bg-[#1a1a1a] rounded-lg shadow-md overflow-hidden flex flex-col event-card w-full max-w-xs mx-auto opacity-0 scale-95"
                    data-event-name="{{ $event->name }}" data-event-status="{{ strtolower($event->registration_status) }}">
                    <div class="relative overflow-hidden">
                        <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" 
                            class="w-full h-40 object-cover transform hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#151515] to-transparent opacity-60"></div>
                    </div>
                    <div class="p-4 flex-grow bg-gradient-to-b from-[#1a1a1a] to-[#151515]">
                        <h2 class="text-xl font-semibold text-gray-200 mb-3">{{ $event->name }}</h2>
                        <div class="space-y-2">
                            <p class="text-gray-400">Participants: 
                                <span class="font-medium text-[#ff4d4d]">
                                    {{ $event->participants->count() }}/{{ $event->participant_limit }}
                                </span>
                            </p>
                            <div class="text-gray-400">
                                <p class="mb-1">Registration Period:</p>
                                <div class="text-sm text-gray-300 ml-2 border-l-2 border-[#ff4d4d] pl-2">
                                    <p>Start: {{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y, h:i A') }}</p>
                                    <p>End: {{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            <p class="text-gray-400">Status: 
                                <span class="font-medium {{ $event->registration_status === 'Open' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ $event->registration_status }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-[#151515] flex justify-between items-center space-x-2">
                        <a href="{{ route('admin.events.edit', $event) }}"
                            class="px-4 py-2 bg-[#ff4d4d] text-white text-sm rounded hover:bg-opacity-90 transition-all duration-300 hover:-translate-y-1">
                            Edit
                        </a>
                        <button onclick="openDeleteModal({{ $event->id }})"
                            class="px-4 py-2 bg-[#e13e3e] text-white text-sm rounded hover:bg-opacity-90 transition-all duration-300 hover:-translate-y-1">
                            Delete
                        </button>
                        <a href="{{ route('admin.events.participants', $event) }}"
                            class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-opacity-90 transition-all duration-300 hover:-translate-y-1">
                            Details
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4 opacity-0" id="pagination">
        {{ $events->links() }}
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-[#1a1a1a] rounded-lg p-6 space-y-4 w-96 scale-95 opacity-0" id="modalContent">
            <h2 class="text-xl font-semibold text-gray-200">Are you sure you want to delete this event?</h2>
            <div class="flex justify-between">
                <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-opacity-90 transition-all duration-300">
                    Cancel
                </button>
                <form id="deleteForm" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-4 py-2 bg-[#ff4d4d] text-white rounded hover:bg-opacity-90 transition-all duration-300">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initial animations
    gsap.to('#mainContent', {
        opacity: 1,
        duration: 0.5,
        ease: 'power2.out'
    });

    gsap.to(['#pageTitle', '#controls', '#actionButtons'], {
        opacity: 1,
        y: 0,
        duration: 0.5,
        stagger: 0.1,
        ease: 'power2.out'
    });

    // Animate event cards
    gsap.to('.event-card', {
        opacity: 1,
        scale: 1,
        duration: 0.5,
        stagger: 0.1,
        ease: 'power2.out'
    });

    // Animate pagination
    gsap.to('#pagination', {
        opacity: 1,
        duration: 0.5,
        delay: 0.5
    });

    // Search and filter functionality
    const searchBar = document.getElementById('search-bar');
    const statusFilter = document.getElementById('status-filter');
    const eventGrid = document.getElementById('eventGrid');
    const eventCards = document.querySelectorAll('.event-card');

    function normalizeText(text) {
        return text.toLowerCase().trim();
    }

    function animateFilteredCards(cards, show) {
        gsap.to(cards, {
            opacity: show ? 1 : 0,
            scale: show ? 1 : 0.95,
            duration: 0.3,
            ease: 'power2.out',
            stagger: show ? 0.1 : 0
        });
    }

    function filterEvents() {
        const query = normalizeText(searchBar.value);
        const status = statusFilter.value;
        let visibleCards = [];
        let hiddenCards = [];

        eventCards.forEach(card => {
            const eventName = normalizeText(card.getAttribute('data-event-name') || '');
            const eventStatus = card.getAttribute('data-event-status') || '';

            const matchesSearch = eventName.includes(query);
            const matchesStatus = status === 'all' || status === eventStatus;

            if (matchesSearch && matchesStatus) {
                visibleCards.push(card);
            } else {
                hiddenCards.push(card);
            }
        });

        // Hide all cards
        animateFilteredCards(hiddenCards, false);

        // Show only visible cards and fill empty spaces
        animateFilteredCards(visibleCards, true);

        // Rearrange the grid
        gsap.to(eventGrid, {
            duration: 0.5,
            ease: 'power2.out',
            onComplete: () => {
                visibleCards.forEach(card => card.style.display = 'block');
                hiddenCards.forEach(card => card.style.display = 'none');
            }
        });
    }

    searchBar.addEventListener('input', filterEvents);
    statusFilter.addEventListener('change', filterEvents);
});

function openDeleteModal(eventId) {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    const form = document.getElementById('deleteForm');
    form.action = '/admin/events/' + eventId;
    
    modal.classList.remove('hidden');
    gsap.to(modalContent, {
        opacity: 1,
        scale: 1,
        duration: 0.3,
        ease: 'power2.out'
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    
    gsap.to(modalContent, {
        opacity: 0,
        scale: 0.95,
        duration: 0.3,
        ease: 'power2.in',
        onComplete: () => {
            modal.classList.add('hidden');
            modalContent.style.opacity = 0;
            modalContent.style.transform = 'scale(0.95)';
        }
    });
}
</script>
@endsection