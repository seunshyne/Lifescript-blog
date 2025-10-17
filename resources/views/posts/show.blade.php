@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-2xl p-6 mt-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $post->title }}</h1>

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="Featured image for {{ $post->title }}"
                class="w-full h-auto rounded-lg mb-6 shadow">
        @endif


        <p class="text-sm text-gray-500 mb-6">
            Posted by
            <span class="font-semibold text-indigo-600">
                {{ $post->user ? $post->user->name : 'Unknown' }}
            </span>
            • {{ $post->created_at->diffForHumans() }}
        </p>

        <div class="text-gray-700 leading-relaxed mb-8">
            {!! nl2br(e($post->content)) !!}
        </div>

        <hr class="my-10 border-gray-300">

        <!-- Comments Section -->
        <div class="max-w-2xl mx-auto mt-10">
            <h3 class="text-2xl font-bold mb-5 text-gray-800">Comments (<span
                    id="commentCount">{{ $post->comments->count() }}</span>)</h3>

            <!-- Comments List -->
            @if($post->comments->isEmpty())
                <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg text-center text-gray-500">
                    No comments yet 😔<br>
                    Be the first to share your thoughts!
                </div>
            @else
                <div id="commentsContainer" class="space-y-5">
                    @foreach ($post->comments as $comment)
                        <div
                            class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 hover:shadow-md transition duration-200">
                            <div class="flex items-start space-x-3">
                                <!-- Avatar (optional placeholder) -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold">
                                        {{ strtoupper(substr($comment->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                </div>

                                <!-- Comment Body -->
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $comment->user->name ?? 'Anonymous' }}
                                        </h4>
                                        <span class="text-sm text-gray-500">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-gray-700 leading-relaxed">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            </div>


                            @if(auth()->id() === $comment->user_id || auth()->user()->hasRole('Admin'))
                                <div class="flex gap-3 text-sm mt-2">
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    @endforeach

                </div>
            @endif

            <!-- Divider -->
            <div class="border-t border-gray-200 my-8"></div>

            <!-- Add Comment Form -->
            @auth
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <h4 class="text-lg font-semibold mb-3 text-gray-800">Add a Comment</h4>

                    <form id="commentForm" action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <textarea name="body" id="commentBody" rows="4"
                            class="w-full border-gray-300 focus:ring-blue-400 focus:border-blue-400 rounded-lg shadow-sm p-3"
                            placeholder="Write your comment here..." required></textarea>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition duration-200">
                            Post Comment
                        </button>
                    </form>
                </div>
            @else
                <p class="text-gray-600 text-center mt-5">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login</a>
                    to leave a comment.
                </p>
            @endauth
        </div>

        {{-- Edit --}}
        <div class="flex items-center gap-4">
            @if($post->user_id === auth()->id())
                <a href="{{ route('posts.edit', $post->id) }}"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md">
                    ✏️ Edit
                </a>

                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                    onsubmit="return confirm('Delete this post?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md">
                        🗑️ Delete
                    </button>
                </form>
            @endif

            <a href="{{ route('posts.index') }}" class="ml-auto text-indigo-500 hover:text-indigo-700 font-medium text-sm">
                ← Back to all posts
            </a>
        </div>
    </div>
    <script>
        document.getElementById('commentForm').addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent page reload

            const form = e.target;
            const body = document.getElementById('commentBody').value;
            const post_id = form.querySelector('input[name="post_id"]').value;

            // Send AJAX request
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ body, post_id })
            });

            const result = await response.json();

            if (result.success) {
                // ✅ Add the new comment (with time)
                const comment = result.comment;
                const commentHTML = `
                    <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 hover:shadow-md transition duration-200">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold">
                                    ${comment.user.name.charAt(0).toUpperCase()}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <h4 class="font-semibold text-gray-800">${comment.user.name}</h4>
                                    <span class="text-sm text-gray-500">${comment.created_at}</span>
                                </div>
                                <p class="mt-2 text-gray-700 leading-relaxed">${comment.body}</p>
                            </div>
                        </div>
                    </div>
                `;

                document.getElementById('commentsContainer').insertAdjacentHTML('afterbegin', commentHTML);

                //Update the comment count instantly
                const countSpan = document.getElementById('commentCount');
                countSpan.textContent = parseInt(countSpan.textContent) + 1;

                //Pop visuals when count increases
                countSpan.classList.add('text-blue-500', 'font-bold');
                setTimeout(() => countSpan.classList.remove('text-blue-500', 'font-bold'), 700);

                // Reset form
                document.getElementById('commentBody').value = '';
            } else {
                alert('Something went wrong, please try again.');
            }
        });
    </script>


@endsection