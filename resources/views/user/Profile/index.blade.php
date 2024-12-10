@extends('layouts.user')

@section('content')
<main class="bg-gray-900 text-white min-h-screen">
    <!-- Header Section -->
    <div class="flex flex-col items-center bg-gray-800 py-6">
        <!-- Logo -->
        <img src="{{ asset('images/UMN_Pc.png') }}" alt="UMN PC Logo" class="h-16">
        <h1 class="text-2xl font-bold mt-2">UMN PC</h1>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-10">
        <!-- Profile Section -->
        <div class="relative bg-gray-700 rounded-lg shadow-lg">
            <div class="h-48 bg-gray-600 rounded-t-lg"></div>
            <div class="absolute w-24 h-24 bg-gray-500 rounded-full -bottom-12 left-1/2 transform -translate-x-1/2 border-4 border-gray-700 flex items-center justify-center">
                <img src="{{ asset('images/default-avatar.png') }}" alt="Profile Picture" class="rounded-full h-20">
            </div>
        </div>
        <div class="text-center mt-16">
            <h2 class="text-2xl font-bold">Alexis Thorne</h2>
            <p class="text-gray-400">@genius_hustler</p>
        </div>

        <!-- Achievements Section -->
        <div class="mt-12">
            <h3 class="text-3xl font-bold text-center mb-6">Achievements</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(['Top Coder', 'Hackathon Winner', 'Project Lead', 'Volunteer', 'Mentor', 'Community Builder'] as $achievement)
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex items-center justify-center text-center">
                    <p class="text-gray-300 font-semibold">{{ $achievement }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Activity History Section -->
        <div class="mt-12">
            <h3 class="text-3xl font-bold text-center mb-6">Activity History</h3>
            <ul class="text-gray-300 space-y-2 text-center">
                <li>1. Joined UMN PC - Jan 2021</li>
                @for($i = 2; $i <= 7; $i++)
                <li>{{ $i }}. Lorem ipsum</li>
                @endfor
            </ul>
        </div>
    </div>
</main>
@endsection
