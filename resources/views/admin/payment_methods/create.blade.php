@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.payment_methods.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Rekening Baru</h1>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sm:p-8">
    
    <?php if ($errors->any()): ?>
        <div class="mb-6 text-sm text-red-500 bg-red-50 dark:bg-red-500/10 p-4 rounded-xl border border-red-200 dark:border-red-500/20">
            <ul class="list-disc list-inside">
                <?php foreach($errors->all() as$error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="{{ route('admin.payment_methods.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Bank / E-Wallet <span class="text-red-500">*</span></label>
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" required placeholder="Contoh: BCA, GoPay" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor Rekening <span class="text-red-500">*</span></label>
                <input type="text" name="account_number" value="{{ old('account_number') }}" required placeholder="Contoh: 1234-5678-90" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary font-mono transition-all">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Atas Nama (A.N) <span class="text-red-500">*</span></label>
                <input type="text" name="account_owner" value="{{ old('account_owner') }}" required placeholder="Contoh: PT Projekrisk" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Tampil <span class="text-red-500">*</span></label>
                <select name="status" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all cursor-pointer">
                    <option value="active" <?php echo (old('status') == 'active') ? 'selected' : ''; ?>>Active (Tampil di Invoice)</option>
                    <option value="inactive" <?php echo (old('status') == 'inactive') ? 'selected' : ''; ?>>Inactive (Sembunyikan)</option>
                </select>
                <p class="text-xs text-gray-500 mt-2"><i class="fa-solid fa-circle-info mr-1"></i> Rekening inactive tidak akan terlihat oleh pembeli.</p>
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t border-gray-100 dark:border-slate-700 pt-6">
            <button type="submit" class="bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan Rekening
            </button>
        </div>
    </form>
</div>
@endsection