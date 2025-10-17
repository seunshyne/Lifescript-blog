<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;



class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'body' => 'required|string|max:500',
            'post_id' => 'required|exists:posts,id',
        ]);

        $data['user_id'] = Auth::id();
        $comment = Comment::create($data);

        //Eager load the user so we can send it back with full info
        $comment->load('user');

        //If the request JSON (AJAX), return data instead of redirect
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'body' => $comment->body,
                    'user' => [
                        'name' => $comment->user->name,
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ]
            ]);
        }

        return back()->with('success', 'Comment added successfully!');
    }

    public function edit(Comment $comment) {
        if(Auth::id() !== $comment->user_id && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized');
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment) {
        if(Auth::id() !== $comment->user_id && !Auth::user()->hasRole('Admin')) {
            abort(403, 'unauthorized');
        }

        $data = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $comment->update($data);

        return redirect()->route('posts.show', $comment->post_id);
    }

    public function destroy(Comment $comment) {
        if(Auth::id() !==$comment->user_id && !Auth::user()->hasRole('Admin')) {
            abort(403, 'unauthorized');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}


