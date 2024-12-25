<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf_viewer.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('style')
</head>

<body class="bg-[#151515] text-gray-200 min-h-screen">
    <!-- Sidebar Component -->
    @include('components.sidebar-user')

    <!-- Header -->
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

    <!-- Main Content -->
    <main class="pt-20 p-6 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    @stack('script')
    <script type="module">
        // Wait for GSAP to be loaded through Vite
        window.addEventListener('load', () => {
            const hamburger = document.getElementById('hamburger');
            const sidebar = document.getElementById('sidebar');
            const logoContainer = document.getElementById('logo-container');
            
            // Initialize GSAP animations
            if (window.gsap) {
                gsap.from(hamburger, {
                    x: -20,
                    opacity: 0,
                    duration: 0.6,
                    ease: 'power2.out'
                });

                gsap.from(logoContainer, {
                    x: -20,
                    opacity: 0,
                    duration: 0.6,
                    delay: 0.2,
                    ease: 'power2.out'
                });

                // Hover animation for hamburger
                hamburger.addEventListener('mouseenter', () => {
                    gsap.to(hamburger, {
                        scale: 1.1,
                        duration: 0.2,
                        ease: 'power1.out'
                    });
                });

                hamburger.addEventListener('mouseleave', () => {
                    gsap.to(hamburger, {
                        scale: 1,
                        duration: 0.2,
                        ease: 'power1.in'
                    });
                });
            }

            // Hamburger click handler
            hamburger.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            });
        });
    </script>
</body>
</html>