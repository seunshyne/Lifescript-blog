@extends('layouts.app')

@section('title', 'Manage Posts')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <h1 class="text-2xl font-bold mb-6">📰 Manage Posts</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Title</th>
                <th class="p-3">Author</th>
                <th class="p-3">Category</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr class="border-b">
                <td class="p-3">{{ $post->title }}</td>
                <td class="p-3">{{ $post->user->name ?? 'Unknown' }}</td>
                <td class="p-3">{{ $post->category->name ?? 'No Category' }}</td>
                <td class="p-3">
                    <form method="POST" action="{{ route('admin.posts.delete', $post) }}" onsubmit="return confirm('Delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" class="inline-block mt-6 text-blue-600 hover:underline">← Back to Dashboard</a>
</div>
@endsection
