<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel Blog')</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Optional: Add favicon or custom meta tags --}}
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    {{-- 🌐 NAVBAR --}}
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                {{-- Logo / Site Name --}}
                <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600 hover:text-indigo-800">
                    LaravelBlog
                </a>

                {{-- Navigation Links --}}
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-indigo-600 font-medium">
                        Posts
                    </a>

                    @auth
                        <a href="{{ route('posts.create') }}" 
                           class="text-gray-700 hover:text-indigo-600 font-medium">
                            New Post
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="ml-2 bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.form') }}" 
                           class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium">
                            Login
                        </a>

                        <a href="{{ route('register.form') }}" 
                           class="text-gray-700 hover:text-indigo-600 font-medium">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- 🧭 PAGE CONTENT --}}
    <main class="flex-grow max-w-4xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- ⚫ FOOTER --}}
    <footer class="bg-gray-100 border-t mt-10 py-4">
        <div class="text-center text-gray-500 text-sm">
            © {{ date('Y') }} LaravelBlog — Built with ❤️ using Laravel & Tailwind
        </div>
    </footer>

</body>
</html>
