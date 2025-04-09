<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
/**
     * Add CORS headers to a response
     */
    private function addCorsHeaders($response)
    {
        return $response
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
    }

    /**
     * Handle OPTIONS preflight requests
     */
    public function options()
    {
        return $this->addCorsHeaders(response('', 200));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return $this->addCorsHeaders(response()->json($articles));
    }

    /**
     * Like a post
     */
    public function like($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('likes');
        
        return $this->addCorsHeaders(
            response()->json(['message' => 'Liked!', 'likes' => $article->likes])
        );
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'username' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            $image->move(public_path('uploads'), $imageName);
            
            $imagePath = 'uploads/' . $imageName;
        } else {
            return $this->addCorsHeaders(
                response()->json(['error' => 'Image is required'], 422)
            );
        }

        // Create and save the article
        $article = Article::create([
            'username' => $validated['username'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'img' => $imagePath ?? null,
            'likes' => 0
        ]);

        // Return JSON response with CORS headers
        return $this->addCorsHeaders(
            response()->json([
                'message' => 'Post created successfully!',
                'article' => $article
            ], 201)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return $this->addCorsHeaders(
                response()->json(['message' => 'Article not found'], 404)
            );
        }

        return $this->addCorsHeaders(
            response()->json($article)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
