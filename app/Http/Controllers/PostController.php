<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('index', [
            'posts' => Post::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('image');
        $fileName = now()->timestamp . '_' . $file->getClientOriginalName();
        $data['image'] = Storage::putFileAs('posts', $file, $fileName);

        Post::create($data);
        return redirect()->route('posts.index')->with(['success' => 'Post created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // try {
        //     $post = Post::findOrFail($id);
        //     dd(Storage::temporaryUrl($post->image, now()->addHour()));
        // }catch (ModelNotFoundException $e) {
        //     return redirect()->back()->with('error', 'Post cannot be found.');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            return view('form', compact('post'));
        }catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Post cannot be found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $post = Post::findOrFail($id);

            if ($request->has('image')) {
                $file = $request->file('image');
                $data['image'] = Storage::putFileAs('posts', $file, now()->timestamp . '_' . $file->getClientOriginalName());
                Storage::delete($post->image);
            }
            
            $post->update($data);

            return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
        }catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Post cannot be found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            Storage::delete($post->image);
            $post->delete();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Post cannot be found.');
        }
    }
}
