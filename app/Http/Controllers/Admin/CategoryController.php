<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // READ + SEARCH
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {

            $query->where('name', 'LIKE', '%' . $search . '%');

        })->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // CREATE REDIRECT
    public function create()
    {
        return redirect()->route('categories.index');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // EDIT REDIRECT
    public function edit($id)
    {
        return redirect()->route('categories.index');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $id
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}