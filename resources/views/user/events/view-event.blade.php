@extends('layouts.user')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-200">Available Events</h1>
        <!-- Search Bar and Filter -->
        <div class="flex space-x-4">
            <input type="text" id="search-bar" placeholder="Search events..."
                class="px-4 py-2 rounded bg-gray-700 text-white placeholder-gray-400 focus:ring focus:ring-indigo-500">
            <select id="status-filter"
                class="px-4 py-2 rounded bg-gray-700 text-white focus:ring focus:ring-indigo-500">
                <option value="all">All</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>
    </div>

    <!-- Event List -->
    <div id="event-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($events->isEmpty())
            <p class="text-gray-400 col-span-full">No events found. Please check back later.</p>
        @else
            @foreach($events as $event)
                <div data-event-name="{{ strtolower($event->name) }}" 
                     data-event-status="{{ $event->registration_status }}" 
                     class="event-card bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col 
                                                                @if($user->eventUsers->contains($event)) border-2 border-green-500 @endif">
                    <!-- Event Banner -->
                    <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover">

                    <!-- Event Details -->
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
                        <p class="text-sm text-gray-300">
                            @if($event->registration_status === 'open')
                                <span class="text-green-400">Open</span>
                            @else
                                <span class="text-red-400">Closed</span>
                            @endif
                        </p>

                        @if($user->eventUsers->contains($event))
                            <p class="mt-2 text-green-400 text-sm font-semibold">You are already registered for this event.</p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 bg-gray-700 flex justify-center space-x-2">
                        <a href="{{ route('user.event.details', $event) }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                            View Details
                        </a>

                        @if($user->eventUsers->contains($event))
                            <form action="{{ route('user.cancel_registration', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                    Cancel Registration
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchBar = document.getElementById('search-bar');
        const statusFilter = document.getElementById('status-filter');
        const eventCards = document.querySelectorAll('.event-card');

        function filterEvents() {
            const query = searchBar.value.toLowerCase().trim();
            const status = statusFilter.value;

            let visibleCardCount = 0;

            eventCards.forEach(card => {
                const eventName = card.getAttribute('data-event-name')?.toLowerCase() || '';
                const eventStatus = card.getAttribute('data-event-status') || 'all';

                const matchesSearch = eventName.includes(query);
                const matchesStatus = status === 'all' || eventStatus === status;

                if (matchesSearch && matchesStatus) {
                    card.style.display = 'block';
                    visibleCardCount++;
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchBar.addEventListener('input', filterEvents);
        statusFilter.addEventListener('change', filterEvents);
    });
</script>
@endsection
