@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Moderasi Ulasan Produk</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola rating dan tanggapan dari pembeli berbayar.</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    
    <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex flex-wrap items-center gap-3">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter:</label>
            
            <select name="rating" onchange="this.form.submit()" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-brand-primary outline-none cursor-pointer">
                <option value="">Semua Rating Bintang</option>
                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ (1 Bintang)</option>
            </select>

            <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-brand-primary outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved (Tayang)</option>
                <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Hidden (Disembunyikan)</option>
            </select>

            @if(request('rating') || request('status'))
                <a href="{{ route('admin.reviews.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors px-2">
                    <i class="fa-solid fa-circle-xmark"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[850px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Pembeli</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Produk</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Rating & Ulasan</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                <?php if(count($reviews) > 0): ?>
                    <?php foreach($reviews as $rev): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/30 text-brand-primary flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ substr($rev->user->name ?? 'User', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $rev->user->name ?? 'User Dihapus' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $rev->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <a href="{{ url('/produk/' . ($rev->product->slug ?? '#')) }}" target="_blank" class="font-semibold text-brand-primary hover:underline line-clamp-1 max-w-[200px]">
                                {{ $rev->product->name ?? 'Produk Dihapus' }}
                            </a>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $rev->created_at->format('d M Y, H:i') }}</p>
                        </td>
                        <td class="p-4">
                            <div class="flex text-yellow-400 text-xs mb-1.5">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?php echo $i <= $rev->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-slate-600'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-xs leading-relaxed max-w-sm">
                                "{{ $rev->comment }}"
                            </p>
                        </td>
                        <td class="p-4">
                            <?php if($rev->status === 'approved'): ?>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 text-xs font-bold rounded uppercase tracking-wider border border-green-200 dark:border-green-500/20">Approved</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400 text-xs font-bold rounded uppercase tracking-wider border border-gray-200 dark:border-slate-600">Hidden</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-md {{ $rev->status === 'approved' ? 'bg-orange-50 text-orange-600 hover:bg-orange-100 dark:bg-orange-500/10' : 'bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-500/10' }} transition-colors" title="{{ $rev->status === 'approved' ? 'Sembunyikan' : 'Tampilkan' }}">
                                        <i class="fa-solid {{ $rev->status === 'approved' ? 'fa-eye-slash' : 'fa-eye' }} text-xs"></i>
                                    </button>
                                </form>

                                <button type="button" onclick="openDeleteModal('{{ route('admin.reviews.destroy', $rev->id) }}', '{{ addslashes($rev->user->name ?? 'User') }}')" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors" title="Hapus">
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
                                <i class="fa-regular fa-comment-dots text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p>Belum ada ulasan yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    @if ($reviews->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
        {{ $reviews->links() }}
    </div>
    @endif
</div>

<div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-content" class="relative bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Ulasan?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Apakah Anda yakin ingin menghapus ulasan dari <strong id="delete-user-name" class="text-gray-800 dark:text-gray-200"></strong>? Aksi ini permanen.</p>
        
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
    const deleteUserName = document.getElementById('delete-user-name');

    function openDeleteModal(actionUrl, userName) {
        deleteForm.action = actionUrl;
        deleteUserName.textContent = userName;
        
        deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex');
        void deleteModal.offsetWidth;
        deleteOverlay.classList.remove('opacity-0');
        deleteContent.classList.remove('scale-95', 'opacity-0');
    }

    function closeDeleteModal() {
        deleteOverlay.classList.add('opacity-0');
        deleteContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { 
            deleteModal.classList.add('hidden'); deleteModal.classList.remove('flex'); 
        }, 300);
    }

    deleteOverlay.addEventListener('click', closeDeleteModal);
</script>
@endsection