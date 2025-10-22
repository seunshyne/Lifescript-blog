@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <h1 class="text-2xl font-bold mb-6">📂 Manage Categories</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 flex gap-3">
        @csrf
        <input type="text" name="name" placeholder="New category name" class="border border-gray-300 rounded-md px-3 py-2 w-1/2" required>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Add</button>
    </form>

    <table class="w-full text-left border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Category</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-b">
                <td class="p-3">{{ $category->name }}</td>
                <td class="p-3">
                    <form method="POST" action="{{ route('admin.categories.delete', $category) }}" onsubmit="return confirm('Delete this category?')">
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
