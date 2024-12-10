@extends('layouts.user')

@section('content')
<main class="p-6 mt-16" x-data="profileManager()">
    <meta charset="UTF-8">
    <title>UMN Programming Club</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">

    <body class="bg-gray-900 text-white">

    <!-- Navbar -->
    <div class="fixed top-0 left-0 w-full bg-gray-800 text-white py-4 shadow-lg z-10">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
             <!-- Logo -->
             <img src="{{ asset('images/UMN_Pc.png') }}" alt="UMN PROGRAMING CLUB" class="h-8">
            <!-- Text next to the logo -->
            <span class="text-2xl font-bold">UMN PROGRAMMING CLUB</span>
            </a>

            <!-- Links (Login/Register) -->
            <div class="flex space-x-4">
                    @auth
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold">Register</a>
                    @endauth
                </div>
            </div>
        </div>

            
        
    </div>

    <div class="bg-gray-800 text-center py-24"> 
        <h1 class="text-6xl text-white font-bold">UMN PC</h1>
        <p class="text-xl text-white mt-4">Join our community and get started with UMN Programming Club!</p>
    </div>

    <!-- Rest of your page content -->
    <div class="bg-gray-900 text-white">
        <!-- Introduction Section -->
        <div class="container mx-auto py-16 px-6 text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to UMN Programming Club</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                UMN Programming Club (UMN PC) is dedicated to fostering a community of enthusiastic programmers. Our mission is to enhance coding skills through competitive programming and collaborative projects. Join us to learn, compete, and grow together.
            </p>
        </div>

        <!-- Vision Section -->
        <div class="container mx-auto py-16 px-6">
            <div class="bg-white rounded-lg shadow-lg mx-auto max-w-4xl h-64 mb-6 flex items-center justify-center">
                <p class="text-gray-400">[Insert Image Here]</p>
            </div>
            <h2 class="text-2xl font-bold text-center mb-8">Our Vision: To be a leading community for programmers.</h2>
        </div>

        <!-- Mission Section -->
        <div class="container mx-auto py-16 px-6">
            <h2 class="text-2xl font-bold text-center mb-8">Our Mission: To cultivate coding excellence and teamwork.</h2>
            <div class="bg-white rounded-lg shadow-lg mx-auto max-w-4xl h-64 mb-6 flex items-center justify-center">
                <p class="text-gray-400">[Insert Image Here]</p>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="container mx-auto py-16 px-6 text-center">
            <h2 class="text-3xl font-bold mb-8">Join us in our journey of coding excellence!</h2>
            <div class="bg-white rounded-lg shadow-lg mx-auto max-w-4xl h-64 mb-6 flex items-center justify-center">
                <p class="text-gray-400">[Insert Image Here]</p>
            </div>
        </div>
    </div>

    <!-- Removed the instance with the user's name -->
    <div class="container mx-auto py-16 px-6 text-center">
        <h1 class="text-lg font-bold text-gray-100">Welcome to UMN Programming Club</h1>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
    </body>
</main>

@endsection
