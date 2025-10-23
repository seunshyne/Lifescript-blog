<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Fetch all posts with author and category
        $posts = Post::with(['user', 'category'])->latest()->get();
        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        return new PostResource($post->load(['user', 'category']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $post = $request->user()->posts()->create($validated);

        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post); // optional if using policies

        $post->update($request->only('title', 'content', 'category_id'));
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // optional

        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
