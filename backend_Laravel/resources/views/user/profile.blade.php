@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush
<div class="container">
    <h1 class="brand-title">lumé</h1>
</div>

<section class="profile-header">
    <div class="container">
        <h1 class="profile-username">Username</h1>
        
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-value">4</span>
                <span class="stat-label">Posts</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">16</span>
                <span class="stat-label">Likes</span>
            </div>
        </div>
    </div>
</section>

<main class="container">
    <h2 class="section-title">Username's Posts</h2>
    
    <div class="articles-grid">

        <!-- 
        {{--




        @forelse($articles as $article)



            <div class="article-card">
                <div class="article-image-container">
                    <img src="{{ route('article.image', $article->id) }}" alt="{{ $article->title }}" class="article-image">
                </div>
                <div class="article-content">
                    <h3 class="article-title">{{ $article->title }}</h3>
                    <p class="article-excerpt">
                        @if(strlen($article->description) > 100)
                            {{ substr($article->description, 0, 100) }}...
                        @else
                            {{ $article->description }}
                        @endif
                    </p>
                    <div class="article-meta">
                        <span class="article-likes">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor" />
                            </svg>
                            {{ $article->likes ?? 0 }} likes
                        </span>
                        @if(isset($article->created_at))
                            <span>{{ \Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</span>
                        @else
                            <span>Recently</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty


            <div class="no-articles">
                <p>No posts found.</p>
            </div>
        @endforelse


        @endsection



        --}}
        -->



        <!-- Static examples below - these will be replaced by the loop above when implementing backend -->
        
        <!-- Post 1 -->
        <div class="article-card">
            <div class="article-image-container">
                <img src="https://via.placeholder.com/300x200" alt="Post title" class="article-image">
            </div>
            <div class="article-content">
                <h3 class="article-title">Summer Collection</h3>
                <p class="article-excerpt">
                    Exploring the latest trends for summer 2025 with a focus on sustainable materials and bold colors...
                </p>
                <div class="article-meta">
                    <span class="article-likes">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor" />
                        </svg>
                        5 likes
                    </span>
                    <span>2 days ago</span>
                </div>
            </div>
        </div>
        
        <!-- Post 2 -->
        <div class="article-card">
            <div class="article-image-container">
                <img src="https://via.placeholder.com/300x200" alt="Post title" class="article-image">
            </div>
            <div class="article-content">
                <h3 class="article-title">Minimalist Accessories</h3>
                <p class="article-excerpt">
                    The beauty of simplicity in modern accessories and how to style them for maximum impact...
                </p>
                <div class="article-meta">
                    <span class="article-likes">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor" />
                        </svg>
                        8 likes
                    </span>
                    <span>1 week ago</span>
                </div>
            </div>
        </div>
        
        <!-- Post 3 -->
        <div class="article-card">
            <div class="article-image-container">
                <img src="https://via.placeholder.com/300x200" alt="Post title" class="article-image">
            </div>
            <div class="article-content">
                <h3 class="article-title">Sustainable Fashion</h3>
                <p class="article-excerpt">
                    Exploring eco-friendly materials and ethical production in the modern fashion industry...
                </p>
                <div class="article-meta">
                    <span class="article-likes">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor" />
                        </svg>
                        3 likes
                    </span>
                    <span>2 weeks ago</span>
                </div>
            </div>
        </div>
    </div>
</main>

