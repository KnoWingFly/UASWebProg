<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-gray-200">

    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <header class="bg-[#1a1a1a] shadow-lg fixed top-0 w-full z-30">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center space-x-4">
                <button id="hamburger" 
                    class="text-gray-400 hover:text-[#ff4d4d] transition-colors duration-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 6h16M4 12h16m-7 6h7">
                        </path>
                    </svg>
                </button>
                <div id="logo-container" class="flex items-center space-x-3">
                    <img src="{{ asset('images/UMN_Pc.png') }}" alt="Logo" 
                        class="h-10 w-auto transform transition-transform duration-300 hover:scale-105">
                    <span class="text-xl font-bold text-[#ff4d4d]">
                        {{ config('app.name', 'UMN PC') }}
                    </span>
                </div>
            </div>
        </div>
    </header>


        <!-- Page Content -->
        <main class="pt-20 p-6 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

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
