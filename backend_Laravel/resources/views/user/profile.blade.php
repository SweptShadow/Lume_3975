@extends('layouts.master')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush


<div class="container">
    <h1 class="brand-title" ><a href="main" style="color: inherit; text-decoration: none;">lumé</a></h1>
</div>


<nav class="navbar navbar-expand-lg navbar-light navbar-custom mb-4 bg-white">
        <div class="container">
            <div class="d-flex justify-content-center w-100">
                <ul class="navbar-nav d-flex flex-row justify-content-center">
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/createPost">Create Post</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<section class="profile-header">
    <div class="container">
        <h1 class="profile-username">{{ $username }}</h1>
        
        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-value">{{ $count }}</span>
                <span class="stat-label">Posts</span>
            </div>
            <div class="stat-item">
                <span class="stat-value">{{ $totalLikes }}</span>
                <span class="stat-label">Likes</span>
            </div>
        </div>
    </div>
</section>

<main class="container">
    <h2 class="section-title">{{ $username }}'s Posts</h2>
    
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
        
        @foreach ($articles as $article)
            <!-- Post 1 -->
            <div class="article-card">
                <div class="article-image-container">
                    <img src="{{ $article->img }}" alt="Post title" class="article-image">
                </div>
                <div class="article-content">
                    <h3 class="article-title">{{ $article->title }}</h3>
                    <p class="article-excerpt">
                        {{ $article->description }}
                    </p>
                    <div class="article-meta">
                        <span class="article-likes">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor" />
                            </svg>
                            {{ $article->likes }}
                        </span>
                    </div>
                </div>
            </div>
        

        @endforeach

    </div>
</main>

