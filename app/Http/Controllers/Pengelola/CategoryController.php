<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        return view('pengelola.categories.index');
    }

    public function create(): View
    {
        return view('pengelola.categories.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Category $category): View
    {
        return view('pengelola.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
