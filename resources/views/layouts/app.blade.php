<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UMN PC') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-red: #ff4d4d;
            --dark-bg: #151515;
            --darker-bg: #1a1a1a;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
        }

        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: var(--dark-bg);
            color: var(--text-primary);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }

        #app {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: var(--darker-bg);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background-color: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.7rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: var(--text-primary) !important;
            font-weight: 600;
            font-size: 1.2rem;
            opacity: 0;
            transform: translateY(-10px);
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
        }

        .nav-link:hover {
            color: var(--primary-red) !important;
            background-color: rgba(255, 77, 77, 0.1);
            transform: translateY(-2px);
        }

        .dropdown-menu {
            background-color: var(--darker-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 0.5rem;
            margin-top: 0.5rem;
            border-radius: 8px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            color: var(--text-secondary);
            padding: 0.7rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 77, 77, 0.1);
            color: var(--primary-red);
            transform: translateX(5px);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            position: relative;
            background-color: transparent;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: none;
            position: relative;
            height: 2px;
            width: 24px;
            background-color: var(--text-primary);
            transition: all 0.3s ease;
            display: block;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            height: 2px;
            width: 24px;
            background-color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .navbar-toggler-icon::before {
            top: -6px;
        }

        .navbar-toggler-icon::after {
            bottom: -6px;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            background-color: transparent;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: rotate(45deg);
            top: 0;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: rotate(-45deg);
            bottom: 0;
        }

        main {
            flex: 1;
            padding-top: 76px;
            opacity: 0;
            transform: translateY(20px);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: var(--darker-bg);
                padding: 1rem;
                border-radius: 8px;
                margin-top: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }

            .nav-link {
                padding: 0.8rem 1rem;
                margin: 0.2rem 0;
            }
        }

        /* Loading Animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--darker-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-circle {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 77, 77, 0.2);
            border-top-color: var(--primary-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    
    <div id="app">
            @yield('content')
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize GSAP animations
        const tl = gsap.timeline();

        // Hide loader
        tl.to('.page-loader', {
            opacity: 0,
            duration: 0.5,
            onComplete: () => {
                document.querySelector('.page-loader').style.display = 'none';
            }
        })
        // Animate navbar elements
        .to('.navbar-brand', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: 'power3.out'
        })
        .to('.nav-link', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power3.out'
        }, '-=0.3')
        // Animate main content
        .to('main', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            ease: 'power3.out'
        }, '-=0.3');

        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            lastScroll = currentScroll;
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: target,
                        ease: 'power3.inOut'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>