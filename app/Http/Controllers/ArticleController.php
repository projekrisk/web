<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name', 'asc')->get(); 
        
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
            'category' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'meta_description' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['featured_image']);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public_uploads');
            $data['featured_image'] = $path;
        }

        Article::create($data);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'category' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'meta_description' => 'nullable|string|max:160',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['featured_image', 'delete_featured_image']);

        if ($request->delete_featured_image == '1' && !$request->hasFile('featured_image')) {
            if ($article->featured_image && file_exists(public_path('uploads/' . $article->featured_image))) {
                unlink(public_path('uploads/' . $article->featured_image));
            }
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image && file_exists(public_path('uploads/' . $article->featured_image))) {
                unlink(public_path('uploads/' . $article->featured_image));
            }
            $path = $request->file('featured_image')->store('articles', 'public_uploads');
            $data['featured_image'] = $path;
        }

        $article->update($data);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->featured_image && file_exists(public_path('uploads/' . $article->featured_image))) {
            unlink(public_path('uploads/' . $article->featured_image));
        }
        
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}