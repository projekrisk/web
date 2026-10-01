@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.products.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Produk: {{ $product->name }}</h1>
    </div>
</div>

@if ($errors->any())
<div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
    <div class="flex items-center gap-3 mb-2">
        <i class="fa-solid fa-triangle-exclamation text-red-600 dark:text-red-400"></i>
        <p class="font-medium text-red-800 dark:text-red-300">Terdapat kesalahan pada input Anda:</p>
    </div>
    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400">
        @foreach ($errors->all() as$error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') 
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- KOLOM KIRI -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- INFO DASAR -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug URL <span class="text-red-500">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800 text-gray-500 text-sm">
                                domain.com/produk/
                            </span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required class="flex-1 min-w-0 block w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-r-lg focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kategori <span class="text-red-500">*</span></label>
                            <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-brand-primary hover:underline" target="_blank"><i class="fa-solid fa-plus"></i> Kelola</a>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            @forelse ($categories as$category)
                            <label class="cursor-pointer relative">
                                <input type="radio" name="category" value="{{ $category->name }}" class="peer sr-only" required {{ old('category', $product->category) ==$category->name ? 'checked' : '' }}>
                                <div class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 hover:bg-gray-100 peer-checked:border-brand-primary peer-checked:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800 dark:peer-checked:bg-brand-primary/20 dark:peer-checked:border-brand-primary transition-all flex items-center justify-center gap-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                                    <i class="fa-solid fa-circle-check text-brand-primary text-xs hidden peer-checked:block"></i>
                                </div>
                            </label>
                            @empty
                            <div class="w-full p-4 border border-dashed border-gray-300 dark:border-slate-600 rounded-lg text-center">
                                <p class="text-sm text-gray-500">Belum ada kategori.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Deskripsi Produk <span class="text-red-500">*</span></h2>
                <div class="text-gray-900">
                    <textarea id="editor" name="description">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
            
            <!-- SEO -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Optimasi SEO</h2>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Deskripsi (Maks 160 Karakter)</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
            </div>

            <!-- AKSES DOWNLOAD -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Akses Download</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe Pengiriman</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="download_type" value="link" class="text-brand-primary focus:ring-brand-primary" {{ old('download_type', $product->download_type) == 'link' ? 'checked' : '' }} onchange="toggleDownloadType()">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Link Eksternal</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="download_type" value="file" class="text-brand-primary focus:ring-brand-primary" {{ old('download_type', $product->download_type) == 'file' ? 'checked' : '' }} onchange="toggleDownloadType()">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Upload File</span>
                        </label>
                    </div>
                </div>

                <div id="link_input_container">
                    <label for="download_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL / Link Download</label>
                    <input type="url" name="download_link" id="download_link" value="{{ old('download_link', $product->download_link) }}" placeholder="https://drive.google.com/..." class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-brand-primary">
                </div>

                <div id="file_input_container" class="hidden">
                    @if($product->download_type == 'file' &&$product->download_file)
                        <div class="mb-2 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-center justify-between text-sm">
                            <span class="text-green-700 dark:text-green-400 font-medium truncate pr-2"><i class="fa-solid fa-file-zipper mr-1"></i> File tersimpan</span>
                        </div>
                    @endif
                    <label for="download_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ganti File ZIP/RAR</label>
                    <input type="file" name="download_file" id="download_file" accept=".zip,.rar,.pdf,.doc,.docx" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-slate-700 dark:file:text-white cursor-pointer">
                    <p class="text-[11px] text-gray-500 mt-1">Abaikan jika tidak ingin mengganti file.</p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN -->
        <div class="space-y-6">
            
            <!-- MEDIA FOTO -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Media Foto</h2>
                <div class="space-y-4">
                    <!-- FOTO UTAMA -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Utama</label>
                        @if($product->featured_image)
                            <div class="relative w-full h-32 mb-2 group" id="featured-image-preview">
                                <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="Foto Utama" class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-slate-700">
                                <button type="button" onclick="removeFeaturedImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Foto">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                            <input type="hidden" name="delete_featured_image" id="delete_featured_image" value="0">
                        @endif
                        <div class="relative mt-2">
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" onchange="toggleClearBtn('featured_image', 'clear_featured_btn')" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-white dark:hover:file:bg-slate-600 cursor-pointer">
                            <button type="button" id="clear_featured_btn" onclick="clearFileInput('featured_image', 'clear_featured_btn')" class="hidden absolute right-2 top-1.5 text-gray-400 hover:text-red-500 bg-white dark:bg-slate-800 p-1 rounded-md text-sm"><i class="fa-solid fa-xmark"></i> Batal</button>
                        </div>
                    </div>
                    
                    <hr class="border-gray-100 dark:border-slate-700">
                    
                    <!-- GALERI TAMBAHAN -->
                    <div>
                        <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Galeri Tambahan</label>
                        
                        <div id="deleted-gallery-inputs"></div>

                        @if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0)
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                @foreach ($product->gallery as $index =>$img)
                                    <div class="relative w-full aspect-square group" id="gallery-preview-{{ $index }}">
                                        <img src="{{ asset('uploads/' . $img) }}" class="w-full h-full object-cover rounded-md border border-gray-200 dark:border-slate-700">
                                        <button type="button" onclick="removeGalleryImage('{{ $img }}', 'gallery-preview-{{$index }}')" class="absolute top-1 right-1 bg-red-500/90 hover:bg-red-600 text-white w-6 h-6 rounded flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus dari Galeri">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="relative">
                            <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" onchange="toggleClearBtn('gallery', 'clear_gallery_btn')" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 dark:file:bg-slate-700 dark:file:text-white cursor-pointer">
                            <button type="button" id="clear_gallery_btn" onclick="clearFileInput('gallery', 'clear_gallery_btn')" class="hidden absolute right-2 top-1.5 text-gray-400 hover:text-red-500 bg-white dark:bg-slate-800 p-1 rounded-md"><i class="fa-solid fa-xmark"></i> Batal</button>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-1 text-orange-600 dark:text-orange-400">Peringatan: Mengunggah galeri baru akan menimpa seluruh galeri lama.</p>
                    </div>
                </div>
            </div>

            <!-- HARGA -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Harga & Diskon</h2>
                <div class="space-y-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', (int)$product->price) }}" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    </div>
                    <div>
                        <label for="strike_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Coret / Asli (Rp)</label>
                        <input type="number" id="strike_price" name="strike_price" value="{{ old('strike_price', (int)$product->strike_price) }}" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- DEMO -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Link Demo</h2>
                <div>
                    <label for="demo_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL Youtube / Web Demo (Opsional)</label>
                    <input type="url" id="demo_url" name="demo_url" value="{{ old('demo_url', $product->demo_url) }}" placeholder="https://..." class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    <p class="text-[11px] text-gray-500 mt-1">Kosongkan jika produk ini tidak memiliki video atau link live demo.</p>
                </div>
            </div>

            <!-- PUBLIKASI -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Publikasi</h2>
                
                <div class="mb-6 relative" id="status-search-container">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <input type="hidden" name="status" id="status" value="{{ old('status', $product->status) }}" required>
                    
                    <div class="relative">
                        <input type="text" id="status-search-input" value="{{ old('status', $product->status) == 'active' ? 'Active (Tayang)' : 'Draft (Sembunyikan)' }}" placeholder="🔍 Cari status..." autocomplete="off" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                        <div class="absolute right-3 top-3 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>

                    <div id="status-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl max-h-40 overflow-y-auto hidden custom-scrollbar">
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="active" data-name="Active (Tayang)">
                            <div class="font-medium"><i class="fa-solid fa-eye text-green-500 mr-1"></i> Active (Tayang)</div>
                        </div>
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white" data-value="draft" data-name="Draft (Sembunyikan)">
                            <div class="font-medium"><i class="fa-solid fa-eye-slash text-gray-400 mr-1"></i> Draft (Sembunyikan)</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-save"></i> Perbarui Produk
                </button>
            </div>

        </div>
    </div>
</form>

<!-- Modal Hapus Foto -->
<div id="delete-photo-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-photo-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-photo-content" class="relative bg-white dark:bg-slate-800 w-full max-w-sm rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Foto?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Foto akan dihapus dari tampilan. Anda harus mengklik <strong>Perbarui Produk</strong> untuk menyimpannya ke database secara permanen.</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white font-medium py-2.5 rounded-lg transition-colors">
                Batal
            </button>
            <button type="button" id="confirm-delete-btn" class="flex-1 bg-brand-danger hover:bg-red-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let deleteAction = null; 

    function openDeleteModal(actionCallback) {
        deleteAction = actionCallback;
        const modal = document.getElementById('delete-photo-modal');
        const overlay = document.getElementById('delete-photo-overlay');
        const content = document.getElementById('delete-photo-content');

        modal.classList.remove('hidden'); modal.classList.add('flex');
        void modal.offsetWidth; 
        overlay.classList.remove('opacity-0');
        content.classList.remove('scale-95', 'opacity-0');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-photo-modal');
        const overlay = document.getElementById('delete-photo-overlay');
        const content = document.getElementById('delete-photo-content');

        overlay.classList.add('opacity-0');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 300);
        deleteAction = null;
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', function() {
        if (typeof deleteAction === 'function') {
            deleteAction(); 
        }
        closeDeleteModal();
    });

    document.getElementById('delete-photo-overlay').addEventListener('click', closeDeleteModal);

    function removeFeaturedImage() {
        openDeleteModal(function() {
            document.getElementById('featured-image-preview').style.display = 'none';
            document.getElementById('delete_featured_image').value = '1';
        });
    }

    function removeGalleryImage(path, elementId) {
        openDeleteModal(function() {
            document.getElementById(elementId).style.display = 'none';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_gallery[]';
            input.value = path;
            document.getElementById('deleted-gallery-inputs').appendChild(input);
        });
    }

    function toggleClearBtn(inputId, btnId) {
        const input = document.getElementById(inputId);
        const btn = document.getElementById(btnId);
        if(input.files && input.files.length > 0) {
            btn.classList.remove('hidden');
        } else {
            btn.classList.add('hidden');
        }
    }

    function clearFileInput(inputId, btnId) {
        const input = document.getElementById(inputId);
        input.value = '';
        document.getElementById(btnId).classList.add('hidden');
    }

    function toggleDownloadType() {
        const type = document.querySelector('input[name="download_type"]:checked').value;
        if(type === 'link') {
            document.getElementById('link_input_container').classList.remove('hidden');
            document.getElementById('file_input_container').classList.add('hidden');
        } else {
            document.getElementById('link_input_container').classList.add('hidden');
            document.getElementById('file_input_container').classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleDownloadType(); 

        const titleInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        titleInput.addEventListener('input', function() {
            let slug = titleInput.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            slugInput.value = slug;
        });

        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
        }).catch(error => { console.error(error); });

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

        document.addEventListener('click', function(e) {
            if (!document.getElementById('status-search-container').contains(e.target)) {
                statusDropdown.classList.add('hidden');
            }
        });
    });
</script>
<style>
    .ck-editor__editable { min-height: 250px; background-color: #f9fafb !important; color: #111827 !important; }
    .dark .ck-editor__editable { background-color: #0f172a !important; color: #f3f4f6 !important; border-color: #334155 !important; }
    .dark .ck-toolbar { background-color: #1e293b !important; border-color: #334155 !important; }
    .dark .ck-button { color: #f3f4f6 !important; }
    .dark .ck-button:hover { background-color: #334155 !important; }
</style>
@endsection