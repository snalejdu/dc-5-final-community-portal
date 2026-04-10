<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_members'       => User::where('role', 'member')->count(),
                'total_posts'         => Post::published()->count(),
                'total_announcements' => Post::published()->announcements()->count(),
                'total_reminders'     => Post::published()->reminders()->count(),
                'total_comments'      => Comment::count(),
            ],
            'recentPosts' => Post::published()
                ->with('author:id,name')
                ->withCount(['comments', 'reactions'])
                ->orderByDesc('published_at')
                ->take(5)
                ->get(),
        ]);
    }
}
