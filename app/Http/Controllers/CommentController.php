<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'body'    => $validated['body'],
        ]);

        return back()->with('success', 'Comment posted.');
    }

    // Delete a comment (author or admin only)
    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        abort_unless(
            $user->isAdmin() || $comment->user_id === $user->id,
            403,
            'You cannot delete this comment.'
        );

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
