@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dokumentasi Produk</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola panduan teknis dan tutorial untuk produk Anda.</p>
    </div>
    <a href="{{ route('admin.documents.create') }}" class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2 w-max">
        <i class="fa-solid fa-plus"></i> Tulis Dokumentasi
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    
    <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
        <form method="GET" action="{{ route('admin.documents.index') }}" id="filter-form" class="flex flex-wrap items-center gap-3">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter Produk:</label>
            
            <div class="relative w-full sm:w-72" id="filter-search-container">
                <input type="hidden" name="product_id" id="filter_product_id" value="{{ request('product_id') }}">
                
                @php
                    $selectedProduct = request('product_id') ? $products->firstWhere('id', request('product_id')) : null;
                @endphp
                
                <div class="relative">
                    <input type="text" id="filter-search-input" value="{{ $selectedProduct ? $selectedProduct->name : '' }}" placeholder="🔍 Ketik nama produk..." autocomplete="off" class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    <div class="absolute right-3 top-2.5 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                </div>

                <div id="filter-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl max-h-[145px] overflow-y-auto hidden custom-scrollbar">
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-id="" data-name="">
                        <div class="font-medium text-gray-500"><i class="fa-solid fa-list mr-1"></i> Semua Produk</div>
                    </div>
                    @foreach($products as $product)
                        <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                            <div class="font-medium">{{ $product->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(request('product_id'))
                <a href="{{ route('admin.documents.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors px-2">
                    <i class="fa-solid fa-circle-xmark"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Judul Panduan</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Terkait Produk</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                @forelse ($documents as $doc)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="p-4">
                        <p class="font-bold text-gray-900 dark:text-white line-clamp-1 max-w-[300px]">{{ $doc->title }}</p>
                        <a href="{{ route('front.document', $doc->slug) }}" target="_blank" class="text-brand-primary text-xs hover:underline mt-0.5 inline-block">Lihat dokumentasi <i class="fa-solid fa-up-right-from-square text-[10px]"></i></a>
                    </td>
                    <td class="p-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300 border border-gray-200 dark:border-slate-600">
                            <i class="fa-solid fa-box-open text-brand-primary"></i> {{ $doc->product->name ?? 'Produk Dihapus' }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($doc->status == 'published')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-brand-primary dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20">
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-400 border border-gray-200 dark:border-slate-600">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.documents.edit', $doc->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-brand-primary hover:bg-brand-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-brand-primary transition-colors" title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            
                            <button type="button" onclick="openDeleteModal('{{ route('admin.documents.destroy', $doc->id) }}', '{{ addslashes($doc->title) }}')" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors" title="Delete">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-book-open text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>Belum ada dokumentasi yang ditulis.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    
    @if ($documents->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
        {{ $documents->links() }}
    </div>
    @endif
</div>

<div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-content" class="relative bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Dokumentasi?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Apakah Anda yakin ingin menghapus panduan <strong id="delete-doc-name" class="text-gray-800 dark:text-gray-200"></strong>? Data yang dihapus tidak bisa dikembalikan.</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white font-medium py-2.5 rounded-lg transition-colors">
                Batal
            </button>
            <form id="delete-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-brand-danger hover:bg-red-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('delete-modal');
        const deleteOverlay = document.getElementById('delete-overlay');
        const deleteContent = document.getElementById('delete-content');
        const deleteForm = document.getElementById('delete-form');
        const deleteDocName = document.getElementById('delete-doc-name');

        window.openDeleteModal = function(actionUrl, docName) {
            deleteForm.action = actionUrl;
            deleteDocName.textContent = docName;
            
            deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex');
            void deleteModal.offsetWidth; 
            deleteOverlay.classList.remove('opacity-0');
            deleteContent.classList.remove('scale-95', 'opacity-0');
        }

        window.closeDeleteModal = function() {
            deleteOverlay.classList.add('opacity-0');
            deleteContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { 
                deleteModal.classList.add('hidden'); deleteModal.classList.remove('flex'); 
            }, 300);
        }

        deleteOverlay.addEventListener('click', closeDeleteModal);

        const filterSearchInput = document.getElementById('filter-search-input');
        const filterHiddenInput = document.getElementById('filter_product_id');
        const filterDropdown = document.getElementById('filter-dropdown-list');
        const filterOptions = filterDropdown.querySelectorAll('.filter-option');
        const filterForm = document.getElementById('filter-form');

        function updateDropdownList(keyword) {
            let visibleCount = 0;
            const maxVisible = 3;

            filterOptions.forEach(option => {
                const text = (option.getAttribute('data-name') || '').toLowerCase();
                const isMatch = option.getAttribute('data-id') === "" || text.includes(keyword);

                if (isMatch && visibleCount < maxVisible) {
                    option.style.display = 'block';
                    visibleCount++;
                } else {
                    option.style.display = 'none';
                }
            });
        }

        if(filterSearchInput) {
            filterSearchInput.addEventListener('focus', () => {
                filterDropdown.classList.remove('hidden');
                updateDropdownList(filterSearchInput.value.toLowerCase());
            });
            
            filterSearchInput.addEventListener('input', function() {
                filterDropdown.classList.remove('hidden');
                updateDropdownList(this.value.toLowerCase());
            });

            filterOptions.forEach(option => {
                option.addEventListener('click', function() {
                    filterHiddenInput.value = this.getAttribute('data-id');
                    filterSearchInput.value = this.getAttribute('data-name'); 
                    filterDropdown.classList.add('hidden');
                    
                    filterForm.submit();
                });
            });

            document.addEventListener('click', function(e) {
                if (!document.getElementById('filter-search-container').contains(e.target)) {
                    filterDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection