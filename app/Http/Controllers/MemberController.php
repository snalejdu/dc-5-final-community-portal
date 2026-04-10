<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    public function profile(): Response
    {
        $user = Auth::user();

        return Inertia::render('Member/Profile', [
            'stats' => [
                'comments'     => $user->comments()->count(),
                'reactions'    => $user->reactions()->count(),
                'posts_viewed' => $user->postViews()->count(),
            ],
            'recentComments' => $user->comments()
                ->with('post:id,title')
                ->latest()
                ->take(10)
                ->get(),
        ]);
    }
}
