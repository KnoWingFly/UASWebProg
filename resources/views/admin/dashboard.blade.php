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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-medium text-blue-100 uppercase tracking-wide">Total Users</h5>
                        <p class="mt-2 text-3xl font-bold text-white">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-blue-600 bg-opacity-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Accounts Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
            <div class="p-6 bg-gradient-to-r from-green-500 to-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-medium text-green-100 uppercase tracking-wide">User Accounts</h5>
                        <p class="mt-2 text-3xl font-bold text-white">{{ $userUsers }}</p>
                    </div>
                    <div class="bg-green-600 bg-opacity-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Approvals Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105">
            <div class="p-6 bg-gradient-to-r from-yellow-500 to-yellow-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-medium text-yellow-100 uppercase tracking-wide">Pending Approvals</h5>
                        <p class="mt-2 text-3xl font-bold text-white">{{ $pendingUsers }}</p>
                    </div>
                    <div class="bg-yellow-600 bg-opacity-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Admin Menu -->
        <div class="lg:col-span-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                <div class="p-6">
                    <h5 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Quick Actions</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.manage') }}" 
                           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-gray-800 dark:text-gray-200 font-medium">Manage Users</span>
                        </a>

                        <a href="{{ route('admin.events.index') }}" 
                           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-800 dark:text-gray-200 font-medium">Manage Events</span>
                        </a>

                        <a href="{{ route('admin.materials.index') }}" 
                           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg p-4 flex items-center space-x-4 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-gray-800 dark:text-gray-200 font-medium">Learning Materials</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection