<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'user');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews()->with('user')->get();
        return view('products.show', compact('product', 'reviews'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produit ajouté !');
    }

public function edit(Product $product)
{
    if ($product->user_id !== Auth::id()) {
        abort(403, 'Action non autorisée.');
    }
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
}

public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
        abort(403, 'Action non autorisée.');
    }
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produit modifié avec succès !');
    }

public function destroy(Product $product)
{
    if ($product->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
        abort(403, 'Action non autorisée.');
    }
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Produit supprimé !');
}

public function resolveRouteBinding($value, $field = null)
{
    return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
}
}
