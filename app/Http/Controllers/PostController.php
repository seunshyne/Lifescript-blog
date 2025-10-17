<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        //Apply search filter if keyword exists
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orwhere('content', 'like', "%{$search}%")   ;   

        }

        // Category filter
        if($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $posts = $query->with('category')->orderBy('created_at', 'desc')->paginate(2);

        //Preserve the search tem across pagination links
        $posts->appends($request->only('search', 'category'));

        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,gif|max:2048',
        ]);

        $data['user_id']= Auth::id();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = $imagePath;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post created succefully!');
    }

    /**
     * Display the specified resource.
     */
     public function show(Post $post)
    {
        $post->load(['comments.user']); //Eager load comment + user

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $user = Auth::user();
        if ($user->id !== $post->user_id && !$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action');
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $user = Auth::user();

        if ($user->id !== $post->user_id && !$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'title' => 'required|min:3',
            'content' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $data['image'] = $imagePath;
        }
        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user = Auth::user();
        if($user->id !== $post->user_id && !$user->hasRole('Admin')) {
            abort(403, 'Unauthorized action');
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post was deleted successfully!');
    }
}
