<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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

        $data = $request->except(['featured_image', 'gallery', 'download_file']);$destinationPath = public_path('uploads');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        if ($request->hasFile('featured_image')) {$file = $request->file('featured_image');$fileName = time() . '_featured_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
            $data['featured_image'] =$fileName;
        }

        if ($request->hasFile('gallery')) {$galleryImages = [];
            foreach ($request->file('gallery') as $key =>$file) {
                $fileName = time() . '_gallery_' .$key . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
                $galleryImages[] =$fileName;
            }
            $data['gallery'] =$galleryImages;
        }

        if ($request->download_type == 'file' && $request->hasFile('download_file')) {$file = $request->file('download_file');$fileName = time() . '_download_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
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

        // Tangkap data dan hapus elemen array yg tidak langsung masuk ke DB
        $data = $request->except(['featured_image', 'gallery', 'download_file', 'delete_featured_image', 'delete_gallery']);$destinationPath = public_path('uploads');

        // ==========================================
        // 1. LOGIKA HAPUS / UPDATE FOTO UTAMA
        // ==========================================
        // Jika ada instruksi hapus foto utama DARI TOMBOL TONG SAMPAH
        if ($request->input('delete_featured_image') == '1') {
            if ($product->featured_image && File::exists($destinationPath . '/' .$product->featured_image)) {
                File::delete($destinationPath . '/' .$product->featured_image);
            }
            $data['featured_image'] = null; // Kosongkan field di DB
        }

        // Jika user mengupload foto utama yang baru
        if ($request->hasFile('featured_image')) {
            // Pastikan hapus foto lama dulu
            if ($product->featured_image && File::exists($destinationPath . '/' .$product->featured_image)) {
                File::delete($destinationPath . '/' .$product->featured_image);
            }
            $file = $request->file('featured_image');$fileName = time() . '_featured_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
            $data['featured_image'] =$fileName;
        }

        // ==========================================
        // 2. LOGIKA HAPUS / UPDATE GALERI FOTO
        // ==========================================
        $currentGallery = is_array($product->gallery) ?$product->gallery : [];

        // Jika ada instruksi hapus gambar galeri spesifik DARI TONG SAMPAH
        if ($request->has('delete_gallery') && is_array($request->delete_gallery)) {
            foreach ($request->delete_gallery as$fileToDelete) {
                // Hapus file fisik
                if (File::exists($destinationPath . '/' .$fileToDelete)) {
                    File::delete($destinationPath . '/' .$fileToDelete);
                }
                // Hapus file dari array currentGallery
                $currentGallery = array_filter($currentGallery, function($img) use ($fileToDelete) {
                    return $img !==$fileToDelete;
                });
            }
            // Susun ulang index array
            $currentGallery = array_values($currentGallery);
        }

        // Jika ada upload gambar galeri baru (akan MENGGABUNGKAN yang lama dan baru)
        if ($request->hasFile('gallery')) {
            // Uncomment blok di bawah ini JIKA Anda ingin upload baru MENIMPA SEMUA galeri lama
            /*
            foreach ($currentGallery as$oldImg) {
                if (File::exists($destinationPath . '/' .$oldImg)) {
                    File::delete($destinationPath . '/' .$oldImg);
                }
            }
            $currentGallery = []; 
            */

            foreach ($request->file('gallery') as $key =>$file) {
                $fileName = time() . '_gallery_' .$key . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
                $currentGallery[] =$fileName; // Gabungkan dengan galeri yang tersisa
            }
        }
        // Simpan array galeri akhir ke data (baik jika ada perubahan maupun tidak)
        $data['gallery'] =$currentGallery;


        // ==========================================
        // 3. LOGIKA FILE DOWNLOAD
        // ==========================================
        if ($request->download_type == 'file' &&$request->hasFile('download_file')) {
            if ($product->download_file && File::exists($destinationPath . '/' .$product->download_file)) {
                File::delete($destinationPath . '/' .$product->download_file);
            }
            $file = $request->file('download_file');$fileName = time() . '_download_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
            $data['download_file'] =$fileName;
        }

        if ($request->download_type == 'link' &&$product->download_type == 'file') {
            if ($product->download_file && File::exists($destinationPath . '/' .$product->download_file)) {
                File::delete($destinationPath . '/' .$product->download_file);
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
        $destinationPath = public_path('uploads');

        if ($product->featured_image && File::exists($destinationPath . '/' .$product->featured_image)) {
            File::delete($destinationPath . '/' .$product->featured_image);
        }

        if ($product->gallery && is_array($product->gallery)) {
            foreach ($product->gallery as$oldImg) {
                if (File::exists($destinationPath . '/' .$oldImg)) {
                    File::delete($destinationPath . '/' .$oldImg);
                }
            }
        }

        if ($product->download_type == 'file' &&$product->download_file && File::exists($destinationPath . '/' .$product->download_file)) {
            File::delete($destinationPath . '/' .$product->download_file);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus beserta file-nya!');
    }
}