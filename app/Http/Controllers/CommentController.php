<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    // --- Dodavanje komentara ---
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Komentar je dodat.');
    }

    // --- Brisanje komentara ---
    public function destroy(Comment $comment)
    {
        // Koristimo Gate::authorize, poziva se CommentPolicy::delete
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Komentar je obrisan.');
    }
}
