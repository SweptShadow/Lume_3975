@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="landing-container">
    <div class="landing-left">
        <h1 class="landing-title">lumé</h1>
        <div class="landing-buttons">
            <a href="{{ route('discover') }}" class="btn btn-dark">DISCOVER</a>
            <a href="{{ route('ootd') }}" class="btn btn-dark">OOTD</a>
            <a href="{{ route('login') }}" class="btn btn-dark">Login/Signup</a>
        </div>
    </div>
    <div class="landing-right">
        <img src="{{ asset('images/landing1.jpeg') }}" alt="Placeholder" class="landing-image">
    </div>
</div>
@endsection