@extends('layouts.user')

@section('content')
<div class="p-6 space-y-6 bg-[#151515]">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 opacity-0" id="header">
        <h1 class="text-3xl font-bold text-[#ff4d4d]">Available Events</h1>
        <!-- Search Bar and Filter -->
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <input type="text" id="search-bar" placeholder="Search events..."
                class="px-4 py-2 rounded bg-[#1a1a1a] text-white placeholder-gray-400 border border-gray-700 focus:border-[#ff4d4d] focus:ring-1 focus:ring-[#ff4d4d] transition-all duration-300 w-full sm:w-64">
            <select id="status-filter"
                class="px-4 py-2 rounded bg-[#1a1a1a] text-white border border-gray-700 focus:border-[#ff4d4d] focus:ring-1 focus:ring-[#ff4d4d] transition-all duration-300">
                <option value="all">All Events</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>
    </div>

    <!-- Event List -->
    <div id="event-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($events->isEmpty())
            <p class="text-gray-400 col-span-full text-center py-10">No events found. Please check back later.</p>
        @else
            @foreach($events as $event)
                <div data-event-name="{{ strtolower($event->name) }}" 
                     data-event-status="{{ $event->registration_status }}" 
                     class="event-card opacity-0 bg-[#1a1a1a] rounded-lg overflow-hidden flex flex-col transform hover:scale-[1.02] transition-transform duration-300
                            @if($user->eventUsers->contains($event)) ring-2 ring-blue-500 @endif">
                    <!-- Event Banner -->
                    <div class="relative overflow-hidden h-48">
                        <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-2 right-2">
                            @if($event->registration_status === 'open')
                                <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full">Open</span>
                            @else
                                <span class="px-3 py-1 bg-[#ff4d4d] text-white text-sm rounded-full">Closed</span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="p-6 flex-grow space-y-4">
                        <h2 class="text-xl font-bold text-white">{{ $event->name }}</h2>
                        
                        <div class="flex items-center space-x-2">
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                @php
                                    $percentage = ($event->participants->count() / $event->participant_limit) * 100;
                                @endphp
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm text-gray-300">
                                {{ $event->participants->count() }}/{{ $event->participant_limit }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Registration Start</span>
                                <span class="text-white">{{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y, h:i A') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Registration End</span>
                                <span class="text-white">{{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>

                        @if($user->eventUsers->contains($event))
                            <p class="text-blue-500 text-sm font-medium">You are registered for this event</p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-4 bg-[#151515] flex justify-between items-center">
                        <a href="{{ route('user.event.details', $event) }}"
                            class="px-6 py-2 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600 transition-colors duration-300">
                            View Details
                        </a>

                        @if($user->eventUsers->contains($event))
                            <form action="{{ route('user.cancel_registration', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-2 bg-[#ff4d4d] text-white text-sm rounded-full hover:bg-red-600 transition-colors duration-300">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center" id="pagination">
        {{ $events->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // GSAP Animations
    gsap.from("#header", {
        y: -50,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    });

    const eventCards = gsap.utils.toArray('.event-card');
    gsap.set(eventCards, { opacity: 0, y: 50 });
    
    eventCards.forEach((card, index) => {
        gsap.to(card, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            delay: 0.2 * index,
            ease: "power3.out"
        });
    });

    // Search and Filter Functionality
    const searchBar = document.getElementById('search-bar');
    const statusFilter = document.getElementById('status-filter');

    function filterEvents() {
        const query = searchBar.value.toLowerCase().trim();
        const status = statusFilter.value;

        eventCards.forEach(card => {
            const eventName = card.getAttribute('data-event-name')?.toLowerCase() || '';
            const eventStatus = card.getAttribute('data-event-status') || 'all';
            const matchesSearch = eventName.includes(query);
            const matchesStatus = status === 'all' || eventStatus === status;

            if (matchesSearch && matchesStatus) {
                gsap.to(card, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.3,
                    display: 'flex'
                });
            } else {
                gsap.to(card, {
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.3,
                    onComplete: () => {
                        card.style.display = 'none';
                    }
                });
            }
        });
    }

    searchBar.addEventListener('input', filterEvents);
    statusFilter.addEventListener('change', filterEvents);

    // Hover animations for cards
    eventCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card.querySelector('img'), {
                scale: 1.1,
                duration: 0.4,
                ease: "power2.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card.querySelector('img'), {
                scale: 1,
                duration: 0.4,
                ease: "power2.out"
            });
        });
    });
});
</script>
@endsection