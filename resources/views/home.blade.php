@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <h2>Welcome to the Home page</h2>
    <x-alert>
        This is an important alert message!
    </x-alert>

    <x-alert type="success">
        Profile updated successfully!
    </x-alert>

    <x-alert type="error">Something went wrong.</x-alert>

    <p>Normal page content goes here...</p>
@endsection