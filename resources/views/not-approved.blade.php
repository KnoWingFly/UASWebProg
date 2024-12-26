@extends('layouts.app')

@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #151515; 
        overflow: hidden; 
    }

    .card {
        margin-top: 0; 
        position: relative; 
        z-index: 2; 
        background-color: #1a1a1a; 
        border: none;
        border-radius: 10px;
    }

    .decorative-circle {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, #ff4d4d, #ff8c42); 
        opacity: 0.2;
        z-index: 1; 
    }

    .alert-warning {
        background-color: #1a1a1a; 
        border: none;
        color: #ff4d4d;
    }

    .btn-secondary {
        background-color: #151515; 
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #ff4d4d; 
        color: white;
    }
</style>

<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; position: relative;">
    <div class="decorative-side"></div>
    
    <!-- Card Container -->
    <div class="card text-white shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4 text-center">
            <h2 class="mb-4">Account Pending Approval</h2>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="alert alert-warning">
                <p>Your account is currently under review by our administration.</p>
                <p>You cannot access the dashboard until your account is approved.</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('logout') }}" class="btn btn-secondary w-100">
                    Logout
                </a>
            </div>

            <div class="mt-3">
                <small>If you believe this is an error, please contact support.</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector('.decorative-side');
        const numberOfCircles = 20;
        for (let i = 0; i < numberOfCircles; i++) {
            const circle = document.createElement('div');
            circle.className = 'decorative-circle';
            const size = Math.random() * 150 + 50;
            circle.style.width = `${size}px`;
            circle.style.height = `${size}px`;
            circle.style.left = `${Math.random() * 100}%`;
            circle.style.top = `${Math.random() * 100}%`;
            container.appendChild(circle);
        }

        document.querySelectorAll('.decorative-circle').forEach(circle => {
            const randomX = Math.random() * window.innerWidth * (Math.random() > 0.5 ? 1 : -1);
            const randomY = Math.random() * window.innerHeight * (Math.random() > 0.5 ? 1 : -1);
            const duration = Math.random() * 6 + 5;

            gsap.to(circle, {
                x: randomX,
                y: randomY,
                duration: duration,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });

            gsap.to(circle, {
                opacity: Math.random() * 0.5 + 0.3,
                scale: Math.random() * 0.5 + 0.8,
                duration: duration,
                repeat: -1,
                yoyo: true,
                ease: 'power1.inOut'
            });
        });

        gsap.timeline()
            .fromTo('.card', { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 1, ease: 'power3.out' })
            .fromTo('.alert', { opacity: 0 }, { opacity: 1, duration: 1 }, '-=0.5')
            .fromTo('.btn', { opacity: 0 }, { opacity: 1, duration: 1 }, '-=0.5')
            .fromTo('.mt-3 small', { opacity: 0 }, { opacity: 1, duration: 1 }, '-=0.5');
    });
</script>

@endsection
