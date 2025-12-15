<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    // Prikaz svih tagova
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('tags.index', compact('tags'));
    }

    // Forma za kreiranje
    public function create()
    {
        return view('tags.create');
    }

    // Čuvanje novog taga
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag je kreiran.');
    }

    // Forma za editovanje
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    // Ažuriranje taga
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag je ažuriran.');
    }

    // Brisanje taga
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', 'Tag je obrisan.');
    }
}
