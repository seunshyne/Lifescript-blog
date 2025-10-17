@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
    <h2 class="text-2xl font-bold mb-4">Edit Comment</h2>

    <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <textarea name="body" rows="4" class="w-full border rounded-lg p-3">{{ old('body', $comment->body) }}</textarea>

        <div class="flex justify-between items-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold">
                Update Comment
            </button>

            <a href="{{ route('posts.show', $comment->post_id) }}" class="text-gray-500 hover:underline">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
