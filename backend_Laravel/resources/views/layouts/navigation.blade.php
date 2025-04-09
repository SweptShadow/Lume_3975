@extends('layouts.master')


@push('styles')
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
@endpush

 
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-3" href="{{ route('welcome') }}">
            lumé
        </a>

        <div class="ms-auto">
            <ul class="navbar-nav d-flex flex-row gap-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('createPost') }}">CreatePost</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>



