@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6" id="mainContainer">
    <!-- Back to Events Button -->
    <div class="mb-4" id="backButton">
        <a href="{{ route('user.events') }}"
            class="inline-flex items-center bg-[#1a1a1a] text-white px-4 py-2 rounded-md hover:bg-[#151515] transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Events
        </a>
    </div>

    <div class="bg-[#1a1a1a] text-white rounded-lg shadow-xl p-6" id="eventCard">
        <!-- Event Banner -->
        <div class="mb-6 overflow-hidden rounded-lg" id="bannerContainer">
            <img src="{{ asset('storage/' . $event->banner) }}" alt="Event Banner"
                class="w-full h-80 object-cover transform hover:scale-105 transition duration-700"
                id="eventBanner">
        </div>

        <!-- Event Name -->
        <h1 class="text-5xl font-bold mb-6 text-[#ff4d4d]" id="eventName">{{ $event->name }}</h1>

        <!-- Event Description -->
        <div class="mb-8" id="eventDescription">
            <h2 class="text-xl font-semibold mb-2 text-blue-500">Description</h2>
            <p class="text-gray-300 leading-relaxed">{{ $event->description }}</p>
        </div>

        <!-- Event Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8" id="eventDetails">
            <div class="bg-[#1a1a1a] p-4 rounded-lg">
                <strong class="text-blue-500">Total Participants: </strong>
                <span class="text-gray-300">{{ $event->participants->count() }} / {{ $event->participant_limit }}</span>
            </div>
            <div class="bg-[#1a1a1a] p-4 rounded-lg">
                <strong class="text-blue-500">Registration Start: </strong>
                <span class="text-gray-300">{{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y h:i A') }}</span>
            </div>
            <div class="bg-[#1a1a1a] p-4 rounded-lg">
                <strong class="text-blue-500">Registration End: </strong>
                <span class="text-gray-300">{{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y h:i A') }}</span>
            </div>
            <div class="bg-[#1a1a1a] p-4 rounded-lg">
                <strong class="text-blue-500">Status: </strong>
                @if($event->registration_status === 'open')
                    <span class="text-green-400">Open</span>
                @else
                    <span class="text-[#ff4d4d]">Closed</span>
                @endif
            </div>
        </div>

        <!-- Registration Status Message -->
        <div id="statusMessage">
            @if ($registrationStatus)
                <div class="bg-green-900/50 border border-green-500 p-4 rounded-lg text-green-200 mb-6">
                    You are registered for this event!
                </div>
            @else
                <div class="bg-[#ff4d4d]/10 border border-[#ff4d4d] p-4 rounded-lg text-[#ff4d4d] mb-6">
                    You have not registered for this event.
                </div>
            @endif
        </div>

        <!-- Event Registration Button -->
        <div id="actionButton">
            @if (!$registrationStatus)
                @if ($event->participants->count() >= $event->participant_limit)
                    <div class="bg-yellow-900/50 border border-yellow-500 p-4 rounded-lg text-yellow-200 mt-4">
                        This event has reached the maximum number of participants.
                    </div>
                @elseif ($event->registration_status === 'open')
                    <form action="{{ route('user.register_event', $event->id) }}" method="GET">
                        <button type="submit"
                            class="bg-blue-500 text-white px-8 py-4 rounded-lg mt-4 hover:bg-blue-600 transition duration-300 transform hover:scale-105">
                            Register for this Event
                        </button>
                    </form>
                @else
                    <div class="bg-[#1a1a1a] p-4 rounded-lg text-white mt-4">
                        Registration is closed.
                    </div>
                @endif
            @else
                <form action="{{ route('user.cancel_registration', $event->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-[#ff4d4d] text-white px-8 py-4 rounded-lg hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                        Cancel Registration
                    </button>
                </form>
            @endif
        </div>

        <!-- Participant List -->
        <div class="mt-8" id="participantList">
            <h2 class="text-2xl font-semibold mb-4 text-blue-500">Participants</h2>
            <div class="bg-[#1a1a1a] rounded-lg p-4">
                <ul class="space-y-2 text-gray-300">
                    @foreach ($event->participants as $participant)
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-[#ff4d4d]" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                            <span>{{ $participant->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Reset any transforms or opacity that might be set by GSAP
    gsap.set([
        '#mainContainer',
        '#backButton',
        '#eventCard',
        '#bannerContainer',
        '#eventName',
        '#eventDescription',
        '#eventDetails > div',
        '#statusMessage',
        '#actionButton',
        '#participantList'
    ], { clearProps: "all" });

    // Main timeline
    const tl = gsap.timeline({
        defaults: {
            ease: 'power2.out',
            duration: 0.5
        }
    });
    
    tl.from('#mainContainer', {
        opacity: 0,
        y: 20,
    })
    .from('#backButton', {
        y: 20,
        opacity: 0,
    })
    .from('#eventCard', {
        scale: 0.95,
        opacity: 0,
        duration: 0.6,
        ease: 'back.out'
    })
    .from('#bannerContainer', {
        opacity: 0,
        y: 30,
    }, '-=0.3')
    .from('#eventName', {
        opacity: 0,
        x: -30,
    }, '-=0.2')
    .from('#eventDescription', {
        opacity: 0,
        y: 20,
    }, '-=0.2')
    .from('#eventDetails > div', {
        opacity: 0,
        y: 20,
        stagger: 0.1
    }, '-=0.2')
    .from('#statusMessage', {
        opacity: 0,
        scale: 0.9,
    }, '-=0.2')
    .from('#actionButton', {
        opacity: 0,
        y: 20,
    }, '-=0.2')
    .from('#participantList', {
        opacity: 0,
        y: 20,
    }, '-=0.2');

    // Hover animations for buttons
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.3
            });
        });
        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.3
            });
        });
    });
});
</script>
@endsection