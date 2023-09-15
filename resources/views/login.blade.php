@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="d-flex vh-100 align-items-center justify-content-center">
    <div style="width: 450px">
        <div class="card">
            <div class="card-body p-5">    
                <h3 class="text-center mb-5">Sign in</h3>
                
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="fa-solid fa-lg fa-circle-xmark me-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form action="/login" method="POST" id="loginForm">
                    @csrf

                    <div class="mb-4">
                        <label for="userLogin" class="form-label">Email</label>
                        <input type="text" id="userLogin" class="form-control" name="email" autocomplete="noautocomplete" value="{{ old('email') }}">
                        <div class="form-text">login: demo@example.com</div>
                    </div>

                    <div class="mb-4">
                        <label for="userPass" class="form-label">Password</label>
                        <input type="password" id="userPass" class="form-control" name="password" autocomplete="noautocomplete">
                        <div class="form-text">password: demo</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection