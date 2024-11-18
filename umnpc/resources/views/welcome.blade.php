<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Our Platform</h1>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @auth
            <p>You are logged in as {{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Log Out</button>
            </form>
        @else
            <p>
                <a href="{{ route('login') }}" class="btn btn-primary">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </p>
        @endauth
    </div>
</body>
</html>
