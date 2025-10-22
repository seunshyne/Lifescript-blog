<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard home
    public function index()
    {
        $userCount = User::count();
        $postCount = Post::count();
        $categoryCount = Category::count();

        return view('admin.dashboard', compact('userCount', 'postCount', 'categoryCount'));
    }

    // Manage posts
    public function managePosts()
    {
        $posts = Post::with('user', 'category')->latest()->get();
        return view('admin.posts', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully.');
    }

    // Manage users
    public function manageUsers()
    {
        $users = User::with('roles')->get();
        return view('admin.users', compact('users'));
    }

    public function makeAdmin(User $user)
    {
        $user->roles()->sync([1]); // assuming role ID 1 = admin
        return redirect()->route('admin.users')->with('success', "{$user->name} is now an admin.");
    }

    public function makeUser(User $user)
    {
        $user->roles()->sync([2]); // assuming role ID 2 = normal user
        return redirect()->route('admin.users')->with('success', "{$user->name} is now a regular user.");
    }

    // Manage categories
    public function manageCategories()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories')->with('success', 'Category added successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
