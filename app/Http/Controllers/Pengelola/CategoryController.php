<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('events')
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pengelola.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('pengelola.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $category->loadCount('events');
        return view('pengelola.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100',
                       Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->events()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh event.');
        }

        $category->delete();

        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
