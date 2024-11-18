<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMN Programming Club</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Custom Styles -->
    <style>
        /* Ensure full screen background images in slides */
        .swiper-slide {
            background-size: cover;
            background-position: center;
            height: 100vh; /* Ensure the image fills the viewport */
            position: relative;
        }

        .bg-slide-1 {
            background-image: url("{{ asset('storage/images/Umnpc.png') }}");
        }
        .bg-slide-2 {
            background-image: url("{{ asset('storage/images/umnpc2.jpg') }}");
        }

        /* Ensure content is layered above the background */
        .swiper-slide .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10; /* Ensure content is above the background */
            text-align: center;
        }

        .text-overlay {
            z-index: 20; /* Make sure the text overlay is above other elements */
            color: white;
        }

    </style>
</head>
<body class="bg-gray-100">
    <div class="relative">
        <!-- Navigation Section -->
        <div class="relative bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="#" class="mr-4 text-2xl font-bold">UMNPC</a>
                        <nav class="hidden md:block">
                            <ul class="flex space-x-4">
                                <li><a href="#" class="hover:text-gray-400">About</a></li>
                                <li><a href="#" class="hover:text-gray-400">Events</a></li>
                                <li><a href="#" class="hover:text-gray-400">Join</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Slideshow Section -->
        <div class="relative h-screen overflow-hidden">
            <!-- Swiper -->
            <div class="swiper backgroundSwiper absolute inset-0">
                <div class="swiper-wrapper">
                    <!-- Slide 1 with background -->
                    <div class="swiper-slide bg-slide-1">
                        <!-- Content for Slide 1 -->
                        <div class="content">
                            <h1 class="text-4xl font-bold text-white">UMN Programming Club</h1>
                            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">Sign Up</a>
                        </div>
                    </div>

                    <!-- Slide 2 with background -->
                    <div class="swiper-slide bg-slide-2">
                        <!-- Content for Slide 2 -->
                        <div class="content">
                            <h1 class="text-4xl font-bold text-white">UMN Programming Club</h1>
                            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper(".backgroundSwiper", {
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 3000, // Change image every 3 seconds
                    disableOnInteraction: false,
                },
                effect: 'fade', // Smooth fade transition
                fadeEffect: {
                    crossFade: true
                }
            });
        });
    </script>
</body>
</html>
