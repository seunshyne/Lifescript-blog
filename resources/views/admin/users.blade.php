@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10">
    <h1 class="text-2xl font-bold mb-6">👥 Manage Users</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Role</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->roles->pluck('name')->join(', ') ?: 'User' }}</td>
                <td class="p-3">
                    @if(!$user->roles->pluck('name')->contains('Admin'))
                        <form method="POST" action="{{ route('admin.users.makeAdmin', $user) }}">
                            @csrf
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm">Make Admin</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.users.makeUser', $user) }}">
                            @csrf
                            <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded-md text-sm">Demote</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" class="inline-block mt-6 text-blue-600 hover:underline">← Back to Dashboard</a>
</div>
@endsection
