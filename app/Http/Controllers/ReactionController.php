<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    // Toggle reaction — if same type clicked again it removes it
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,love,haha,sad,angry',
        ]);

        $existing = $post->reactions()
                         ->where('user_id', Auth::id())
                         ->first();

        if ($existing) {
            if ($existing->type === $validated['type']) {
                // Same reaction — remove it (toggle off)
                $existing->delete();
            } else {
                // Different reaction — update it
                $existing->update(['type' => $validated['type']]);
            }
        } else {
            // No reaction yet — create it
            $post->reactions()->create([
                'user_id' => Auth::id(),
                'type'    => $validated['type'],
            ]);
        }

        return back()->with([
            'reactionSummary' => $post->reactionSummary(),
            'userReaction'    => $post->reactions()
                                      ->where('user_id', Auth::id())
                                      ->value('type'),
        ]);
    }
}
