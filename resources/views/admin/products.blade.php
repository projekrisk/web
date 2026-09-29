@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.products.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Produk Baru</h1>
    </div>
</div>

@if ($errors->any())
<div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
    <div class="flex items-center gap-3 mb-2">
        <i class="fa-solid fa-triangle-exclamation text-red-600 dark:text-red-400"></i>
        <p class="font-medium text-red-800 dark:text-red-300">Terdapat kesalahan pada input Anda:</p>
    </div>
    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug URL <span class="text-red-500">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800 text-gray-500 text-sm">
                                domain.com/produk/
                            </span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required class="flex-1 min-w-0 block w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-r-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Slug dibuat otomatis dari nama produk, tapi bisa Anda edit manual (tanpa spasi, gunakan strip '-').</p>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select id="category" name="category" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Enterprise" {{ old('category') == 'Enterprise' ? 'selected' : '' }}>Enterprise (ERP, HRIS, dll)</option>
                            <option value="Retail" {{ old('category') == 'Retail' ? 'selected' : '' }}>Retail (POS, Kasir)</option>
                            <option value="Edukasi" {{ old('category') == 'Edukasi' ? 'selected' : '' }}>Edukasi (LMS, Sekolah)</option>
                            <option value="Kesehatan" {{ old('category') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan (Klinik, Apotek)</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Kategori Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Deskripsi Produk <span class="text-red-500">*</span></h2>
                <p class="text-sm text-gray-500 mb-3">Tuliskan deskripsi lengkap, fitur, dan spesifikasi. Format HTML diizinkan.</p>
                <div class="text-gray-900">
                    <textarea id="editor" name="description">{{ old('description') }}</textarea>
                </div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Optimasi SEO</h2>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Deskripsi (Maks 160 Karakter)</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Publikasi</h2>
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select id="status" name="status" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Tayang)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Produk
                </button>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Harga & Diskon</h2>
                <div class="space-y-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required placeholder="Contoh: 2999000" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                    <div>
                        <label for="strike_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Coret / Asli (Rp)</label>
                        <input type="number" id="strike_price" name="strike_price" value="{{ old('strike_price') }}" placeholder="Contoh: 4500000" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada diskon.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Media Foto</h2>
                <div class="space-y-4">
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Utama (Tampil di Katalog)</label>
                        <input type="file" id="featured_image" name="featured_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-white dark:hover:file:bg-slate-600 cursor-pointer">
                    </div>
                    <hr class="border-gray-100 dark:border-slate-700">
                    <div>
                        <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Galeri Produk (Bisa Pilih Banyak)</label>
                        <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-slate-700 dark:file:text-white dark:hover:file:bg-slate-600 cursor-pointer">
                        <p class="text-xs text-gray-500 mt-2">Pilih lebih dari satu gambar sekaligus untuk galeri halaman produk.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('input', function() {
            let slug = titleInput.value;
            slug = slug.toLowerCase()
                       .replace(/[^a-z0-9\s-]/g, '') 
                       .replace(/\s+/g, '-') 
                       .replace(/-+/g, '-');
            slugInput.value = slug;
        });

        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
<style>
    .ck-editor__editable {
        min-height: 250px;
        background-color: #f9fafb !important;
        color: #111827 !important;
    }
    .dark .ck-editor__editable {
        background-color: #0f172a !important;
        color: #f3f4f6 !important;
        border-color: #334155 !important;
    }
    .dark .ck-toolbar {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    .dark .ck-button {
        color: #f3f4f6 !important;
    }
    .dark .ck-button:hover {
        background-color: #334155 !important;
    }
</style>
@endsection