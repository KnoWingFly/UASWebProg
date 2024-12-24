<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMN Programming Club</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #full-screen-menu .menu-link {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #full-screen-menu .menu-link:hover {
            background-color: rgba(255, 77, 77, 0.8);
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, -20px) rotate(90deg);
            }

            50% {
                transform: translate(-20px, -40px) rotate(180deg);
            }

            75% {
                transform: translate(-40px, -20px) rotate(270deg);
            }
        }

        @keyframes glow {

            0%,
            100% {
                filter: brightness(1) blur(10px);
            }

            50% {
                filter: brightness(1.2) blur(15px);
            }
        }

        .particle {
            animation: float var(--duration, 20s) infinite linear var(--delay, 0s);
            opacity: var(--opacity, 0.5);
        }

        /* Navbar Styles */
        #nav-toggle {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-arrow {
            transform-origin: center;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #nav-dropdown {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #ff4d4d, #ff3333);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        #nav-close {
            transition: all 0.3s ease;
        }

        #nav-close:hover {
            transform: rotate(90deg);
        }

        .nav-button {
            position: relative;
            overflow: hidden;
        }

        .nav-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150%;
            height: 150%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: transform 0.6s ease;
        }

        .nav-button:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .feature-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        section {
            position: relative;
            z-index: 1;
        }

        section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to bottom, transparent, #1a1a1a);
            z-index: 2;
        }

        /* Mobile Optimizations */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-text {
                font-size: 1.125rem;
            }

            .particle {
                display: none;
            }
        }
    </style>

</head>


<body>
    <div class="min-h-screen bg-[#1a1a1a]">

        <!-- Navbar -->
        <nav class="fixed top-0 left-0 w-full z-50" id="navbar">
            <!-- Floating Toggle Button -->
            <button id="nav-toggle"
                class="fixed top-6 right-6 z-[60] flex items-center justify-center w-12 h-12 bg-black/50 hover:bg-black/70 backdrop-blur-md rounded-full transition-all duration-300 group">
                <svg class="w-6 h-6 text-white group-hover:text-[#ff4d4d]" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor">
                    <path class="nav-arrow" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Fullscreen Menu -->
            <div id="nav-dropdown"
                class="fixed inset-0 w-full h-screen bg-black/95 backdrop-blur-xl transform -translate-y-full transition-transform duration-500 ease-in-out flex items-center justify-center">
                <!-- Close Button -->
                <button id="nav-close"
                    class="fixed top-6 right-6 z-[70] w-12 h-12 flex items-center justify-center text-white hover:text-[#ff4d4d] transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="max-w-7xl mx-auto px-6 text-center">
                    <!-- Navigation Links -->
                    <div class="flex flex-col items-center space-y-4 mb-16">
                        <a href="#"
                            class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">TOP</a>
                        <a href="#about-us"
                            class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">ABOUT</a>
                        <a href="#logo"
                            class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">LOGO
                            PHILOSOPHY</a>
                        <a href="#features"
                            class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">VISION &
                            MISSION</a>
                        <a href="#Key" class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">KEY
                            FIELDS</a>
                        <a href="#gallery"
                            class="nav-link text-5xl font-bold text-white hover:text-[#ff4d4d] opacity-0">GALLERY</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex justify-center gap-8">
                        <a href="{{ route('login') }}"
                            class="nav-button px-12 py-4 text-xl bg-transparent border-2 border-white text-white rounded-full hover:bg-white hover:text-black transition-all duration-300 opacity-0">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="nav-button px-12 py-4 text-xl bg-[#ff4d4d] text-white rounded-full hover:bg-[#ff3333] transition-all duration-300 opacity-0">
                            Register
                        </a>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden hero-section">
            <div class="absolute inset-0 bg-[#1a1a1a]">
                <!-- Dynamic Background -->
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-[#ff4d4d]/10"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(0,0,0,0),#1a1a1a_70%)]">
                    </div>
                </div>

                <!-- Animated Particles -->
                <div class="particle-system absolute inset-0">
                    @for ($i = 0; $i < 50; $i++)
                        <div class="particle absolute w-1 h-1 bg-white/10 rounded-full" style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; 
                                                animation: float {{ rand(15, 25) }}s infinite linear {{ rand(-10, 0) }}s">
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-6 py-32 text-center">
                <h1
                    class="hero-title text-6xl md:text-8xl font-bold text-white mb-8 opacity-0 translate-y-8 leading-tight">
                    We Code<br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-[#ff4d4d]">For The
                        Future</span>
                </h1>
                <p class="hero-text text-xl md:text-2xl text-gray-300 max-w-2xl mx-auto mb-12 opacity-0 translate-y-8">
                    Join UMN Programming Club's vibrant community.<br>
                    Learn, innovate, and shape the future together.
                </p>

                <div class="flex justify-center gap-8 hero-buttons opacity-0 transform translate-y-8">
                    <a href="{{ route('login') }}"
                        class="px-12 py-4 text-xl bg-transparent border-2 border-white text-white rounded-full hover:bg-white hover:text-black transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-12 py-4 text-xl bg-[#ff4d4d] text-white rounded-full hover:bg-[#ff3333] transition-all duration-300">
                        Register
                    </a>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute bottom-0 left-0 w-full">
                <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                <div class="h-20 bg-gradient-to-t from-[#151515] to-transparent"></div>
            </div>
        </section>


        <!-- About Us Section -->
        <section class="min-h-screen relative flex items-center justify-center bg-[#151515] overflow-hidden"
            id="about-us">
            <!-- Dynamic Background  -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-[#ff4d4d]/10"></div>
                <div class="particle-system absolute inset-0">
                    @for ($i = 0; $i < 50; $i++)
                        <div class="particle absolute w-1 h-1 bg-white/10 rounded-full" style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; 
                                animation: float {{ rand(15, 25) }}s infinite linear {{ rand(-10, 0) }}s">
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Animated particles -->
            <div class="particle-container absolute inset-0 pointer-events-none">
                <div class="particle absolute w-2 h-2 bg-blue-500/20 rounded-full"></div>
                <div class="particle absolute w-2 h-2 bg-[#ff4d4d]/20 rounded-full"></div>
                <div class="particle absolute w-2 h-2 bg-white/20 rounded-full"></div>
                <div class="particle absolute w-1 h-1 bg-blue-400/20 rounded-full"></div>
                <div class="particle absolute w-1 h-1 bg-[#ff6666]/20 rounded-full"></div>
                <div class="particle absolute w-1 h-1 bg-white/10 rounded-full"></div>
                <div class="particle absolute w-3 h-3 bg-blue-500/10 rounded-full"></div>
                <div class="particle absolute w-3 h-3 bg-[#ff4d4d]/10 rounded-full"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="about-text space-y-8">
                        <h2 class="text-4xl md:text-5xl font-bold text-white opacity-0 transform translate-y-8">
                            Who We Are ?
                        </h2>
                        <p class="text-xl text-gray-300 leading-relaxed opacity-0 transform translate-y-8">
                            We are a vibrant community of passionate students dedicated to the art of programming and
                            logical thinking development at Universitas Multimedia Nusantara.
                        </p>
                        <p class="text-xl text-gray-300 leading-relaxed opacity-0 transform translate-y-8">
                            Our focus lies in cultivating strong algorithmic thinking and programming skills, preparing
                            our
                            members to excel in competitive programming competitions both nationally and
                            internationally.
                        </p>
                        <div class="pt-4 opacity-0 transform translate-y-8">
                            <a href="#"
                                class="inline-flex items-center gap-2 text-[#ff4d4d] hover:text-[#ff3333] transition-colors">
                                <span>Learn more about our achievements</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 gap-6">
                        <div
                            class="stat-card bg-black/40 backdrop-blur-sm p-6 rounded-2xl border border-white/10 transform opacity-0 translate-y-8">
                            <div class="text-[#ff4d4d] text-4xl font-bold counter">80+</div>
                            <div class="text-white mt-2">Active Members</div>
                        </div>
                        <div
                            class="stat-card bg-black/40 backdrop-blur-sm p-6 rounded-2xl border border-white/10 transform opacity-0 translate-y-8">
                            <div class="text-blue-500 text-4xl font-bold">Gen 12</div>
                            <div class="text-white mt-2">Current Generation</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="min-h-screen relative flex items-center justify-center bg-[#1a1a1a] overflow-hidden" id="logo">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(0,0,0,0),#1a1a1a_70%)]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">
                <div class="text-center mb-16 logo-title opacity-0">
                    <h2 class="text-4xl md:text-5xl font-bold text-white">Logo Philosophy</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <!-- Logo Display -->
                    <div class="logo-container relative opacity-0">
                        <div class="bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10">
                            <img src="{{ asset('images/UMN_Pc.png') }}" alt="UMN PC Logo"
                                class="w-full max-w-md mx-auto">
                        </div>
                    </div>

                    <!-- Philosophy Explanation -->
                    <div class="space-y-8">
                        <div class="philosophy-item opacity-0 transform translate-y-8">
                            <h3 class="text-2xl font-bold text-[#ff4d4d] mb-3">Dolphins</h3>
                            <p class="text-gray-300 text-lg">
                                The Dolphins symbolizes intelligence and adaptability, representing our capacity to
                                learn
                                and
                                embrace new knowledge.
                            </p>
                        </div>

                        <div class="philosophy-item opacity-0 transform translate-y-8">
                            <h3 class="text-2xl font-bold text-blue-500 mb-3">UMN Integration</h3>
                            <p class="text-gray-300 text-lg">
                                Our logo incorporates UMN's universal philosophy, representing our strong connection to
                                the
                                university's values and principles. The digital elements symbolize our focus on
                                technology
                                and programming.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="min-h-screen relative flex items-center justify-center bg-[#151515]" id="features">
            <!-- Background Design Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
            </div>

            <div class="max-w-5xl w-full mx-auto px-6">
                <div class="space-y-16">
                    <!-- Section Title -->
                    <h2 class="text-4xl font-bold text-white text-center">
                        Discover Our Purpose
                    </h2>

                    <!-- Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 place-items-center">
                        <!-- Vision Card -->
                        <div class="feature-card relative group w-full max-w-md">
                            <!-- Glow effect centered on the card -->
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-blue-500/20 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-blue-500/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-4 text-center pt-4">Our Vision</h3>
                                <p class="text-gray-300 text-center">
                                    To be a leading community that empowers students through programming excellence
                                    and collaborative learning experiences.
                                </p>
                            </div>
                        </div>

                        <!-- Mission Card -->
                        <div class="feature-card relative group w-full max-w-md">
                            <!-- Glow effect centered on the card -->
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-[#ff4d4d]/20 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-[#ff4d4d]/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-[#ff4d4d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-4 text-center pt-4">Our Mission</h3>
                                <p class="text-gray-300 text-center">
                                    We cultivate coding excellence and teamwork through hands-on projects,
                                    competitive programming, and a supportive learning environment.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="min-h-screen relative bg-[#1a1a1a] py-24 overflow-hidden" id="Key">
            <div class="max-w-7xl mx-auto px-6">
                <h2
                    class="text-4xl md:text-5xl font-bold text-white mb-24 key-fields-title opacity-0 transform translate-y-8">
                    We educate in four<br>key fields
                </h2>

                <!-- Fields Container -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">

                    <!-- Field 1 -->
                    <div class="field-card group relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl">
                        </div>
                        <div
                            class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                            <div class="flex items-start gap-6">
                                <div class="bg-blue-500/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white mb-3">Logical Thinking Development</h3>
                                    <p class="text-gray-300">Building strong foundations in problem-solving and
                                        analytical
                                        thinking skills essential for programming excellence.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 2 -->
                    <div class="field-card group relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#ff4d4d]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl">
                        </div>
                        <div
                            class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                            <div class="flex items-start gap-6">
                                <div class="bg-[#ff4d4d]/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-[#ff4d4d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white mb-3">Programming Mastery</h3>
                                    <p class="text-gray-300">Developing expertise in various programming languages and
                                        advanced coding techniques.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 3 -->
                    <div class="field-card group relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl">
                        </div>
                        <div
                            class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                            <div class="flex items-start gap-6">
                                <div class="bg-blue-500/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white mb-3">Competitive Programming Preparation
                                    </h3>
                                    <p class="text-gray-300">Training for national and international programming
                                        competitions through intensive practice and mentoring.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field 4 -->
                    <div class="field-card group relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#ff4d4d]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl">
                        </div>
                        <div
                            class="relative bg-black/40 backdrop-blur-sm p-8 rounded-3xl border border-white/10 hover:border-white/20 transition-all duration-300">
                            <div class="flex items-start gap-6">
                                <div class="bg-[#ff4d4d]/20 p-4 rounded-2xl">
                                    <svg class="w-8 h-8 text-[#ff4d4d]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white mb-3">Community and Collaboration</h3>
                                    <p class="text-gray-300">Fostering a supportive environment where members learn from
                                        each other and grow together.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative Element -->
            <div
                class="absolute bottom-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/20 to-transparent">
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="py-24 relative bg-[#151515] overflow-hidden" id="gallery">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Section Title -->
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-extrabold text-white gallery-title opacity-0 transform scale-90">
                        Gallery
                    </h2>
                </div>

                <div class="gallery-grid grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Gallery Items -->
                    <div class="gallery-item group relative overflow-hidden rounded-xl border-4 border-white shadow-lg">
                        <img src="{{ asset('images/intro/umnpc2.jpg') }}" alt="Competition"
                            class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 p-6">
                                <h3 class="text-xl font-bold text-white">Internal Competition</h3>
                                <p class="text-gray-300">An exciting showcase of student talent and skills.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item group relative overflow-hidden rounded-xl border-4 border-white shadow-lg">
                        <img src="{{ asset('images/intro/1.jpg') }}" alt="Competition"
                            class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 p-6">
                                <h3 class="text-xl font-bold text-white">Bonding</h3>
                                <p class="text-gray-300">Building friendships and teamwork among students.</p>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item group relative overflow-hidden rounded-xl border-4 border-white shadow-lg">
                        <img src="{{ asset('images/intro/2.jpg') }}" alt="Competition"
                            class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-110 group-hover:rotate-1">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 p-6">
                                <h3 class="text-xl font-bold text-white">Studying</h3>
                                <p class="text-gray-300">Students focusing on learning and personal growth.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-[#1a1a1a] border-t border-white/10">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Logo and Description -->
                    <div class="col-span-1 md:col-span-2">
                        <img src="{{ asset('images/UMN_Pc.png') }}" alt="UMN PC Logo" class="w-32 mb-4">
                        <p class="text-gray-400 mb-6">
                            UMN Programming Club is dedicated to fostering excellence in programming and algorithmic
                            thinking among students at Universitas Multimedia Nusantara.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-[#ff4d4d] transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/umnprogrammingclub/"
                                class="text-gray-400 hover:text-[#ff4d4d] transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href=" https://x.com/UMNProgClub"
                                class="text-gray-400 hover:text-[#ff4d4d] transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/company/umn-programming-club/"
                                class="text-gray-400 hover:text-[#ff4d4d] transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                                        clip-rule="evenodd" />
                                    <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                                </svg>

                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#about-us" class="text-gray-400 hover:text-[#ff4d4d] transition-colors">About
                                    Us</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-[#ff4d4d] transition-colors">Vision
                                    &
                                    Mission</a></li>
                            <li><a href="#Key" class="text-gray-400 hover:text-[#ff4d4d] transition-colors">Key
                                    Fields</a>
                            </li>
                            <li><a href="#gallery"
                                    class="text-gray-400 hover:text-[#ff4d4d] transition-colors">Gallery</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-white font-bold mb-4">Contact Us</h3>
                        <ul class="space-y-2">
                            <li class="text-gray-400">
                                <span class="block">Universitas Multimedia Nusantara</span>
                                <span class="block">Jl. Scientia Boulevard, Gading Serpong</span>
                                <span class="block">Tangerang, Banten 15811</span>
                            </li>
                            <li>
                                <a href="mailto:umnpc@umn.ac.id"
                                    class="text-gray-400 hover:text-[#ff4d4d] transition-colors">
                                    umnpc@umn.ac.id
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="mt-12 pt-8 border-t border-white/10 text-center">
                    <p class="text-gray-400">&copy; {{ date('Y') }} UMN Programming Club. All rights reserved.</p>
                </div>
            </div>
        </footer>

    </div>
<!--     -->


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, MotionPathPlugin);

            const navToggle = document.getElementById('nav-toggle');
            const navClose = document.getElementById('nav-close');
            const navDropdown = document.getElementById('nav-dropdown');
            const navArrow = document.querySelector('.nav-arrow');
            const navLinks = document.querySelectorAll('.nav-link');
            const navButtons = document.querySelectorAll('.nav-button');

            // dropdown animation
            const dropdownTl = gsap.timeline({ paused: true });
            let isMenuOpen = false;

            // dropdown timeline
            dropdownTl
                .to(navDropdown, {
                    y: '0%',
                    duration: 0.6,
                    ease: "power4.out"
                })
                .to([navLinks, navButtons], {
                    opacity: 1,
                    y: 0,
                    duration: 0.4,
                    stagger: 0.1,
                    ease: "power3.out"
                }, "-=0.3");

            // initial states
            gsap.set([navLinks, navButtons], { y: 30, opacity: 0 });
            gsap.set(navDropdown, { y: '-100%' });

            // Toggle menu 
            function openMenu() {
                isMenuOpen = true;
                dropdownTl.play();
                navToggle.style.opacity = '0';
                navToggle.style.pointerEvents = 'none';
                navClose.style.opacity = '1';
                navClose.style.pointerEvents = 'auto';
            }

            function closeMenu() {
                isMenuOpen = false;
                dropdownTl.reverse();

                gsap.to(navClose, {
                    opacity: 0,
                    duration: 0.3,
                    onComplete: () => {
                        navClose.style.pointerEvents = 'none';
                        navToggle.style.display = 'flex';
                        navToggle.style.pointerEvents = 'auto';
                        gsap.to(navToggle, {
                            opacity: 1,
                            duration: 0.3
                        });
                    }
                });
            }


            navToggle.addEventListener('click', () => {
                if (!isMenuOpen) {
                    openMenu();
                }
            });

            navClose.addEventListener('click', () => {
                if (isMenuOpen) {
                    closeMenu();
                }
            });

            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href');

                    closeMenu();

                    setTimeout(() => {
                        navToggle.style.display = 'flex';
                        navToggle.style.opacity = '1';
                        navToggle.style.pointerEvents = 'auto';

                        if (targetId === '#') {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        } else {
                            const targetElement = document.querySelector(targetId);
                            if (targetElement) {
                                targetElement.scrollIntoView({ behavior: 'smooth' });
                            }
                        }
                    }, 600);
                });

                link.addEventListener('mouseenter', () => {
                    gsap.to(link, {
                        scale: 1.1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                link.addEventListener('mouseleave', () => {
                    gsap.to(link, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });

            // floating animation
            gsap.to(navToggle, {
                y: "5px",
                duration: 1.5,
                repeat: -1,
                yoyo: true,
                ease: "power1.inOut"
            });

            // Navbar scroll effect
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // hover animations
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    gsap.to(link, {
                        scale: 1.05,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                link.addEventListener('mouseleave', () => {
                    gsap.to(link, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });

            // hover effect for toggle button
            navToggle.addEventListener('mouseenter', () => {
                gsap.to(navToggle, {
                    scale: 1.1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            navToggle.addEventListener('mouseleave', () => {
                gsap.to(navToggle, {
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll <= 0) {
                    navbar.style.transform = 'translateY(0)';
                    navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                    navbarLogo.classList.add('hidden');
                } else if (currentScroll > lastScroll) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                    navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
                    navbarLogo.classList.remove('hidden');
                }

                lastScroll = currentScroll;
            });

            // Animate sections on scroll
            gsap.utils.toArray('section').forEach((section) => {
                const elements = section.querySelectorAll('.animate-on-scroll');

                elements.forEach((el, index) => {
                    gsap.from(el, {
                        scrollTrigger: {
                            trigger: el,
                            start: "top 80%",
                            end: "bottom 20%",
                            toggleActions: "play none none reverse"
                        },
                        y: 50,
                        opacity: 0,
                        duration: 1,
                        ease: "power3.out",
                        delay: index * 0.2
                    });
                });
            });

            // Hero Animation
            const heroTl = gsap.timeline();
            heroTl
                .to('.hero-title', {
                    opacity: 1,
                    y: 0,
                    duration: 1.5,
                    ease: "elastic.out(1, 0.8)"
                })
                .to('.hero-text', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: "power3.out"
                }, "-=1")
                .to('.hero-buttons', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: "power3.out"
                }, "-=0.8");

            // Parallax Effect for Hero
            gsap.to('.hero-section-bg', {
                scrollTrigger: {
                    trigger: '.hero-section',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1
                },
                y: '30%',
                ease: 'none'
            });

            // Animate key fields title
            gsap.to('.key-fields-title', {
                opacity: 1,
                y: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: '.key-fields-title',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            gsap.utils.toArray('.field-card').forEach((card, i) => {
                gsap.from(card, {
                    opacity: 0,
                    y: 50,
                    duration: 1,
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 85%',
                        toggleActions: 'play none none reverse'
                    },
                    delay: i * 0.2
                });
            });

            const aboutSection = gsap.timeline({
                scrollTrigger: {
                    trigger: '.about-text',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Animate text elements
            aboutSection
                .to('.about-text h2', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out'
                })
                .to('.about-text p', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    stagger: 0.2,
                    ease: 'power3.out'
                }, '-=0.7')
                .to('.about-text a', {
                    opacity: 1,
                    y: 0,
                    duration: 1,
                    ease: 'power3.out'
                }, '-=0.7');

            // Animate stat cards
            gsap.to('.stat-card', {
                opacity: 1,
                y: 0,
                duration: 1,
                stagger: 0.15,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.stat-card',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Counter animation 
            const activeMembers = document.querySelector('.counter');
            let hasAnimated = false;

            ScrollTrigger.create({
                trigger: activeMembers,
                start: "top 80%",
                onEnter: () => {
                    if (!hasAnimated) {
                        animateCounter();
                        hasAnimated = true;
                    }
                },
                onLeaveBack: () => {
                    hasAnimated = false;
                }
            });

            function animateCounter() {
                gsap.fromTo(activeMembers,
                    { textContent: 0 },
                    {
                        textContent: 80,
                        duration: 2,
                        ease: 'power1.out',
                        snap: { textContent: 1 },
                        onUpdate: function () {
                            activeMembers.textContent = Math.ceil(this.targets()[0].textContent) + '+';
                        }
                    }
                );
            }

            // Logo Philosophy Section Animations
            gsap.to('.logo-title', {
                opacity: 1,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.logo-title',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            gsap.to('.logo-container', {
                opacity: 1,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.logo-container',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            gsap.to('.philosophy-item', {
                opacity: 1,
                y: 0,
                duration: 1,
                stagger: 0.2,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: '.philosophy-item',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Feature Cards Animation
            gsap.utils.toArray('.feature-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    },
                    y: 50,
                    opacity: 0,
                    duration: 1,
                    ease: "power3.out",
                    delay: i * 0.2
                });
            });

            // Animation for Gallery Title
            gsap.to('.gallery-title', {
                opacity: 1,
                scale: 1,
                duration: 1.2,
                ease: "power4.out",
                scrollTrigger: {
                    trigger: '.gallery-title',
                    start: 'top 80%',
                    toggleActions: 'play none none reverse'
                }
            });

            // Animation for Gallery Items
            gsap.utils.toArray('.gallery-item').forEach((item, i) => {
                gsap.from(item, {
                    opacity: 0,
                    y: 100,
                    duration: 1,
                    delay: i * 0.2,
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 85%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });
        });
    </script>
</body>