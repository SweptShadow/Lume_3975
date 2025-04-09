@extends('layouts.master')


@push('styles')
    <link href="{{ asset('css/pending.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="pending-container">
        <div class="left-panel">
            <h1 class="brand-title">lumé</h1>
            <h2 class="pending-title">Account Approval Pending</h2>
            
            <div class="pending-icon">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="#333" stroke-width="1.5"/>
                    <path d="M12 6V12L16 14" stroke="#333" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <div class="status-indicator">
                <div class="status-dot active"></div>
                <div class="status-dot active"></div>
                <div class="status-dot active"></div>
            </div>
            
            <p class="pending-message">
                Thank you for signing up with lumé. Our team is reviewing your application. 
            </p>
            
            <a href="{{ route('welcome') }}" class="btn">Return to Homepage</a>
        </div>
        
        <div class="right-panel">
            <div class="image-overlay"></div>
            <img src="{{ asset('images/pending.jpg') }}" alt="Fashion" class="cover-image">
        </div>
    </div>
@endsection