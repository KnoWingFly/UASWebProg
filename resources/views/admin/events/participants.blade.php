@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-200">Participants for {{ $event->name }}</h1>
        <a href="{{ route('admin.events.index') }}"
            class="px-4 py-2 bg-blue-600 text-white font-medium rounded hover:bg-blue-700">
            Back to Events
        </a>
    </div>

    <!-- Event Details -->
    <div class="p-6 bg-gray-800 rounded-lg shadow-md text-gray-200">
        <h2 class="text-xl font-semibold">Event Details</h2>
        <p class="mt-2">Name: <span class="font-medium text-gray-300">{{ $event->name }}</span></p>

        <!-- Registration Period -->
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

        <!-- Max Participants -->
        <p class="mt-2">Max Participants:</p>
        <p class="text-sm text-gray-300">
            Current Participants: <span class="font-medium">{{ $event->participants->count() }}</span>/<span
                class="font-medium">{{ $event->participant_limit }}</span>
        </p>
    </div>

    <!-- Participants Table -->
    <div class="p-6 bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-200">Participants List</h2>

        @if($participants->isEmpty())
            <p class="text-gray-400 mt-4">No participants have registered for this event yet.</p>
        @else
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Registered At</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $participant)
                            <tr class="border-b border-gray-700 hover:bg-gray-700">
                                <td class="px-6 py-4">{{ $participant->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $participant->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    {{ optional($participant->pivot)->created_at ? $participant->pivot->created_at->format('d M Y, h:i A') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <button data-modal-target="remove-modal-{{ $participant->id }}"
                                        data-modal-toggle="remove-modal-{{ $participant->id }}"
                                        class="text-red-500 hover:underline">
                                        Remove
                                    </button>
                                </td>
                            </tr>

                            <!-- Remove Confirmation Modal -->
                            <div id="remove-modal-{{ $participant->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-gray-800 rounded-lg shadow">
                                        <div class="p-6 text-center">
                                            <h3 class="mb-5 text-lg font-normal text-gray-400">
                                                Are you sure you want to remove {{ $participant->name }}?
                                            </h3>
                                            <form action="{{ route('admin.events.removeParticipant', [$event, $participant]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">
                                                    Yes, Remove
                                                </button>
                                                <button data-modal-hide="remove-modal-{{ $participant->id }}" type="button"
                                                    class="text-gray-400 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg text-sm px-5 py-2.5">
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection