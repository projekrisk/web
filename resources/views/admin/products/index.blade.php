@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Produk</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola semua produk digital dan aplikasi Anda di sini.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2 w-max">
        <i class="fa-solid fa-plus"></i> Produk Baru
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    
    <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
        <form method="GET" action="{{ route('admin.products.index') }}" id="filter-form" class="flex flex-wrap items-center gap-3">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter Kategori:</label>
            
            <div class="relative w-full sm:w-72" id="filter-search-container">
                <input type="hidden" name="category" id="filter_category" value="{{ request('category') }}">
                
                <div class="relative">
                    <input type="text" id="filter-search-input" value="{{ request('category') }}" placeholder="🔍 Cari kategori..." autocomplete="off" class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    <div class="absolute right-3 top-2.5 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                </div>

                <div id="filter-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden hidden">
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="" data-name="">
                        <div class="font-medium text-gray-500"><i class="fa-solid fa-list mr-1"></i> Semua Kategori</div>
                    </div>
                    <?php if(isset($categories)): ?>
                        <?php foreach($categories as $category): ?>
                            <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="{{ $category->name }}" data-name="{{ $category->name }}">
                                <div class="font-medium">{{ $category->name }}</div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            @if(request('category'))
                <a href="{{ route('admin.products.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors px-2">
                    <i class="fa-solid fa-circle-xmark"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Produk</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Kategori</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Harga</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                <?php if(count($products) > 0): ?>
                <?php foreach($products as $product): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="p-4">
                        <div class="flex items-center gap-4">
                            @if($product->featured_image)
                                <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white line-clamp-1 max-w-[250px]">{{ $product->name }}</p>
                                <a href="{{ url('/produk/'.$product->slug) }}" target="_blank" class="text-brand-primary text-xs hover:underline mt-0.5 inline-block">Lihat URL <i class="fa-solid fa-up-right-from-square text-[10px]"></i></a>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-gray-600 dark:text-gray-300">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold uppercase bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300">
                            {{ $product->category }}
                        </span>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @if($product->strike_price)
                            <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->strike_price, 0, ',', '.') }}</p>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($product->status == 'active')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 border border-green-200 dark:border-green-500/20">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-400 border border-gray-200 dark:border-slate-600">
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-brand-primary hover:bg-brand-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-brand-primary transition-colors" title="Edit">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            
                            <button type="button" onclick="openDeleteModal('{{ route('admin.products.destroy', $product->id) }}', '{{ addslashes($product->name) }}')" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors" title="Delete">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>Belum ada produk yang ditambahkan atau ditemukan.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
    
    @if ($products->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
        {{ $products->links() }}
    </div>
    @endif
</div>

<div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-content" class="relative bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Produk?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Apakah Anda yakin ingin menghapus produk <strong id="delete-product-name" class="text-gray-800 dark:text-gray-200"></strong>? Aksi ini akan memindahkan data ke tempat sampah (Soft Delete).</p>
        
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
    const deleteModal = document.getElementById('delete-modal');
    const deleteOverlay = document.getElementById('delete-overlay');
    const deleteContent = document.getElementById('delete-content');
    const deleteForm = document.getElementById('delete-form');
    const deleteProductName = document.getElementById('delete-product-name');

    window.openDeleteModal = function(actionUrl, productName) {
        deleteForm.action = actionUrl;
        deleteProductName.textContent = productName;
        
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

    if(deleteOverlay) {
        deleteOverlay.addEventListener('click', closeDeleteModal);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterSearchInput = document.getElementById('filter-search-input');
        const filterHiddenInput = document.getElementById('filter_category');
        const filterDropdown = document.getElementById('filter-dropdown-list');
        const filterOptions = filterDropdown.querySelectorAll('.filter-option');
        const filterForm = document.getElementById('filter-form');

        function updateDropdownList(keyword) {
            let visibleCount = 0;
            const maxVisible = 3;

            filterOptions.forEach(option => {
                const text = (option.getAttribute('data-name') || '').toLowerCase();
                const isMatch = option.getAttribute('data-value') === "" || text.includes(keyword);

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
                    filterHiddenInput.value = this.getAttribute('data-value');
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