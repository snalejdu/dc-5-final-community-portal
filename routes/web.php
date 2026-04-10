<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => inertia('Welcome'))->name('home');

Route::middleware(['auth'])->group(function () {

    // Feed
    Route::get('/feed', [PostController::class, 'index'])->name('feed');

    // Member profile
    Route::get('/member/profile', [MemberController::class, 'profile'])->name('member.profile');

    // Comments & Reactions
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/posts/{post}/reactions', [ReactionController::class, 'store'])->name('reactions.store');

    // ADMIN ONLY — must be defined BEFORE /posts/{post}
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');   // ← BEFORE {post}
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Wildcard route — MUST be LAST
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

});

require __DIR__.'/auth.php';
