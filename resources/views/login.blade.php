@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="d-flex vh-100 align-items-center justify-content-center">
    <div style="width: 400px">
        <div class="card">
            <div class="card-body p-5">    
                <h3 class="text-center mb-5">Sign in</h3>
                <form action="" method="POST" id="loginForm">
                    <div class="mb-3">
                        <label for="userLogin" class="form-label">Username or email</label>
                        <input type="text" id="userLogin" class="form-control" name="login">
                    </div>

                    <div class="mb-4">
                        <label for="userPass" class="form-label">Password</label>
                        <input type="password" id="userPass" class="form-control" name="password">
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