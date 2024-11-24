@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back to Events Button -->
    <div class="mb-4">
        <a href="{{ route('user.events') }}"
            class="inline-flex items-center bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Events
        </a>
    </div>

    <div class="bg-gray-800 text-white rounded-lg shadow-md p-6">
        <!-- Event Banner -->
        <div class="mb-6">
            <img src="{{ asset('storage/' . $event->banner) }}" alt="Event Banner"
                class="w-full h-64 object-cover rounded-lg">
        </div>

        <!-- Event Name -->
        <h1 class="text-4xl font-bold mb-4">{{ $event->name }}</h1>

        <!-- Event Description -->
        <div class="mb-6">
            <strong>Description: </strong>
            <p class="text-gray-300">{{ $event->description }}</p>
        </div>

        <!-- Event Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <strong>Total Participants: </strong>
                <span class="text-gray-300">{{ $event->participants->count() }} / {{ $event->participant_limit }}</span>
            </div>
            <div>
                <strong>Registration Start: </strong>
                <span
                    class="text-gray-300">{{ \Carbon\Carbon::parse($event->registration_start)->format('d M Y h:i A') }}</span>
            </div>
            <div>
                <strong>Registration End: </strong>
                <span
                    class="text-gray-300">{{ \Carbon\Carbon::parse($event->registration_end)->format('d M Y h:i A') }}</span>
            </div>
            <div>
                <strong>Status: </strong>
                @if($event->registration_status === 'open')
                    <span class="text-green-400">Open</span>
                @else
                    <span class="text-red-400">Closed</span>
                @endif
            </div>
        </div>

        <!-- Registration Status Message -->
        @if ($registrationStatus)
            <div class="bg-green-200 p-4 rounded-md text-green-800 mb-6 dark:bg-green-900 dark:text-green-200">
                You are registered for this event!
            </div>
        @else
            <div class="bg-red-200 p-4 rounded-md text-red-800 mb-6 dark:bg-red-900 dark:text-red-200">
                You have not registered for this event.
            </div>
        @endif

        <!-- Event Registration Button -->
        <!-- Event Registration Button -->
        @if (!$registrationStatus)
            @if ($event->participants->count() >= $event->participant_limit)
                <div class="bg-yellow-200 p-4 rounded-md text-yellow-800 mt-4 dark:bg-yellow-900 dark:text-yellow-200">
                    This event has reached the maximum number of participants.
                </div>
            @elseif ($event->registration_status === 'open')
                <form action="{{ route('user.register_event', $event->id) }}" method="GET">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-3 rounded-md mt-4 hover:bg-blue-600 transition dark:bg-blue-700 dark:hover:bg-blue-800">
                        Register for this Event
                    </button>
                </form>
            @else
                <div class="bg-gray-500 p-4 rounded-md text-white mt-4">
                    Registration is closed.
                </div>
            @endif
        @else
            <!-- Cancel Registration Button -->
            <form action="{{ route('user.cancel_registration', $event->id) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600 transition dark:bg-red-700 dark:hover:bg-red-800">
                    Cancel Registration
                </button>
            </form>
        @endif


        <!-- Participant List -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold mb-4">Participants:</h2>
            <ul class="list-disc pl-5 text-gray-300">
                @foreach ($event->participants as $participant)
                    <li>{{ $participant->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection