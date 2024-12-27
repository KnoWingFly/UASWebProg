@extends('layouts.app')

@section('content')
<style>
    .captcha {
        display: flex;
        flex-direction: column;
        /* Stack elements vertically */
        gap: 1rem;
        /* Add space between elements */
        margin-bottom: 1rem;
    }

    .captcha-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        /* Space between image and reload button */
    }

    .captcha img {
        border-radius: 4px;
        border: 1px solid #333;
        max-width: 200px;
        /* Control image width */
    }

    .reload-captcha {
        padding: 8px 12px;
        border-radius: 4px;
        background: #ff4d4d;
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        height: fit-content;
    }

    .reload-captcha:hover {
        background: #ff6666;
    }

    body,
    html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #151515;
        color: #fff;
        overflow-x: hidden;
    }

    .auth-container {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .forms-container {
        position: absolute;
        width: 200%;
        height: 100%;
        top: 0;
        left: 0;
        display: flex;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .forms-container.show-register {
        transform: translateX(-50%);
    }

    .split-container {
        min-height: 100vh;
        width: 50%;
        display: flex;
        align-items: stretch;
        opacity: 1;
        visibility: visible;
    }

    .welcome-text,
    .auth-form-container,
    .input-group,
    .auth-link {
        opacity: 0;
        transform: translateY(20px);
    }

    .decorative-side {
        display: none;
        background-color: #1a1a1a;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        width: 45%;
    }

    @media (min-width: 992px) {
        .decorative-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
    }

    .decorative-circle {
        position: absolute;
        border-radius: 50%;
        background: #ff4d4d;
        opacity: 0.1;
    }

    .form-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
    }

    .auth-form-container {
        width: 100%;
        max-width: 400px;
        opacity: 0;
        transform: translateY(20px);
    }

    .form-control {
        background-color: #1a1a1a;
        border: 2px solid #1a1a1a;
        color: #fff;
        padding: 12px;
        transition: all 0.3s ease;
        border-radius: 8px;
        height: auto;
    }

    .form-control:focus {
        background-color: #1a1a1a;
        border-color: #ff4d4d;
        color: #fff;
        box-shadow: 0 0 0 2px rgba(255, 77, 77, 0.2);
    }

    .auth-btn {
        background-color: #ff4d4d;
        border: none;
        padding: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        transform-origin: center;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: white;
    }

    .auth-btn:hover {
        background-color: #ff6666;
        transform: scale(1.02);
        color: white;
    }

    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
        opacity: 0;
        transform: translateX(-20px);
    }

    .input-label {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        transition: all 0.3s ease;
        pointer-events: none;
        font-size: 14px;
    }

    .form-control:focus+.input-label,
    .form-control:not(:placeholder-shown)+.input-label {
        top: -10px;
        left: 8px;
        font-size: 12px;
        color: #ff4d4d;
        background-color: #1a1a1a;
        padding: 0 4px;
    }

    .form-check-input {
        background-color: #1a1a1a;
        border-color: #666;
        width: 1.2em;
        height: 1.2em;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #ff4d4d;
        border-color: #ff4d4d;
    }

    .form-check-label {
        color: #666;
        cursor: pointer;
        user-select: none;
    }

    .auth-link {
        color: #ff4d4d;
        text-decoration: none;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        display: inline-block;
        cursor: pointer;
    }

    .auth-link:hover {
        color: #ff6666;
        transform: translateY(-2px);
    }

    .card {
        background-color: #1a1a1a;
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .welcome-text {
        position: relative;
        z-index: 1;
        opacity: 0;
        transform: translateY(20px);
    }

    .welcome-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #fff;
    }

    .welcome-text p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .invalid-feedback {
        color: #ff4d4d;
        font-size: 12px;
        margin-top: 4px;
    }

    .back-btn {
        position: absolute;
        top: 2rem;
        left: 2rem;
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .back-btn svg {
        width: 20px;
        height: 20px;
    }

    .back-btn:hover {
        color: #ff4d4d;
    }
</style>

<div class="auth-container">
    <div class="forms-container">
        <!-- Login Form -->
        <div class="split-container">
            <div class="form-side">
                <a href="/" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to Home
                </a>
                <div class="auth-form-container">
                    <div class="card">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4 title text-white">Login</h2>
                            <p class="text-center mb-4 subtitle" style="color: #666;">Welcome back! Please login to your
                                account.</p>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group">
                                    <input id="login-email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder=" ">
                                    <label class="input-label" for="login-email">Email Address</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <input id="login-password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder=" ">
                                    <label class="input-label" for="login-password">Password</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-check mb-3 text-start">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                                <button type="submit" class="btn auth-btn w-100 mb-3">
                                    Login
                                </button>

                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="auth-link mb-2 d-block" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    @endif
                                    <a class="auth-link" href="#register" onclick="toggleForms()">
                                        Don't have an account? Register
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="decorative-side">
                <div class="welcome-text">
                    <h1>Welcome Back!</h1>
                    <p>Log in to access your account and explore the latest in tech with UMN PC. Your journey continues
                        here.</p>
                </div>
            </div>
        </div>

        <!-- Register Form -->
        <div class="split-container">
            <div class="decorative-side">
                <div class="welcome-text">
                    <h1>Join Us Today!</h1>
                    <p>Create an account to start exploring the amazing world of technology with UMN PC. Your adventure
                        begins here.</p>
                </div>
            </div>
            <div class="form-side">
                <a href="/" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                    Back to Home
                </a>
                <div class="auth-form-container">
                    <div class="card">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4 title text-white">Create Account</h2>
                            <p class="text-center mb-4 subtitle" style="color: #666;">Join our community today</p>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="input-group">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" placeholder=" ">
                                    <label class="input-label" for="name">Full Name</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <input id="register-email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" placeholder=" ">
                                    <label class="input-label" for="register-email">Email Address</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <input id="register-password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder=" ">
                                    <label class="input-label" for="register-password">Password</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder=" ">
                                    <label class="input-label" for="password-confirm">Confirm Password</label>
                                </div>

                                <div class="input-group">
                                    <div class="captcha">
                                        <div class="captcha-row">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger reload-captcha" id="reload">
                                                ↻
                                            </button>
                                        </div>
                                        <input id="captcha" type="text"
                                            class="form-control @error('captcha') is-invalid @enderror" name="captcha"
                                            placeholder=" " required>
                                        <label class="input-label" for="captcha">Enter Captcha</label>
                                    </div>
                                    @error('captcha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn auth-btn w-100 mb-3">
                                    Create Account
                                </button>

                                <div class="text-center">
                                    <a class="auth-link" href="#login" onclick="toggleForms()">
                                        Already have an account? Sign in
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const firstPage = "{{ $firstPage ?? 'login' }}";
        let initialized = false;

        // Initial setup
        if (firstPage === 'register') {
            document.querySelector('.forms-container').classList.add('show-register');
        }

        // Create animated background circles
        document.querySelectorAll('.decorative-side').forEach(decorativeSide => {
            for (let i = 0; i < 5; i++) {
                const circle = document.createElement('div');
                circle.className = 'decorative-circle';
                const size = Math.random() * 300 + 100;
                circle.style.width = `${size}px`;
                circle.style.height = `${size}px`;
                circle.style.left = `${Math.random() * 100}%`;
                circle.style.top = `${Math.random() * 100}%`;
                decorativeSide.appendChild(circle);
            }
        });

        // Check URL hash on load
        if (window.location.hash === '#register') {
            document.querySelector('.forms-container').classList.add('show-register');
        }

        // Initial animations only
        if (!initialized) {
            initializeAnimations();
            initialized = true;
        }

        document.getElementById('reload').addEventListener('click', function () {
            fetch('/reload-captcha')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.captcha span').innerHTML = data.captcha;
                });
        });

    });

    function toggleForms() {
        const container = document.querySelector('.forms-container');
        container.classList.toggle('show-register');
    }

    function initializeAnimations() {
        // Animate circles only once
        gsap.to('.decorative-circle', {
            scale: 1.5,
            duration: 'random(3, 6)',
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            stagger: {
                amount: 2,
                from: 'random'
            }
        });

        // Initial animations for content
        const tl = gsap.timeline();

        tl.to('.welcome-text', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: 'power3.out'
        })
            .to('.auth-form-container', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.4')
            .to('.input-group', {
                opacity: 1,
                x: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: 'power3.out'
            }, '-=0.4')
            .to('.auth-link', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: 'power3.out',
                stagger: 0.1
            }, '-=0.2');

        // Button hover animations
        document.querySelectorAll('.auth-btn').forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, {
                    scale: 1.02,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            button.addEventListener('mouseleave', () => {
                gsap.to(button, {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });

        // Set all elements to their final state for smooth transitions
        gsap.set(['.welcome-text', '.auth-form-container', '.input-group', '.auth-link'], {
            opacity: 1,
            y: 0,
            x: 0,
            delay: 2 // After all animations complete
        });
    }
</script>
@endsection