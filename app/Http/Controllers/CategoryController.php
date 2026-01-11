<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::query()
            ->with(['category', 'primaryImage'])
            ->byCategory($slug)
            ->active()
            ->inStock()
            ->paginate(12);

        $categories = Category::query()
            ->active()
            ->withCount(['activeProducts'])
            ->having('active_products_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('catalog.index', compact('products', 'categories', 'category'));
    }
}
