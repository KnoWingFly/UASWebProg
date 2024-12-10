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
            <h2 class="mb-4">Register</h2>
            <p class="mb-4 ">Create a new account to get started.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <input 
                        id="name" 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Name" 
                        autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="Email">
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
                <div class="mb-3">
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="form-control" 
                        name="password_confirmation" 
                        required 
                        placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" style="background-color: #1e90ff; border: none;">
                    Register
                </button>
                <a href="{{ route('login') }}" class="text ">
                    Already have an account? Login here.
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
