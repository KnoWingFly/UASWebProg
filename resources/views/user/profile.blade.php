@extends('layouts.user')

@section('content')
<div class="flex-1">
    <header class="bg-gray-800 shadow">
        <div class="flex items-center justify-between p-4">
            <button id="hamburger" class="text-gray-300 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
            <h1 class="text-lg font-bold text-gray-100">Welcome, {{ Auth::user()->name }}</h1>
        </div>
    </header>

    <main class="p-6">
        <!-- User Profile Section -->
        <div class="text-center mb-8">
            <img src="{{ Auth::user()->avatar ?: 'default-avatar.png' }}" alt="Profile Image" class="w-32 h-32 rounded-full mx-auto">
            <h2 class="text-2xl font-bold mt-4">{{ Auth::user()->name }}</h2>
            <p class="text-gray-400">{{ Auth::user()->username }}</p>
        </div>

        <!-- Achievements Section -->
        <div class="mb-8">
            <h3 class="text-xl font-bold">Achievements</h3>
            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach($userAchievements as $achievement)
                    <div class="bg-gray-700 p-4 rounded-lg text-center">
                        <p class="font-semibold">{{ $achievement->title }}</p>
                        <p class="text-gray-400">{{ $achievement->description ?? 'No description' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Activity History Section -->
        <div>
            <h3 class="text-xl font-bold">Activity History</h3>
            <ul class="mt-4 space-y-2">
                @foreach($userActivities as $activity)
                    <li class="bg-gray-700 p-4 rounded-lg">
                        <strong>{{ $activity->activity_type }}</strong> - {{ $activity->activity_date }} <br>
                        <span class="text-gray-400">{{ $activity->description }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </main>
</div>
@endsection
