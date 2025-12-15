@extends('layout')

@section('content')
<div class="container my-4">
    <h1 class="text-light mb-4">Novi Tag</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Naziv</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Sačuvaj Tag</button>
        <a href="{{ route('tags.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>
@endsection
