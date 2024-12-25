@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Overview of your platform statistics</p>
    </div>

    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="feature-card relative group w-full max-w-sm mx-auto">
    <!-- Glow effect centered on the card -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-blue-500/20 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>

    <!-- Card content -->
    <div
        class="relative bg-black/40 backdrop-blur-sm p-6 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-blue-500/20 p-4 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4 text-center pt-4">Total Users</h3>
        <p class="text-4xl font-bold text-center text-white">{{ $totalUsers }}</p>
    </div>
</div>


<!-- Accepted Users Card -->
<div class="feature-card relative group w-full max-w-sm mx-auto">
    <!-- Glow effect centered on the card -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-green-500/20 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>

    <!-- Card content -->
    <div
        class="relative bg-black/40 backdrop-blur-sm p-6 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-green-500/20 p-4 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4 text-center pt-4">Accepted Users</h3>
        <p class="text-4xl font-bold text-center text-white">{{ $acceptedUsers }}</p>
    </div>
</div>

<!-- Pending Approvals Card -->
<div class="feature-card relative group w-full max-w-sm mx-auto">
    <!-- Glow effect centered on the card -->
    <div
        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-yellow-500/20 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
    </div>

    <!-- Card content -->
    <div
        class="relative bg-black/40 backdrop-blur-sm p-6 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-yellow-500/20 p-4 rounded-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-white mb-4 text-center pt-4">Pending Approvals</h3>
        <p class="text-4xl font-bold text-center text-white">{{ $pendingUsers }}</p>
    </div>
</div>
</div>
</div>

    <!-- Admin Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Admin Menu -->
    <div class="lg:col-span-4">
        <div class="bg-[#151515] rounded-xl shadow-lg">
            <div class="p-6">
                <h5 class="text-xl font-semibold text-white mb-4">Quick Actions</h5>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Manage Users -->
                    <a href="{{ route('admin.users.manage') }}"
                        class="bg-[#1a1a1a] hover:bg-[#ff4d4d] rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-gray-300 group-hover:text-white font-medium">Manage Users</span>
                    </a>

                    <!-- Manage Events -->
                    <a href="{{ route('admin.events.index') }}"
                        class="bg-[#1a1a1a] hover:bg-[#ff4d4d] rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-300 group-hover:text-white font-medium">Manage Events</span>
                    </a>

                    <!-- Learning Materials -->
                    <a href="{{ route('admin.materials.index') }}"
                        class="bg-[#1a1a1a] hover:bg-[#ff4d4d] rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-gray-300 group-hover:text-white font-medium">Learning Materials</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
