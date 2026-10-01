@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.articles.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Artikel</h1>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showCustomToast('error', 'Validasi Gagal', 'Silakan periksa kembali form isian Anda.');
    });
</script>
@endif

<form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="articleForm" novalidate>
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informasi Artikel</h2>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Artikel <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug URL <span class="text-red-500">*</span></label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-800 text-gray-500 text-sm">
                                domain.com/blog/
                            </span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}" required class="flex-1 min-w-0 block w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-r-lg focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        </div>
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Topik <span class="text-red-500">*</span></label>
                            <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-brand-primary hover:underline" target="_blank"><i class="fa-solid fa-plus"></i> Kelola Kategori</a>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <?php foreach($categories as$category): ?>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="category" value="{{ $category->name }}" class="peer sr-only" required {{ old('category', $article->category) ==$category->name ? 'checked' : '' }}>
                                <div class="rounded-full border border-gray-200 bg-gray-50 px-4 py-2 hover:bg-gray-100 peer-checked:border-brand-primary peer-checked:bg-blue-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800 dark:peer-checked:bg-brand-primary/20 dark:peer-checked:border-brand-primary transition-all flex items-center justify-center gap-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</span>
                                    <i class="fa-solid fa-circle-check text-brand-primary text-xs hidden peer-checked:block"></i>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Konten Artikel <span class="text-red-500">*</span></h2>
                <div class="text-gray-900">
                    <textarea id="editor" name="content" required>{{ old('content', $article->content) }}</textarea>
                </div>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Optimasi SEO</h2>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Deskripsi (Maks 160 Karakter)</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">{{ old('meta_description', $article->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Gambar Sampul</h2>
                <div class="space-y-4">
                    <div>
                        @if($article->featured_image)
                            <div class="relative w-full h-32 mb-2 group" id="featured-image-preview">
                                <img src="{{ asset('uploads/' . $article->featured_image) }}" alt="Sampul" class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-slate-700">
                                <button type="button" onclick="removeFeaturedImage()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Foto">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                            <input type="hidden" name="delete_featured_image" id="delete_featured_image" value="0">
                        @endif
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ganti Sampul</label>
                        <div class="relative">
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" onchange="toggleClearBtn('featured_image', 'clear_featured_btn')" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-brand-primary hover:file:bg-blue-100 dark:file:bg-slate-700 dark:file:text-white dark:hover:file:bg-slate-600 cursor-pointer">
                            <button type="button" id="clear_featured_btn" onclick="clearFileInput('featured_image', 'clear_featured_btn')" class="hidden absolute right-2 top-1.5 text-gray-400 hover:text-red-500 bg-white dark:bg-slate-800 p-1 rounded-md text-sm"><i class="fa-solid fa-xmark"></i> Batal</button>
                        </div>
                        @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Publikasi</h2>
                
                <div class="mb-6 relative" id="status-search-container">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <input type="hidden" name="status" id="status" value="{{ old('status', $article->status) }}" required>
                    
                    <div class="relative">
                        <input type="text" id="status-search-input" value="{{ old('status', $article->status) == 'published' ? 'Published (Terbit)' : 'Draft (Konsep)' }}" placeholder="🔍 Cari status..." autocomplete="off" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                        <div class="absolute right-3 top-3 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                    </div>

                    <div id="status-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl overflow-y-auto hidden custom-scrollbar">
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="published" data-name="Published (Terbit)">
                            <div class="font-medium"><i class="fa-solid fa-globe text-green-500 mr-1"></i> Published (Terbit)</div>
                        </div>
                        <div class="status-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white" data-value="draft" data-name="Draft (Konsep)">
                            <div class="font-medium"><i class="fa-solid fa-pen-ruler text-gray-400 mr-1"></i> Draft (Konsep)</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-3 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
                    <i class="fa-solid fa-save"></i> Perbarui Artikel
                </button>
            </div>

        </div>
    </div>
</form>

<!-- Modal Hapus Foto (Baru Ditambahkan) -->
<div id="delete-photo-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-photo-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-photo-content" class="relative bg-white dark:bg-slate-800 w-full max-w-sm rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Sampul?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Foto akan dihapus dari tampilan. Anda harus mengklik <strong>Perbarui Artikel</strong> untuk menyimpannya ke database secara permanen.</p>
        
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

<div id="validation-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="validation-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="validation-content" class="relative bg-white dark:bg-slate-800 w-full max-w-sm rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-500/20 text-brand-warning rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Form Belum Lengkap!</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Silakan isi semua kolom yang memiliki tanda bintang merah (*), termasuk memilih Topik Artikel.</p>
        <button id="close-validation" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-2.5 rounded-lg transition-colors">
            Baik, saya periksa
        </button>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // --- LOGIKA MODAL HAPUS FOTO ---
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
    // ---------------------------------

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
            let slug = titleInput.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            slugInput.value = slug;
        });

        ClassicEditor
            .create(document.querySelector('#editor'), { 
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'imageUpload', 'blockQuote', '|', 'undo', 'redo' ],
                extraPlugins: [ MyCustomUploadAdapterPlugin ]
            })
            .catch(error => { console.error(error); });

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

        const form = document.getElementById('articleForm');
        const modal = document.getElementById('validation-modal');
        const overlay = document.getElementById('validation-overlay');
        const content = document.getElementById('validation-content');
        const btnClose = document.getElementById('close-validation');
        let firstInvalidInput = null;

        function showModal() {
            modal.classList.remove('hidden'); modal.classList.add('flex');
            void modal.offsetWidth;
            overlay.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
        }

        function closeModal() {
            overlay.classList.add('opacity-0');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); if(firstInvalidInput) firstInvalidInput.focus(); }, 300);
        }

        btnClose.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);

        form.addEventListener('submit', function(e) {
            let isValid = true;
            firstInvalidInput = null;

            const requiredFields = form.querySelectorAll('input[required], select[required]');
            
            requiredFields.forEach(field => {
                if (field.type !== 'radio' && !field.value.trim()) {
                    isValid = false;
                    if(!firstInvalidInput) firstInvalidInput = field;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showModal(); 
            }
        });
    });
</script>

<style>
    .ck-editor__editable { min-height: 400px; background-color: #f9fafb !important; color: #111827 !important; }
    .dark .ck-editor__editable { background-color: #0f172a !important; color: #f3f4f6 !important; border-color: #334155 !important; }
    .dark .ck-toolbar { background-color: #1e293b !important; border-color: #334155 !important; }
    .dark .ck-button { color: #f3f4f6 !important; }
    .dark .ck-button:hover { background-color: #334155 !important; }
    .dark .ck-content, .dark .ck-content p, .dark .ck-content h1, .dark .ck-content h2, .dark .ck-content h3, .dark .ck-content h4, .dark .ck-content li { color: #f3f4f6 !important; }
</style>
@endsection