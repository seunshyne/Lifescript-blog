@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 Edit Post</h2>

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <label for="category">Category:</label>
            <select name="category_id" id="category" class="border p-2 rounded">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" rows="5"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-gray-800">← Back</a>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-5 py-2 rounded-lg">
                    Update Post
                </button>
            </div>
        </form>


    </div>
@endsection