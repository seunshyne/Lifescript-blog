@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">✍️ Create a New Post</h2>

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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

          {{-- Categories --}}
        <label for="category">Category:</label>
        <select name="category_id" id="category" required class="border p-2 rounded">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
            @endforeach
        </select>
    
            {{-- Title --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   required>
        </div>
        
            {{-- Content --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Content</label>
            <textarea name="content" rows="5" 
                      class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('content') }}</textarea>
        </div>

            {{-- Image --}}
        <div>
            <label for="image">Featured Image:</label>
            <input type="file" name="image" class="border p-2 w-full mb-4">

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
        </div>    

        <div class="flex justify-between items-center">
            <a href="{{ route('posts.index') }}" 
               class="text-sm text-gray-600 hover:text-gray-800">← Back</a>

            <button type="submit" 
                    class="bg-indigo-500 hover:bg-indigo-600 text-white font-medium px-5 py-2 rounded-lg">
                Publish Post
            </button>
        </div>
    </form>
</div>
@endsection
