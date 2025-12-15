@extends('layout')

@section('content')
<div class="container my-4">
    <h1 class="text-light mb-4">Novi Post</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        {{-- Naslov --}}
        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        {{-- Kategorija --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategorija</label>
            <select name="category_id" class="form-select">
                <option value="">-- Izaberi kategoriju --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tagovi --}}
        <div class="mb-3">
            <label for="tags" class="form-label">Tagovi</label>
            <select name="tags[]" class="form-select" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sadržaj --}}
        <div class="mb-3">
            <label for="content" class="form-label">Sadržaj</label>
            <textarea name="content" id="content" class="form-control" rows="10" required>{{ old('content') }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        {{-- Dugmad --}}
        <button type="submit" class="btn btn-primary">Sačuvaj Post</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Nazad</a>
    </form>
</div>

{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content',
    menubar: false,
    plugins: 'link image code lists',
    toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist | link image | code',
    height: 400
});
</script>
@endsection
