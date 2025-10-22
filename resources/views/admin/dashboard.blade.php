@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">👨‍💼 Admin Dashboard</h1>

    <div class="grid grid-cols-3 gap-6">
        <div class="bg-blue-100 text-blue-700 p-6 rounded-2xl text-center">
            <h2 class="text-2xl font-bold">{{ $userCount }}</h2>
            <p class="text-sm">Total Users</p>
        </div>

        <div class="bg-green-100 text-green-700 p-6 rounded-2xl text-center">
            <h2 class="text-2xl font-bold">{{ $postCount }}</h2>
            <p class="text-sm">Total Posts</p>
        </div>

        <div class="bg-yellow-100 text-yellow-700 p-6 rounded-2xl text-center">
            <h2 class="text-2xl font-bold">{{ $categoryCount }}</h2>
            <p class="text-sm">Categories</p>
        </div>
    </div>

    <div class="mt-8 flex gap-4">
        <a href="{{ route('admin.posts') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Manage Posts</a>
        <a href="{{ route('admin.users') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Manage Users</a>
        <a href="{{ route('admin.categories') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">Manage Categories</a>
    </div>
</div>
@endsection
