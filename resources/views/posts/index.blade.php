@extends('layout')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-light">Postovi</h1>
        @auth
            @if(in_array(auth()->user()->role, [App\Models\User::ROLE_ADMIN, App\Models\User::ROLE_EDITOR]))
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Novi Post</a>
            @endif
        @endauth
    </div>

    {{-- Flash poruke --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Pretraga --}}
    <form action="{{ route('posts.index') }}" method="GET" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Pretraga po naslovu..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Pretraži</button>
    </form>

    {{-- Lista postova --}}
    <div class="row g-3">
        @forelse($posts as $post)
            <div class="col-md-4">
                <div class="card bg-dark text-white h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text text-muted mb-2">
                            Autor: {{ $post->user->name }}
                        </p>
                        <p class="text-muted mb-1">
                            Kategorija: {{ $post->category?->name ?? '-' }}
                        </p>
                        <p class="mb-2">
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}</p>
                        <p class="text-muted mt-auto">Status: {{ ucfirst($post->status) }}</p>

                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-info">Pogledaj</a>

                            @auth
                                @if(in_array(auth()->user()->role, [App\Models\User::ROLE_ADMIN, App\Models\User::ROLE_EDITOR]))
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Da li si siguran da želiš da obrišeš?')">Obriši</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $post->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-light">Nema postova za prikaz.</p>
        @endforelse
    </div>

    {{-- Paginacija --}}
    <div class="mt-4">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
