@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('admin.users.index') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Pengguna Baru</h1>
</div>

<div class="max-w-3xl bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sm:p-8">
    
    <?php if ($errors->any()): ?>
        <div class="mb-6 text-sm text-red-500 bg-red-50 dark:bg-red-500/10 p-4 rounded-xl border border-red-200 dark:border-red-500/20">
            <ul class="list-disc list-inside">
                <?php foreach($errors->all() as$error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: John Doe" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor WhatsApp</label>
                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="Contoh: 08123456789" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kata Sandi (Password) <span class="text-red-500">*</span></label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-brand-primary transition-all">
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t border-gray-100 dark:border-slate-700 pt-6">
            <button type="submit" class="bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 w-full sm:w-auto">
                <i class="fa-solid fa-save"></i> Daftarkan Pengguna
            </button>
        </div>
    </form>
</div>
@endsection