<!-- resources/views/user/dashboard.blade.php -->
@extends('layouts.app')  <!-- Pastikan ini merujuk ke layout utama aplikasi -->

@section('title', 'User Dashboard')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">Welcome, {{ $user->name }}!</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-medium mb-4">Your Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-lg"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-lg"><strong>Status:</strong> {{ $user->is_approved ? 'Approved' : 'Not Approved' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-lg"><strong>Role:</strong> {{ ucfirst($user->roles) }}</p>
                    <p class="text-lg"><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-medium mb-4">Recent Activities</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-lg">You haven't completed any activities yet. Check out some options to get started!</p>
            </div>
        </div>
    </div>
@endsection
