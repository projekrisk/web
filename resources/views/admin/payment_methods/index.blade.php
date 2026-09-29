@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Rekening Pembayaran</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola tujuan transfer bank atau E-Wallet untuk tagihan member.</p>
    </div>
    <a href="{{ route('admin.payment_methods.create') }}" class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2 w-max">
        <i class="fa-solid fa-plus"></i> Tambah Rekening
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Info Rekening</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                <?php if(isset($paymentMethods) && count($paymentMethods) > 0): ?>
                    <?php foreach($paymentMethods as$method): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-500/10 text-brand-primary rounded-xl flex items-center justify-center text-xl shrink-0 border border-blue-100 dark:border-blue-500/20">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-base leading-tight">{{ $method->bank_name }}</p>
                                    <p class="text-gray-600 dark:text-gray-400 font-mono mt-0.5 text-sm">{{ $method->account_number }}</p>
                                    <p class="text-xs text-gray-500 mt-1">A.N <span class="font-medium text-gray-700 dark:text-gray-300">{{ $method->account_owner }}</span></p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <?php if($method->status == 'active'): ?>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 text-xs font-bold rounded uppercase tracking-wider border border-green-200 dark:border-green-500/20">Active</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-gray-400 text-xs font-bold rounded uppercase tracking-wider border border-gray-200 dark:border-slate-600">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.payment_methods.edit', $method->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-brand-primary hover:bg-brand-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-brand-primary transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                
                                <button type="button" onclick="openDeleteModal('{{ route('admin.payment_methods.destroy', $method->id) }}', '{{ addslashes($method->bank_name . ' - ' .$method->account_number) }}')" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-building-columns text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p>Belum ada data rekening pembayaran.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-content" class="relative bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Rekening?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Apakah Anda yakin ingin menghapus rekening <strong id="delete-bank-name" class="text-gray-800 dark:text-gray-200"></strong>? Aksi ini tidak dapat dibatalkan.</p>
        
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
    const deleteBankName = document.getElementById('delete-bank-name');

    function openDeleteModal(actionUrl, bankName) {
        deleteForm.action = actionUrl;
        deleteBankName.textContent = bankName;
        
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