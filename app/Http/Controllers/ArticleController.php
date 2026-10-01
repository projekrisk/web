<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    // Fungsi bantuan agar 100% masuk ke public_html di Shared Hosting
    private function getUploadPath()
    {
        $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT']) 
                        ? rtrim($_SERVER['DOCUMENT_ROOT'], '/') 
                        : public_path();
        
        $destinationPath =$documentRoot . '/uploads';

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        return $destinationPath;
    }

    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('category')) {
            $query->where('category',$request->category);
        }

        $articles = $query->latest()->paginate(10)->withQueryString();$categories = Category::orderBy('name', 'asc')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'category' => 'required|string',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:160',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data =$request->except(['featured_image']);
        $destinationPath =$this->getUploadPath();

        if ($request->hasFile('featured_image')) {$file = $request->file('featured_image');$fileName = time() . '_article_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
            $data['featured_image'] =$fileName;
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article$article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'category' => 'required|string',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:160',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data =$request->except(['featured_image', 'delete_featured_image']);
        $destinationPath =$this->getUploadPath();

        // 1. Jika User Menekan Tombol Hapus Gambar (Tong Sampah)
        if ($request->input('delete_featured_image') == '1') {
            if ($article->featured_image && File::exists($destinationPath . '/' .$article->featured_image)) {
                File::delete($destinationPath . '/' .$article->featured_image);
            }
            $data['featured_image'] = null; // Kosongkan database
        }

        // 2. Jika User Mengunggah Gambar Baru
        if ($request->hasFile('featured_image')) {
            // Hapus gambar lama jika ada
            if ($article->featured_image && File::exists($destinationPath . '/' .$article->featured_image)) {
                File::delete($destinationPath . '/' .$article->featured_image);
            }
            
            $file = $request->file('featured_image');$fileName = time() . '_article_' . Str::random(5) . '.' . $file->getClientOriginalExtension();$file->move($destinationPath,$fileName);
            $data['featured_image'] =$fileName;
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $destinationPath =$this->getUploadPath();

        // Hapus file fisik gambar jika artikel dihapus
        if ($article->featured_image && File::exists($destinationPath . '/' .$article->featured_image)) {
            File::delete($destinationPath . '/' .$article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}