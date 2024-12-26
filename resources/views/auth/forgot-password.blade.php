<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #151515;">
    <div id="resetCard" class="opacity-0 translate-y-10 w-full sm:max-w-md px-6 py-8 shadow-xl overflow-hidden sm:rounded-lg mx-4" style="background-color: #1a1a1a;">
        <div class="mb-4 text-sm text-gray-300">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-sm" style="color: #ff4d4d;">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form id="resetForm" method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            <div class="block">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                <input 
                    id="email" 
                    class="block w-full px-4 py-3 border border-gray-600 text-gray-300 rounded-md shadow-sm transition-all duration-200"
                    style="background-color: #151515; border-color: #333333;"
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus 
                    autocomplete="username"
                />
            </div>

            <div class="flex items-center justify-end">
                <button id="submitBtn" type="submit" 
                    class="px-6 py-3 text-white rounded-md transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2"
                    style="background-color: #ff4d4d; --tw-ring-color: rgba(255, 77, 77, 0.5);">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Initial animation
            gsap.to('#resetCard', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out'
            });

            const form = document.getElementById('resetForm');
            const submitBtn = document.getElementById('submitBtn');
            const emailInput = document.getElementById('email');

            form.addEventListener('submit', (e) => {
                // We don't prevent default anymore to allow form submission
                submitBtn.disabled = true;
                gsap.to(submitBtn, {
                    scale: 0.95,
                    duration: 0.2
                });
            });

            // Input focus animation
            emailInput.addEventListener('focus', () => {
                gsap.to(emailInput, {
                    scale: 1.02,
                    duration: 0.2
                });
            });

            emailInput.addEventListener('blur', () => {
                gsap.to(emailInput, {
                    scale: 1,
                    duration: 0.2
                });
            });

            // Button hover effect
            submitBtn.addEventListener('mouseenter', () => {
                submitBtn.style.backgroundColor = '#ff3333';
            });
            
            submitBtn.addEventListener('mouseleave', () => {
                submitBtn.style.backgroundColor = '#ff4d4d';
            });
        });
    </script>
</body>
</html>