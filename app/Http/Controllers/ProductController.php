<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'strike_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,draft',
            'download_type' => 'required|in:link,file',
            'download_link' => 'nullable|url',
            'download_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx|max:51200',
            'demo_url' => 'nullable|url',
            'meta_description' => 'nullable|string|max:160',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data =$request->except(['featured_image', 'gallery', 'download_file']);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('products', 'public_uploads');
            $data['featured_image'] = $path;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public_uploads');
                $galleryPaths[] = $path;
            }
            $data['gallery'] = $galleryPaths; 
        }

        if ($request->hasFile('download_file')) {
            $path = $request->file('download_file')->store('products/files', 'public_uploads');
            $data['download_file'] = $path;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'strike_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,draft',
            'download_type' => 'required|in:link,file',
            'download_link' => 'nullable|url',
            'download_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx|max:51200',
            'demo_url' => 'nullable|url',
            'meta_description' => 'nullable|string|max:160',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['featured_image', 'gallery', 'download_file', 'delete_featured_image', 'delete_gallery']);

        if ($request->delete_featured_image == '1' && !$request->hasFile('featured_image')) {
            if ($product->featured_image && file_exists(public_path('uploads/' . $product->featured_image))) {
                unlink(public_path('uploads/' . $product->featured_image));
            }
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && file_exists(public_path('uploads/' . $product->featured_image))) {
                unlink(public_path('uploads/' . $product->featured_image));
            }
            $path = $request->file('featured_image')->store('products', 'public_uploads');
            $data['featured_image'] = $path;
        }

        $currentGallery = $product->gallery ?? [];

        if ($request->has('delete_gallery')) {
            foreach ($request->delete_gallery as $delImg) {
                if (in_array($delImg, $currentGallery)) {
                    if (file_exists(public_path('uploads/' . $delImg))) {
                        unlink(public_path('uploads/' . $delImg));
                    }
                    $currentGallery = array_diff($currentGallery, [$delImg]);
                }
            }
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public_uploads');
                $galleryPaths[] = $path;
            }
            $currentGallery = array_merge($currentGallery, $galleryPaths);
        }
        
        $data['gallery'] = array_values($currentGallery);

        if ($request->hasFile('download_file')) {
            if ($product->download_file && file_exists(public_path('uploads/' . $product->download_file))) {
                unlink(public_path('uploads/' . $product->download_file));
            }
            $path = $request->file('download_file')->store('products/files', 'public_uploads');
            $data['download_file'] = $path;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image && file_exists(public_path('uploads/' . $product->featured_image))) {
            unlink(public_path('uploads/' . $product->featured_image));
        }

        if ($product->gallery) {
            foreach ($product->gallery as $img) {
                if (file_exists(public_path('uploads/' . $img))) {
                    unlink(public_path('uploads/' . $img));
                }
            }
        }

        if ($product->download_file && file_exists(public_path('uploads/' . $product->download_file))) {
            unlink(public_path('uploads/' . $product->download_file));
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}