@extends('layouts.user')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="max-w-4xl mx-auto py-10">
        <!-- Header -->
        <div class="flex flex-col items-center mb-10">
            <!-- Profile Picture -->
            <div class="w-32 h-32 bg-gray-500 rounded-full overflow-hidden">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}"
                     alt="Profile Image" 
                     class="w-full h-full object-cover">
            </div>
            <!-- User Information -->
            <h2 class="text-2xl font-bold mt-4">{{ Auth::user()->name }}</h2>
            <p class="text-gray-400">{{ Auth::user()->username }}</p>
        </div>

        </div>
    </div>
</body>
@endsection

