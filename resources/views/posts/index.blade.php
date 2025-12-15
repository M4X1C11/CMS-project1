@extends('layout')

@section('content')
<div class="container my-4">
    <div class="mb-3">
        <h1 class="text-light">{{ $post->title }}</h1>
        <p class="text-muted">Autor: {{ $post->user->name }} | Kategorija: {{ $post->category?->name ?? '-' }}</p>

        <p>
            @foreach($post->tags as $tag)
                <span class="badge bg-secondary">{{ $tag->name }}</span>
            @endforeach
        </p>

        <div class="mt-3 text-white">
            {!! $post->content !!}
        </div>

        <p class="text-muted mt-3">Status: {{ ucfirst($post->status) }}</p>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-2">Nazad na listu</a>
    </div>

    {{-- Komentari --}}
    <div class="mt-5">
        <h3 class="text-light">Komentari ({{ $post->comments->count() }})</h3>

        @foreach($post->comments as $comment)
            <div class="mb-2 p-2 bg-dark text-white rounded">
                <strong>{{ $comment->user->name }}</strong> <span class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                <p>{{ $comment->content }}</p>

                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Obriši</button>
                    </form>
                @endif
            </div>
        @endforeach

        @if(auth()->check())
        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
            @csrf
            <textarea name="content" class="form-control mb-2" rows="3" placeholder="Ostavite komentar..." required></textarea>
            <button class="btn btn-primary">Dodaj komentar</button>
        </form>
        @else
            <p class="text-muted mt-2">Morate biti prijavljeni da biste ostavili komentar.</p>
        @endif
    </div>
</div>
@endsection
