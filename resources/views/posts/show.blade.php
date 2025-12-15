@extends('layout')

@section('content')
<div class="container my-4">
    <h1 class="text-light">{{ $post->title }}</h1>
    <p class="text-muted">
        Autor: {{ $post->user->name }} | Kategorija: {{ $post->category?->name }}
    </p>
    
    <div class="mb-3">
        @foreach($post->tags as $tag)
            <span class="badge bg-secondary">{{ $tag->name }}</span>
        @endforeach
    </div>

    <div class="content text-light mb-4">
        {!! $post->content !!}
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-4">Nazad</a>

    {{-- Sekcija komentara --}}
    {{-- Sekcija komentara --}}
<h3 class="text-light mt-5">Komentari</h3>

@forelse($comments as $comment)
    <div class="card mb-2 bg-dark text-white">
        <div class="card-body">
            <p>{{ $comment->content }}</p>
            <small class="text-muted">
                Autor: {{ $comment->user->name }} | 
                {{ $comment->created_at->diffForHumans() }}
            </small>

            @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline float-end">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Da li želiš da obrišeš komentar?')">Obriši</button>
                </form>
            @endcan
        </div>
    </div>
@empty
    <p class="text-light">Nema komentara.</p>
@endforelse

{{-- Paginacija komentara --}}
<div class="mt-3">
    {{ $comments->links('pagination::bootstrap-5') }}
</div>


    {{-- Forma za dodavanje komentara --}}
    @auth
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label text-light">Dodaj komentar</label>
                <textarea name="content" id="content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Pošalji</button>
        </form>
    @else
        <p class="text-light mt-4">Morate biti prijavljeni da biste ostavili komentar.</p>
    @endauth
</div>
@endsection
