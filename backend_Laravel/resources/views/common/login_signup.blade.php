@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/login_signup.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="auth-container" id="authContainer">


    <!-- Login -->
    <div class="auth-panel">
        <div class="left-half">
            <div class="form-container">

                <h1 class="brand-title">lumé</h1>
                
                <!-- Need to fix the route -->
                {{-- <form method="POST" action="{{ route('welcome') }}" class="auth-form"> --}}
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn">
                            LOGIN
                        </button>
                    </div>



                    <div class="form-footer">
                        <a href="{{ route('signup') }}" class="btn-link" id="showSignupBtn">
                            Already have an account? Sign up
                        </a>
                    </div>
                {{-- </form> --}}
            </div>
        </div>

        <div class="right-half">
            <div class="image-container">
                <img src="{{ asset('images/LoginPage.jpg') }}" alt="Fashion" class="auth-image">
            </div>
        </div>
    </div>
    


    <!-- Signup  -->
    <div class="auth-panel">


        <div class="left-half">
            <div class="image-container">
                <img src="{{ asset('images/SignUpPage.jpg') }}" alt="Fashion" class="auth-image">
            </div>
        </div>


        <div class="right-half">
            <div class="form-container">
                <h1 class="brand-title">lumé</h1>
                

                <!-- Need to fix the route -->
                {{-- <form method="POST" action="{{ route('welcome') }}" class="auth-form"> --}}
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" class="form-control" name="name" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input id="register-email" type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <input id="register-password" type="password" class="form-control" name="password" required>
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn">
                            SIGN UP
                        </button>
                    </div>



                    <div class="form-footer">
                        <a href="{{ route('login') }}" class="btn-link" id="showLoginBtn">
                            Already have an account? Log in
                        </a>
                    </div>
                {{-- </form> --}}


            </div>
        </div>


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const authContainer = document.getElementById('authContainer');
        const showSignupBtn = document.getElementById('showSignupBtn');
        const showLoginBtn = document.getElementById('showLoginBtn');
        
        if (window.location.pathname === '/signup') {
            authContainer.classList.add('signup-mode');
        }
        
        if (showSignupBtn) {
            showSignupBtn.addEventListener('click', function(e) {
                e.preventDefault();
                authContainer.classList.add('signup-mode');
            });
        }
        
        if (showLoginBtn) {
            showLoginBtn.addEventListener('click', function(e) {
                e.preventDefault();
                authContainer.classList.remove('signup-mode');
            });
        }
    });
</script>
@endsection