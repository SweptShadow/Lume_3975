<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Liked;
use Illuminate\Http\Request;

class LikedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    public function unlike($likeId)
    {
        $like = Liked::findOrFail($likeId);
        $article = $like->article;
    
        $like->delete();
    
        // Decrement counter
        $article->decrement('likes');
    
        return response()->json(['message' => 'Unliked!']);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Liked $liked)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Liked $liked)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Liked $liked)
    {
        //
    }
}
