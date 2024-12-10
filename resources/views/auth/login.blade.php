@extends('layouts.app')

@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #000; /* Match the background color */
    }

    .card {
        margin-top: 0; /* Remove any default margin */
    }
</style>
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #000;">
    <div class="card text-white shadow-lg" style="background-color: #121212; width: 100%; max-width: 400px; border-radius: 10px; border: none;">
        <div class="card-body p-4 text-center">
            <h2 class="mb-4">Login</h2>
            <p class="mb-4 ">Welcome back! Please login to your account.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="Email" 
                        autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check mb-3 text-start">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label ms-1" for="remember">
                        Remember Me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" style="background-color: #1e90ff; border: none;">
                    Login
                </button>
                <a href="{{ route('password.request') }}" class="text-">
                    Forget Password
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
