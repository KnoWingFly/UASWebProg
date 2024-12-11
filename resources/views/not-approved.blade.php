@extends('layouts.app')

@section('content')
<style>
    body, html {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        background-color: #000; /* Match the dark background */
    }

    .card {
        margin-top: 0; /* Remove default margin */
    }
</style>
<div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #000;">
    <div class="card text-white shadow-lg" style="background-color: #121212; width: 100%; max-width: 400px; border-radius: 10px; border: none;">
        <div class="card-body p-4 text-center">
            <h2 class="mb-4">Account Pending Approval</h2>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="alert alert-warning" style="background-color: #1f1f1f; border: none; color: #ffa500;">
                <p>Your account is currently under review by our administration.</p>
                <p>You cannot access the dashboard until your account is approved.</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('logout') }}" class="btn btn-secondary w-100" style="background-color: #444; border: none;">
                    Logout
                </a>
            </div>

            <div class="mt-3 ">
                <small>If you believe this is an error, please contact support.</small>
            </div>
        </div>
    </div>
</div>
@endsection
