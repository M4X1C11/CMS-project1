@extends('layout')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-light">Tagovi</h1>
        <a href="{{ route('tags.create') }}" class="btn btn-primary">Novi Tag</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Slug</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Da li si siguran da želiš da obrišeš?')">Obriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nema tagova za prikaz.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $tags->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
