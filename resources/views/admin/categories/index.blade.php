@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.create') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Kategori Produk</h1>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 p-6 sticky top-24">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tambah Baru</h2>
            
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-500 bg-red-50 dark:bg-red-500/10 p-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kategori</label>
                    <input type="text" id="name" name="name" required placeholder="Contoh: Enterprise" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                </div>
                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-medium py-2 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori
                </button>
            </form>
        </div>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Nama Kategori</th>
                        <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Slug</th>
                        <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4 font-bold text-gray-900 dark:text-white">{{ $category->name }}</td>
                        <td class="p-4 text-gray-500 dark:text-gray-400">{{ $category->slug }}</td>
                        <td class="p-4 text-right">
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-2" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-500">Belum ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection