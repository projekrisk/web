@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.documents.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Dokumentasi</h1>
    </div>
</div>

<form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" id="documentForm" novalidate>
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Panduan</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $document->title) }}" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none">
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug URL <span class="text-red-500">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800 text-gray-500 text-sm">domain.com/docs/</span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $document->slug) }}" required class="flex-1 min-w-0 block w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-r-lg focus:ring-2 focus:ring-brand-primary outline-none">
                        </div>
                    </div>

                    <div class="relative" id="product-search-container">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Terkait Produk <span class="text-red-500">*</span></label>
                        <input type="hidden" name="product_id" id="product_id" value="{{ old('product_id', $document->product_id) }}" required>
                        
                        <div class="relative">
                            <input type="text" id="product-search-input" value="{{ $document->product->name ?? '' }}" placeholder="🔍 Ketik untuk mencari nama produk..." autocomplete="off" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none">
                            <div class="absolute right-3 top-3 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                        </div>

                        <div id="product-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden custom-scrollbar">
                            @foreach($products as $product)
                                <div class="product-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                    <div class="font-medium">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-400">Kategori: {{ $product->category }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Isi Dokumentasi <span class="text-red-500">*</span></h2>
                <textarea id="editor" name="content" required>{{ old('content', $document->content) }}</textarea>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Gambar Sampul</h2>
                @if($document->featured_image)
                    <img src="{{ asset('uploads/' . $document->featured_image) }}" alt="Sampul" class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-slate-700 mb-3">
                @endif
                <input type="file" id="featured_image" name="featured_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 cursor-pointer">
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Optimasi SEO</h2>
                <textarea id="meta_description" name="meta_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 outline-none">{{ old('meta_description', $document->meta_description) }}</textarea>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Publikasi</h2>
                
                <div class="mb-6 relative" id="status-search-container">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <input type="hidden" name="status" id="status" value="{{ old('status', $document->status) }}" required>
                    
                    <div class="relative">
                        <input type="text" id="status-search-input" value="{{ old('status', $document->status) == 'published' ? 'Published (Terbit)' : 'Draft (Konsep)' }}" placeholder="🔍 Cari status..." autocomplete="off" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none">
                        <div class="absolute right-3 top-9 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>

                    <div id="status-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl max-h-40 overflow-y-auto hidden custom-scrollbar">
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="published" data-name="Published (Terbit)">
                            <div class="font-medium"><i class="fa-solid fa-check text-green-500 mr-1"></i> Published (Terbit)</div>
                        </div>
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white" data-value="draft" data-name="Draft (Konsep)">
                            <div class="font-medium"><i class="fa-solid fa-pen-ruler text-gray-400 mr-1"></i> Draft (Konsep)</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-3 rounded-lg transition-colors shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-save mr-2"></i> Perbarui Dokumentasi
                </button>
            </div>

        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    class MyUploadAdapter {
        constructor(loader) { this.loader = loader; }
        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);
                fetch('{{ route("admin.upload_image") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: data
                })
                .then(res => res.json())
                .then(res => { res.error ? reject(res.error.message) : resolve({ default: res.url }); })
                .catch(() => reject('Gagal mengunggah gambar.'));
            }));
        }
        abort() {}
    }
    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        titleInput.addEventListener('input', function() {
            slugInput.value = titleInput.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-');
        });

        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'imageUpload', 'blockQuote', '|', 'undo', 'redo' ],
            extraPlugins: [ MyCustomUploadAdapterPlugin ]
        }).catch(err => console.error(err));

        const searchInput = document.getElementById('product-search-input');
        const hiddenInput = document.getElementById('product_id');
        const dropdown = document.getElementById('product-dropdown-list');
        const options = dropdown.querySelectorAll('.product-option');

        searchInput.addEventListener('focus', () => dropdown.classList.remove('hidden'));
        
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            dropdown.classList.remove('hidden');
            options.forEach(option => {
                const text = option.getAttribute('data-name').toLowerCase();
                if (text.includes(filter)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        options.forEach(option => {
            option.addEventListener('click', function() {
                hiddenInput.value = this.getAttribute('data-id');
                searchInput.value = this.getAttribute('data-name');
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', function(e) {
            if (!document.getElementById('product-search-container').contains(e.target)) {
                dropdown.classList.add('hidden');
            }
            if (!document.getElementById('status-search-container').contains(e.target)) {
                document.getElementById('status-dropdown-list').classList.add('hidden');
            }
        });

        const statusSearchInput = document.getElementById('status-search-input');
        const statusHiddenInput = document.getElementById('status');
        const statusDropdown = document.getElementById('status-dropdown-list');
        const statusOptions = statusDropdown.querySelectorAll('.status-option');

        statusSearchInput.addEventListener('focus', () => statusDropdown.classList.remove('hidden'));
        
        statusSearchInput.addEventListener('input', function() {
            const filter = statusSearchInput.value.toLowerCase();
            statusDropdown.classList.remove('hidden');
            statusOptions.forEach(option => {
                const text = option.getAttribute('data-name').toLowerCase();
                option.style.display = text.includes(filter) ? 'block' : 'none';
            });
        });

        statusOptions.forEach(option => {
            option.addEventListener('click', function() {
                statusHiddenInput.value = this.getAttribute('data-value');
                statusSearchInput.value = this.getAttribute('data-name');
                statusDropdown.classList.add('hidden');
            });
        });
    });
</script>
<style>
    .ck-editor__editable { min-height: 400px; background-color: #f9fafb !important; color: #111827 !important; }
    .dark .ck-editor__editable { background-color: #0f172a !important; color: #f3f4f6 !important; border-color: #334155 !important; }
    .dark .ck-toolbar { background-color: #1e293b !important; border-color: #334155 !important; }
    .dark .ck-button { color: #f3f4f6 !important; }
    .dark .ck-button:hover { background-color: #334155 !important; }
    
    .dark .ck-content, 
    .dark .ck-content p, 
    .dark .ck-content h1, 
    .dark .ck-content h2, 
    .dark .ck-content h3, 
    .dark .ck-content h4, 
    .dark .ck-content li { 
        color: #f3f4f6 !important; 
    }
</style>
@endsection