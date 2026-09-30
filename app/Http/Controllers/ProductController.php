<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category',$request->category);
        }

        $products = $query->latest()->paginate(10)->withQueryString();$categories = Category::orderBy('name', 'asc')->get();

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
            'category' => 'required|string',
            'description' => 'required|string',
            'meta_description' => 'nullable|string|max:160',
            'price' => 'required|numeric|min:0',
            'strike_price' => 'nullable|numeric|min:0',
            'demo_url' => 'nullable|url',
            'status' => 'required|in:active,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'download_type' => 'required|in:link,file',
            'download_link' => 'nullable|url|required_if:download_type,link',
            'download_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx|max:51200|required_if:download_type,file',
        ]);

        $data =$request->except(['featured_image', 'gallery', 'download_file']);

        // 1. Upload Featured Image (Foto Utama) menggunakan disk 'public_uploads'
        if ($request->hasFile('featured_image')) {
            $file =$request->file('featured_image');
            $fileName = time() . '_featured_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            // Simpan ke disk public_uploads (langsung ke public/uploads)
            Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
            $data['featured_image'] =$fileName;
        }

        // 2. Upload Gallery (Multiple Foto)
        if ($request->hasFile('gallery')) {$galleryImages = [];
            foreach ($request->file('gallery') as$key => $file) {$fileName = time() . '_gallery_' . $key . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
                $galleryImages[] =$fileName;
            }
            $data['gallery'] =$galleryImages;
        }

        // 3. Upload File Download (ZIP/RAR)
        if ($request->download_type == 'file' &&$request->hasFile('download_file')) {
            $file =$request->file('download_file');
            $fileName = time() . '_download_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
            $data['download_file'] =$fileName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product$product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'category' => 'required|string',
            'description' => 'required|string',
            'meta_description' => 'nullable|string|max:160',
            'price' => 'required|numeric|min:0',
            'strike_price' => 'nullable|numeric|min:0',
            'demo_url' => 'nullable|url',
            'status' => 'required|in:active,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'download_type' => 'required|in:link,file',
            'download_link' => 'nullable|url|required_if:download_type,link',
            'download_file' => 'nullable|file|mimes:zip,rar,pdf,doc,docx|max:51200',
        ]);

        $data =$request->except(['featured_image', 'gallery', 'download_file', 'delete_featured_image', 'delete_gallery']);

        // ==========================================
        // 1. LOGIKA HAPUS / UPDATE FOTO UTAMA
        // ==========================================
        if ($request->input('delete_featured_image') == '1') {
            if ($product->featured_image && Storage::disk('public_uploads')->exists($product->featured_image)) {
                Storage::disk('public_uploads')->delete($product->featured_image);
            }
            $data['featured_image'] = null; 
        }

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && Storage::disk('public_uploads')->exists($product->featured_image)) {
                Storage::disk('public_uploads')->delete($product->featured_image);
            }
            $file =$request->file('featured_image');
            $fileName = time() . '_featured_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
            $data['featured_image'] =$fileName;
        }

        // ==========================================
        // 2. LOGIKA HAPUS / UPDATE GALERI FOTO
        // ==========================================
        $currentGallery = is_array($product->gallery) ?$product->gallery : [];

        if ($request->has('delete_gallery') && is_array($request->delete_gallery)) {
            foreach ($request->delete_gallery as$fileToDelete) {
                if (Storage::disk('public_uploads')->exists($fileToDelete)) {
                    Storage::disk('public_uploads')->delete($fileToDelete);
                }
                $currentGallery = array_filter($currentGallery, function($img) use ($fileToDelete) {
                    return $img !==$fileToDelete;
                });
            }
            $currentGallery = array_values($currentGallery);
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as$key => $file) {$fileName = time() . '_gallery_' . $key . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
                $currentGallery[] =$fileName; 
            }
        }
        $data['gallery'] =$currentGallery;


        // ==========================================
        // 3. LOGIKA FILE DOWNLOAD
        // ==========================================
        if ($request->download_type == 'file' &&$request->hasFile('download_file')) {
            if ($product->download_file && Storage::disk('public_uploads')->exists($product->download_file)) {
                Storage::disk('public_uploads')->delete($product->download_file);
            }
            $file =$request->file('download_file');
            $fileName = time() . '_download_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public_uploads')->put($fileName, file_get_contents($file));
            $data['download_file'] =$fileName;
        }

        if ($request->download_type == 'link' &&$product->download_type == 'file') {
            if ($product->download_file && Storage::disk('public_uploads')->exists($product->download_file)) {
                Storage::disk('public_uploads')->delete($product->download_file);
            }
            $data['download_file'] = null;
        }

        if ($request->download_type == 'file' && $product->download_type == 'link') {$data['download_link'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image && Storage::disk('public_uploads')->exists($product->featured_image)) {
            Storage::disk('public_uploads')->delete($product->featured_image);
        }

        if ($product->gallery && is_array($product->gallery)) {
            foreach ($product->gallery as$oldImg) {
                if (Storage::disk('public_uploads')->exists($oldImg)) {
                    Storage::disk('public_uploads')->delete($oldImg);
                }
            }
        }

        if ($product->download_type == 'file' && $product->download_file && Storage::disk('public_uploads')->exists($product->download_file)) {
            Storage::disk('public_uploads')->delete($product->download_file);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus beserta file-nya!');
    }
}