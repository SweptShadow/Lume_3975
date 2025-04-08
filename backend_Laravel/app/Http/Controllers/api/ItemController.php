<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showImage($id)
    {
        $item = Item::findOrFail($id);

        return response($item->image_data)
            ->header('Content-Type', $item->mime_type); 
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'image' => 'required|image|max:2048', // optional: limit size to 2MB
        ]);
    
        $image = $request->file('image');
    
        $item = new Item();
        $item->description = $request->description;
        $item->image_data = file_get_contents($image->getRealPath()); // Get binary data
        $item->mime_type = $image->getMimeType(); // e.g., image/jpeg
        $item->save();
    
        return back()->with('success', 'Image uploaded!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
