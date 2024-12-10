<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf_viewer.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-200">

    <!-- Sidebar Component -->
    @include('components.sidebar-user')

    <header class="bg-gray-800 shadow">
    <div class="flex items-center p-4">
        <!-- Hamburger Button on the Left -->
        <button id="hamburger" class="text-gray-300 hover:text-white mr-16">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Logo and App Name next to Hamburger with additional margin to move it right -->
        <div class="flex items-center space-x-2 ml-20"> <!-- Added ml-20 for left margin -->
            <img src="{{ asset('images/UMN_Pc.png') }}" alt="Logo" style="height: 40px;">
            <span class="text-white font-bold">{{ config('app.name', 'UMN PC') }}</span>
        </div>
    </div>
</header>




        <!-- Page Content -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');
        const closeSidebar = document.getElementById('closeSidebar');

        hamburger.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        });
    </script>
</body>

</html>
