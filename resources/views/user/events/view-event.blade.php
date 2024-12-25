@extends('layouts.user')

@section('content')
<div class="p-6 space-y-6 bg-[#151515]">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4" id="header">
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
                     class="event-card bg-[#1a1a1a] rounded-lg overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300
                            @if($user->eventUsers->contains($event)) ring-2 ring-blue-500 @endif">
                    <!-- Event Banner -->
                    <div class="relative overflow-hidden h-48 event-banner">
                        <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->name }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 status-badge">
                            @if($event->registration_status === 'open')
                                <span class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full">Open</span>
                            @else
                                <span class="px-3 py-1 bg-[#ff4d4d] text-white text-sm rounded-full">Closed</span>
                            @endif
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="p-6 flex-grow space-y-4 event-content">
                        <h2 class="text-xl font-bold text-white">{{ $event->name }}</h2>
                        
                        <div class="flex items-center space-x-2">
                            <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
                                @php
                                    $percentage = ($event->participants->count() / $event->participant_limit) * 100;
                                @endphp
                                <div class="progress-bar bg-blue-500 h-2 rounded-full" 
                                     data-percentage="{{ $percentage }}"></div>
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
                    <div class="p-4 flex justify-between items-center event-actions">
                        <a href="{{ route('user.event.details', $event) }}"
                            class="px-6 py-2 bg-[#1a1a1a] text-white text-sm rounded-full hover:bg-[#2a2a2a] transition-colors duration-300 border border-[#ff4d4d]">
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
    // Initial animations
    const tl = gsap.timeline();
    
    // Header animation
    tl.from("#header", {
        y: -50,
        opacity: 0,
        duration: 0.8,
        ease: "power3.out"
    });

    // Staggered card animations
    const eventCards = gsap.utils.toArray('.event-card');
    tl.from(eventCards, {
        y: 50,
        opacity: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: "power3.out"
    });

    // Progress bar animations
    eventCards.forEach(card => {
        const progressBar = card.querySelector('.progress-bar');
        const percentage = progressBar.getAttribute('data-percentage');
        
        gsap.set(progressBar, { width: 0 });
        gsap.to(progressBar, {
            width: `${percentage}%`,
            duration: 1,
            ease: "power2.out",
            scrollTrigger: {
                trigger: progressBar,
                start: "top 90%",
                toggleActions: "play none none reverse"
            }
        });
    });

    // Search and Filter functionality with animations
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
                    y: 0,
                    scale: 1,
                    duration: 0.4,
                    ease: "power2.out",
                    display: 'flex'
                });
            } else {
                gsap.to(card, {
                    opacity: 0,
                    y: 20,
                    scale: 0.95,
                    duration: 0.4,
                    ease: "power2.in",
                    onComplete: () => {
                        card.style.display = 'none';
                    }
                });
            }
        });
    }

    // Event card hover animations
    eventCards.forEach(card => {
        const banner = card.querySelector('img');
        const content = card.querySelector('.event-content');
        const actions = card.querySelector('.event-actions');
        const badge = card.querySelector('.status-badge');

        const hoverTl = gsap.timeline({ paused: true });
        
        hoverTl
            .to(banner, {
                scale: 1.1,
                duration: 0.4,
                ease: "power2.out"
            })
            .to(content, {
                y: -5,
                duration: 0.3,
                ease: "power2.out"
            }, 0)
            .to(actions, {
                y: -5,
                duration: 0.3,
                ease: "power2.out"
            }, 0)
            .to(badge, {
                scale: 1.1,
                duration: 0.3,
                ease: "power2.out"
            }, 0);

        card.addEventListener('mouseenter', () => hoverTl.play());
        card.addEventListener('mouseleave', () => hoverTl.reverse());
    });

    searchBar.addEventListener('input', filterEvents);
    statusFilter.addEventListener('change', filterEvents);
});
</script>
@endsection