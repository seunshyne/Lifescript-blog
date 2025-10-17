@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <div class="max-w-4xl mx-auto mt-10">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">All Posts</h2>
            <a href="{{ route('posts.create') }}"
                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md">
                ➕ New Post
            </a>
        </div>

        {{-- Search and Filter --}}
        <form action="{{ route('posts.index') }}" method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                class="border border-gray-300 rounded-lg p-2 w-1/3 focus:outline-none focus:ring-2 focus:ring-indigo-400">

            <select name="category"
                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Search
            </button>

            @if(request('search') || request('category'))
                <a href="{{ route('posts.index') }}" class="ml-2 text-gray-600 underline hover:text-gray-800">Clear</a>
            @endif
        </form>

        {{-- Posts List --}}
        @forelse($posts as $post)
            <div class="bg-white shadow-md rounded-xl p-5 mb-6 hover:shadow-lg transition">
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-indigo-600 transition">
                        {{ $post->title }}
                    </a>
                </h3>

                <p class="text-sm text-gray-500 mb-3">
                    Posted by
                    <span class="font-semibold text-indigo-600">
                        {{ $post->user ? $post->user->name : 'Unknown' }}
                    </span>
                    • {{ $post->created_at->diffForHumans() }}
                </p>

                <p class="text-gray-700 mb-4 leading-relaxed">
                    {{ Str::limit($post->content, 150) }}
                </p>

                @if ($post->category)
                    <p class="text-sm text-gray-500 mt-2">
                        🏷️ Category:
                        <a href="{{ route('posts.index', ['category' => $post->category->id]) }} "class="font-medium text--600 hover:underline">{{ $post->category->name }}</a>
                    </p>
                @else
                    <p class="text-sm text-gray-400 mt-2 italic">No category assigned</p>
                @endif


                {{-- Action buttons --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('posts.show', $post->id) }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        🔍 Read More
                    </a>

                    @if($post->user_id === Auth::id() || (Auth::check() && Auth::user()->hasRole('Admin')))
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="text-sm text-blue-500 hover:text-blue-700 font-medium">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            onsubmit="return confirm('Delete this post?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">
                                🗑️ Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-600 text-center">No posts yet.
                <a href="{{ route('posts.create') }}" class="text-indigo-500 hover:text-indigo-700 font-medium">
                    Create one now!
                </a>
            </p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $posts->links() }}
    </div>
@endsection