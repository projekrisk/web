<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('product');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        
        $products = Product::where('status', 'active')->orderBy('name', 'asc')->get();

        return view('admin.documents.index', compact('documents', 'products'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->orderBy('name', 'asc')->get();
        return view('admin.documents.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:documents,slug',
            'status' => 'required|in:published,draft',
            'meta_description' => 'nullable|string|max:160',
            'content' => 'required|string',
        ]);

        Document::create($request->all());
        return redirect()->route('admin.documents.index')->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function edit(Document $document)
    {
        $products = Product::where('status', 'active')->orderBy('name', 'asc')->get();
        return view('admin.documents.edit', compact('document', 'products'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:documents,slug,' . $document->id,
            'status' => 'required|in:published,draft',
            'meta_description' => 'nullable|string|max:160',
            'content' => 'required|string',
        ]);

        $document->update($request->all());
        return redirect()->route('admin.documents.index')->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Dokumentasi berhasil dihapus!');
    }
}