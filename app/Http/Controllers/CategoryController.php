<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Prikaz svih kategorija
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    // Forma za kreiranje
    public function create()
    {
        return view('categories.create');
    }

    // Čuvanje nove kategorije
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategorija je kreirana.');
    }

    // Forma za editovanje
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Ažuriranje kategorije
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategorija je ažurirana.');
    }

    // Brisanje kategorije
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategorija je obrisana.');
    }
}
