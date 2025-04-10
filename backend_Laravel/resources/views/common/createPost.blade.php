@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/createPost.css') }}">
@endpush

@section('content')

    <div class="container">
        <div class="post-creation-container">
            <h1 class="brand-title">lumé</h1>
            <p class="page-subtitle">Create a new post</p>
            

            

            <div class="form-container">
                <form method="POST" action="{{ route('posts_store') }}" enctype="multipart/form-data" class="post-form">
                    @csrf
                    

                    <div class="form-left">


                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ session('username') }}" required autofocus readonly>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
            


                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
            


                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    
                    </div>
                    



                    <div class="form-right">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="image-preview-container">
                                <img id="preview" src="#" alt="Image Preview" class="image-preview">
                                <span class="image-placeholder">Select an image to preview</span>
                            </div>
                            
                            <input type="file" id="image" name="image" class="custom-file-input @error('image') is-invalid @enderror" accept="image/*" required>
                            <label for="image" class="custom-file-label">Choose Image</label>
                            
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    


                    <div class="btn-container">
                        <button type="submit" class="btn">Create Post</button>
                    </div>


                </form>
            </div>
        </div>
    </div>


    {{-- Need this js for event listner!! --}}
    <script>
        
        //This script handles the image preview functionality
        document.addEventListener('DOMContentLoaded', function() {

            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('preview');
            const imagePlaceholder = document.querySelector('.image-placeholder');
            const fileLabel = document.querySelector('.custom-file-label');
            
            //Set the initial state of the image preview and placeholder.
            imageInput.addEventListener('change', function() {

                const file = this.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.setAttribute('src', e.target.result);
                        imagePreview.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                        fileLabel.textContent = file.name;
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                    fileLabel.textContent = 'Choose Image';
                }
            });
        });
    </script>
@endsection