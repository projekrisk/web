@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ringkasan data dan performa sistem Projekrisk.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2 w-max">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-500/10 text-brand-primary flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-box"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produk</p>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-green-100 dark:bg-green-500/10 text-brand-success flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-file-lines"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Artikel</p>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalArticles) }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pesanan</p>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalOrders) }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-orange-100 dark:bg-orange-500/10 text-brand-warning flex items-center justify-center text-xl shrink-0">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Aktif</p>
            <h4 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalMembers) }}</h4>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
    <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-white dark:bg-slate-800">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">5 Produk Terbaru</h2>
        <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-brand-primary hover:text-brand-primaryHover transition-colors">
            Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
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
                
                <?php if(count($recentProducts) > 0): ?>
                    <?php foreach($recentProducts as$product): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                @if($product->featured_image)
                                    <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-700 shrink-0">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-500 shrink-0">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white line-clamp-1 max-w-[250px]">{{ $product->name }}</p>
                                    <a href="{{ url('/produk/'.$product->slug) }}" target="_blank" class="text-xs text-brand-primary hover:underline">Lihat URL <i class="fa-solid fa-up-right-from-square text-[10px]"></i></a>
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
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-brand-primary hover:bg-brand-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-brand-primary transition-colors">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-box-open text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p>Belum ada produk yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                
            </tbody>
        </table>
    </div>
</div>
@endsection