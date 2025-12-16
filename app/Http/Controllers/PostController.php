<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // --- Prikaz svih postova sa pretragom i paginacijom ---
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])->latest();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->paginate(10)->appends($request->only('search'));

        return view('posts.index', compact('posts'));
    }

    // --- Prikaz jednog posta ---
public function show(Post $post)
{
    // Ako je URL slug različit od aktuelnog sluga u bazi → SEO redirect
    if (request()->route('post') !== $post->slug) {
        return redirect()
            ->route('posts.show', $post->slug)
            ->setStatusCode(301);
    }

    // Eager load relacija
    $post->load(['user', 'category', 'tags']);

    // Paginacija komentara
    $comments = $post->comments()
        ->with('user')
        ->latest()
        ->paginate(5);

    return view('posts.show', compact('post', 'comments'));
}

    // --- Forma za kreiranje posta ---
    public function create()
    {
        Gate::authorize('create', Post::class);

        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    // --- Čuvanje novog posta ---
    public function store(PostRequest $request)
    {
        Gate::authorize('create', Post::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $post = Post::create($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.index')->with('success', 'Post je kreiran.');
    }

    // --- Forma za uređivanje postojećeg posta ---
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    // --- Ažuriranje posta ---
    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $data = $request->validated();

        // Čuvamo stari slug ako se menja
        if ($post->slug !== Str::slug($data['title'])) {
            $post->old_slugs = array_merge($post->old_slugs ?? [], [$post->slug]);
        }

        $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);

        $post->update($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.index')->with('success', 'Post je ažuriran.');
    }

    // --- Brisanje posta ---
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post je obrisan.');
    }

    // --- Generisanje jedinstvenog sluga ---
    private function generateUniqueSlug($title, $postId = null)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (Post::where('slug', $slug)
            ->when($postId, fn($q) => $q->where('id', '!=', $postId))
            ->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
