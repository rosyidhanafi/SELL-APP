<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product as ProductModel;
use App\Models\Category;

class ProductController extends Controller
{
    private function getViewPrefix()
    {
        return request()->routeIs('admin.products.*') ? 'admin.products' : 'products';
    }

    private function getIndexRoute()
    {
        return request()->routeIs('admin.products.*') ? 'admin.products.index' : 'products.index';
    }

    public function index()
    {
        $products = ProductModel::with('category')->paginate(4);
        $viewPrefix = $this->getViewPrefix();
        return view($viewPrefix . '.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $viewPrefix = $this->getViewPrefix();
        return view($viewPrefix . '.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_product_path' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        // dd($request->all());

        if ($request->hasFile('image_product_path')) {
            $path = $request->file('image_product_path')->store('products', 'public');
            $validated['image_product_path'] = $path;
        }

        ProductModel::create($validated);

        return redirect()->route($this->getIndexRoute())->with('success', 'Produk berhasil ditambahkan!');
    }

    public function toggleStatus($id)
    {
        $product = ProductModel::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return redirect()->route($this->getIndexRoute());
    }

    public function edit(ProductModel $product)
    {
        $categories = Category::all();
        $viewPrefix = $this->getViewPrefix();
        return view($viewPrefix . '.edit', compact('product', 'categories'));
    }

    public function update(Request $request, ProductModel $product)
    {
        $validated = $request->validate([
            'image_product_path' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if( $request->hasFile('image_product_path')) {
            $path = $request->file('image_product_path')->store('products', 'public');
            $validated['image_product_path'] = $path;
        }

        $product->update($validated);

        return redirect()->route($this->getIndexRoute())->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(ProductModel $product)
    {
        $product->delete();
        return redirect()->route($this->getIndexRoute())->with('success', 'Produk berhasil dihapus!');
    }
}
