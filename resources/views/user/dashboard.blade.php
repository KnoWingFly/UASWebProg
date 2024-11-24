@extends('layouts.user')

@section('content')
    <main class="p-6">
        <!-- User Profile Section -->
        <div class="text-center mb-8">
            <img src="{{ Auth::user()->avatar ?: 'default-avatar.png' }}" alt="Profile Image"
                class="w-32 h-32 rounded-full mx-auto">
            <h2 class="text-2xl font-bold mt-4">{{ Auth::user()->name }}</h2>
            <p class="text-gray-400">{{ Auth::user()->username }}</p>
        </div>

        <!-- Achievements Section -->
        <div class="mb-8">
            <h3 class="text-xl font-bold">Achievements</h3>

            @if($userAchievements->isNotEmpty())
                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach($userAchievements as $achievement)
                        <div class="bg-gray-700 p-4 rounded-lg text-center">
                            <p class="font-semibold">{{ $achievement->title }}</p>
                            <p class="text-gray-400">{{ $achievement->description ?? 'No description' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400">Never give up, achievements will come!</p> <!-- Encouraging message -->
            @endif
        </div>

        <!-- Activity History Section -->
        <div>
            <h3 class="text-xl font-bold">Activity History</h3>
            <ul class="mt-4 space-y-2">
                <!-- Display the join activity as the first entry -->
                <li class="bg-gray-700 p-4 rounded-lg">
                    <strong>Joined UMN PC</strong> - {{ Auth::user()->created_at->format('Y-m-d') }} <br>
                    <span class="text-gray-400">Welcome to UMN Programming Club!</span>
                </li>
                
                <!-- Loop through additional activities -->
                @foreach($userActivities as $activity)
                    <li class="bg-gray-700 p-4 rounded-lg">
                        <strong>{{ $activity->activity_type }}</strong> - {{ $activity->activity_date }} <br>
                        <span class="text-gray-400">{{ $activity->description }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </main>
@endsection
