<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()
            ->with(['author:id,name', 'reactions'])
            ->withCount(['comments', 'reactions', 'views'])
            ->orderByDesc('pinned')
            ->orderByDesc('published_at')
            ->paginate(10);

        $page = Auth::user()->isAdmin() ? 'Feed/Index' : 'Feed/MemberIndex';

        return Inertia::render($page, ['posts' => $posts]);
    }

    public function show(Post $post): Response
    {
        abort_if(!$post->isPublished(), 404);

        PostView::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        $post->load(['author:id,name', 'comments.author:id,name', 'reactions']);
        $post->loadCount(['comments', 'reactions', 'views']);

        $data = [
            'post'            => $post,
            'reactionSummary' => $post->reactionSummary(),
            'userReaction'    => $post->reactions()
                                      ->where('user_id', Auth::id())
                                      ->value('type'),
        ];

        $page = Auth::user()->isAdmin() ? 'Feed/Show' : 'Feed/MemberShow';

        return Inertia::render($page, $data);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Posts/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'         => 'required|in:announcement,reminder',
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'pinned'       => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['published_at'] = $validated['published_at'] ?? now();

        $post = Auth::user()->posts()->create($validated);

        return redirect()->route('posts.show', ['post' => $post->id])
                         ->with('success', 'Post published successfully.');
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Admin/Posts/Edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'type'         => 'required|in:announcement,reminder',
            'title'        => 'required|string|max:255',
            'body'         => 'required|string',
            'pinned'       => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $validated['published_at'] = $validated['published_at'] ?? now();

        $post->update($validated);

        return redirect()->route('posts.show', ['post' => $post->id])
                         ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('dashboard')
                         ->with('success', 'Post deleted.');
    }
}
