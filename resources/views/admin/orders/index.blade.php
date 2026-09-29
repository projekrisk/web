@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Pesanan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Verifikasi pembayaran dan kelola akses produk member.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 dark:bg-green-500/5 rounded-full pointer-events-none"></div>
        <div class="w-14 h-14 rounded-xl bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center text-2xl shrink-0 z-10">
            <i class="fa-solid fa-rupiah-sign"></i>
        </div>
        <div class="z-10">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5">Penghasilan Tahun Ini</p>
            <h4 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Rp {{ number_format($penghasilanTahunIni, 0, ',', '.') }}</h4>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-blue-50 dark:bg-blue-500/5 rounded-full pointer-events-none"></div>
        <div class="w-14 h-14 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-brand-primary flex items-center justify-center text-2xl shrink-0 z-10">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <div class="z-10">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5">Pesanan Tahun Ini</p>
            <h4 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($pesananTahunIni) }} <span class="text-sm font-normal text-gray-400">Trx</span></h4>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-gray-100 dark:border-slate-700/50 flex items-center gap-4">
        <div class="w-14 h-14 rounded-xl bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl shrink-0">
            <i class="fa-solid fa-cubes"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5">Total Keseluruhan Pesanan</p>
            <h4 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($totalKeseluruhan) }} <span class="text-sm font-normal text-gray-400">Trx</span></h4>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    
    <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
        <form method="GET" action="{{ route('admin.orders.index') }}" id="filter-form" class="flex flex-wrap items-center gap-3">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter Status:</label>
            
            <div class="relative w-full sm:w-72" id="filter-search-container">
                <input type="hidden" name="status" id="filter_status" value="{{ request('status') }}">
                
                <?php
                    $displayValue = '';
                    if(request('status') == 'pending') $displayValue = 'Pending (Menunggu)';
                    elseif(request('status') == 'paid') $displayValue = 'Paid (Lunas)';
                    elseif(request('status') == 'canceled') $displayValue = 'Canceled (Batal)';
                ?>
                
                <div class="relative">
                    <input type="text" id="filter-search-input" value="{{ $displayValue }}" placeholder="🔍 Cari status..." autocomplete="off" class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-brand-primary outline-none transition-all">
                    <div class="absolute right-3 top-2.5 text-gray-400 pointer-events-none"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                </div>

                <div id="filter-dropdown-list" class="absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden hidden">
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="" data-name="">
                        <div class="font-medium text-gray-500"><i class="fa-solid fa-list mr-1"></i> Semua Pesanan</div>
                    </div>
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="pending" data-name="Pending (Menunggu)">
                        <div class="font-medium"><i class="fa-solid fa-clock text-orange-400 mr-1"></i> Pending (Menunggu)</div>
                    </div>
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-slate-800/50" data-value="paid" data-name="Paid (Lunas)">
                        <div class="font-medium"><i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Paid (Lunas)</div>
                    </div>
                    <div class="filter-option px-4 py-2.5 hover:bg-blue-50 dark:hover:bg-slate-800 cursor-pointer text-sm text-gray-900 dark:text-white" data-value="canceled" data-name="Canceled (Batal)">
                        <div class="font-medium"><i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i> Canceled (Batal)</div>
                    </div>
                </div>
            </div>

            @if(request('status'))
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors px-2">
                    <i class="fa-solid fa-circle-xmark"></i> Hapus Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">ID Pesanan & Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Produk & Pembeli</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Tanggal Transaksi</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                <?php if(count($orders) > 0): ?>
                <?php foreach($orders as$order): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="p-4 whitespace-nowrap">
                        <div class="flex flex-col gap-1.5">
                            <span class="font-bold text-gray-900 dark:text-white font-mono text-[13px] bg-gray-100 dark:bg-slate-900 px-2 py-1 rounded inline-block w-max">{{ $order->order_number }}</span>
                            <div>
                                @if($order->status == 'pending')
                                    <span class="bg-orange-100 text-brand-warning dark:bg-orange-500/10 dark:text-orange-400 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">Pending</span>
                                @elseif($order->status == 'paid')
                                    <span class="bg-green-100 text-brand-success dark:bg-green-500/10 dark:text-green-400 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">Paid</span>
                                @else
                                    <span class="bg-red-100 text-brand-danger dark:bg-red-500/10 dark:text-red-400 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">Canceled</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-col gap-1">
                            <a href="{{ url('/produk/'.$order->product->slug) }}" target="_blank" class="font-bold text-gray-900 dark:text-white hover:text-brand-primary transition-colors line-clamp-1">
                                {{ $order->product->name }}
                            </a>
                            <span class="text-xs text-gray-500 dark:text-gray-400">User: <strong class="text-gray-700 dark:text-gray-300">{{ $order->user->name }}</strong></span>
                            <span class="text-xs font-bold text-brand-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </td>
                    <td class="p-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                            <i class="fa-regular fa-calendar text-gray-400 mr-1.5"></i> {{ $order->created_at->format('d M Y') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-1 pl-5">
                            Pukul {{ $order->created_at->format('H:i') }} WIB
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <button type="button" 
                            data-number="{{ $order->order_number }}"
                            data-date="{{ $order->created_at->format('d M Y, H:i') }}"
                            data-customer="{{ $order->user->name }}"
                            data-email="{{ $order->user->email }}"
                            data-wa="{{ $order->user->whatsapp_number ?? '-' }}"
                            data-product="{{ $order->product->name }}"
                            data-category="{{ $order->product->category }}"
                            data-price="Rp {{ number_format($order->total_price, 0, ',', '.') }}"
                            data-status="{{ $order->status }}"
                            data-url="{{ route('admin.orders.update_status', $order->id) }}"
                            onclick="openOrderModal(this)"
                            class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-xs font-bold transition-colors shadow-sm inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-list-check"></i> Proses
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-file-invoice-dollar text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p>Belum ada data pesanan yang masuk.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
    
    <?php if($orders->hasPages()): ?>
    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
        {{ $orders->links() }}
    </div>
    <?php endif; ?>
</div>

<div id="order-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="order-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="order-content" class="relative bg-white dark:bg-slate-800 w-full max-w-2xl rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 overflow-hidden flex flex-col max-h-[90vh]">
        
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Pesanan</h3>
            <button type="button" onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl border border-gray-100 dark:border-slate-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold mb-3">Informasi Tagihan</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID Pesanan:</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white select-all" id="modal-number"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal:</span>
                            <span class="font-medium text-gray-900 dark:text-white" id="modal-date"></span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-500">Status Saat Ini:</span>
                            <span id="modal-status-badge" class="px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-slate-900/50 p-4 rounded-xl border border-gray-100 dark:border-slate-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase font-bold mb-3">Informasi Pembeli</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama:</span>
                            <span class="font-bold text-gray-900 dark:text-white" id="modal-customer"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="font-medium text-gray-900 dark:text-white" id="modal-email"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">WhatsApp:</span>
                            <a href="#" id="modal-wa-link" target="_blank" class="font-bold text-green-600 dark:text-green-400 hover:underline inline-flex items-center gap-1">
                                <i class="fa-brands fa-whatsapp"></i> <span id="modal-wa"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <span class="text-[10px] uppercase font-bold text-brand-primary tracking-wider" id="modal-category"></span>
                    <h4 class="font-bold text-gray-900 dark:text-white text-base mt-0.5" id="modal-product"></h4>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-0.5">Total Harga</p>
                    <p class="text-xl font-black text-brand-primary" id="modal-price"></p>
                </div>
            </div>
        </div>

        <div class="p-5 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
            <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider font-bold">Ubah Status Pesanan</p>
            
            <form id="status-form" method="POST" class="flex flex-col sm:flex-row gap-3 justify-center">
                @csrf
                @method('PATCH')
                
                <button type="submit" name="status" value="paid" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Lunas (Buka Akses)
                </button>
                
                <button type="submit" name="status" value="pending" class="flex-1 bg-orange-400 hover:bg-orange-500 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-clock"></i> Jadikan Pending
                </button>
                
                <button type="submit" name="status" value="canceled" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-xmark"></i> Batalkan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('order-modal');
    const overlay = document.getElementById('order-overlay');
    const content = document.getElementById('order-content');

    function openOrderModal(button) {
        const data = button.dataset;

        document.getElementById('modal-number').textContent = data.number;
        document.getElementById('modal-date').textContent = data.date;
        document.getElementById('modal-customer').textContent = data.customer;
        document.getElementById('modal-email').textContent = data.email;
        
        const waNumber = data.wa;
        document.getElementById('modal-wa').textContent = waNumber;
        let cleanWa = waNumber.replace(/\D/g, '');
        if(cleanWa.startsWith('0')) cleanWa = '62' + cleanWa.substring(1);
        document.getElementById('modal-wa-link').href = `https://wa.me/${cleanWa}`;

        document.getElementById('modal-product').textContent = data.product;
        document.getElementById('modal-category').textContent = data.category;
        document.getElementById('modal-price').textContent = data.price;
        
        const badge = document.getElementById('modal-status-badge');
        badge.textContent = data.status;
        badge.className = 'px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider ';
        if(data.status === 'pending') badge.classList.add('bg-orange-100', 'text-brand-warning', 'dark:bg-orange-500/10', 'dark:text-orange-400');
        else if(data.status === 'paid') badge.classList.add('bg-green-100', 'text-brand-success', 'dark:bg-green-500/10', 'dark:text-green-400');
        else badge.classList.add('bg-red-100', 'text-brand-danger', 'dark:bg-red-500/10', 'dark:text-red-400');

        document.getElementById('status-form').action = data.url;

        modal.classList.remove('hidden'); modal.classList.add('flex');
        void modal.offsetWidth;
        overlay.classList.remove('opacity-0');
        content.classList.remove('scale-95', 'opacity-0');
    }

    function closeOrderModal() {
        overlay.classList.add('opacity-0');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 300);
    }

    overlay.addEventListener('click', closeOrderModal);

    document.addEventListener('DOMContentLoaded', function() {
        const filterSearchInput = document.getElementById('filter-search-input');
        const filterHiddenInput = document.getElementById('filter_status');
        const filterDropdown = document.getElementById('filter-dropdown-list');
        const filterOptions = filterDropdown.querySelectorAll('.filter-option');
        const filterForm = document.getElementById('filter-form');

        function updateDropdownList(keyword) {
            let visibleCount = 0;
            const maxVisible = 4;

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