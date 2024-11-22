@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Account Pending Approval</div>
                <div class="card-body text-center">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2>Account Not Approved</h2>
                    
                    <div class="alert alert-warning">
                        <p>Your account is currently under review by our administration.</p>
                        <p>You cannot access the dashboard until your account is approved.</p>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('logout') }}" class="btn btn-secondary">
                            Logout
                        </a>
                    </div>

                    <div class="mt-3 text-muted">
                        <small>If you believe this is an error, please contact support.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
