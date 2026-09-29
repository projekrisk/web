<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - Projekrisk</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class', 
            theme: { 
                extend: { 
                    fontFamily: { sans: ['"Inter"', 'sans-serif'] }, 
                    colors: { brand: { primary: '#3B82F6', primaryHover: '#2563EB' } } 
                } 
            } 
        }
    </script>
    <style>
        /* Pengaturan Cetak Profesional (Grayscale / Hitam Putih Bersih) */
        @media print {
            @page { size: landscape; margin: 10mm; }
            body { background-color: white !important; color: #000 !important; }
            .dark body, .dark .bg-slate-800, .dark .bg-slate-900 { background-color: white !important; color: #000 !important; }
            .print-text-black { color: #000 !important; }
            .print-text-gray { color: #333 !important; }
            .print-text-muted { color: #666 !important; }
            .print-border { border: 1px solid #ccc !important; }
            .print-border-b { border-bottom: 1px solid #ccc !important; }
            .print-bg-transparent { background-color: transparent !important; }
            .print-bg-light { background-color: #f9f9f9 !important; }
            .print-hide { display: none !important; }
            .print-shadow-none { box-shadow: none !important; }
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen p-4 sm:p-6 transition-colors duration-300 print:bg-white print:p-0">

    @php
        $uniqueCode = str_pad(abs(crc32($order->order_number)) % 1000, 3, '0', STR_PAD_LEFT);
        $finalPrice = $order->total_price + (int)$uniqueCode;
        $formattedPrice = number_format($finalPrice, 0, ',', '.');
        $mainPrice = substr($formattedPrice, 0, -3);
        $lastDigits = substr($formattedPrice, -3);
    @endphp

    <div class="w-full max-w-4xl bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-200 dark:border-slate-700 overflow-hidden relative print:shadow-none print:border-none print:max-w-full print:rounded-none">
        
        <div class="p-5 sm:px-8 sm:py-6 border-b border-gray-100 dark:border-slate-700 print-border-b flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-10 h-10 object-contain drop-shadow-sm print-hide">
                <div>
                    <h1 class="text-xl font-normal text-gray-900 dark:text-white print-text-black tracking-tight">Tagihan Pembayaran</h1>
                    <p class="text-gray-500 dark:text-gray-400 print-text-muted text-[14px] font-medium mt-0.5">Invoice #<span class="font-mono">{{ $order->order_number }}</span></p>
                </div>
            </div>
            
            <div class="sm:text-right w-full sm:w-auto">
                <p class="text-[11px] text-gray-400 dark:text-gray-500 print-text-muted uppercase tracking-widest font-bold mb-0.5">Tanggal Terbit</p>
                <p class="text-xs font-semibold text-gray-900 dark:text-white print-text-black">{{ $order->created_at->format('d F Y') }}</p>
                <p class="text-[11px] text-gray-500 print-text-muted">{{ $order->created_at->format('H:i') }} WIB</p>
            </div>
        </div>

        @if(session('success'))
            <div class="print:hidden bg-green-50 dark:bg-green-500/10 text-green-700 dark:text-green-400 p-2.5 mx-5 sm:mx-8 mt-5 rounded-lg text-xs font-semibold border border-green-200 dark:border-green-500/20 flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="p-5 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 print:grid-cols-2 print:gap-10 print:p-8">
            
            <div class="flex flex-col">
                <h3 class="text-[12px] font-bold text-gray-400 dark:text-gray-500 print-text-muted uppercase tracking-widest mb-3 border-b border-gray-100 dark:border-slate-700 print-border-b pb-1.5">Rincian Pembelian</h3>
                
                <div class="flex items-start gap-3 mb-5">
                    @if($order->product->featured_image)
                        <img src="{{ asset('uploads/' . $order->product->featured_image) }}" class="w-12 h-12 rounded object-cover border border-gray-200 dark:border-slate-600 print-hide shrink-0">
                    @else
                        <div class="w-12 h-12 bg-gray-100 dark:bg-slate-700 rounded flex items-center justify-center print-hide border border-gray-200 shrink-0"><i class="fa-solid fa-box text-gray-400 text-sm"></i></div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white print-text-black leading-snug truncate">{{ $order->product->name }}</h4>
                        <span class="inline-block px-1.5 py-0.5 mt-1 bg-gray-100 dark:bg-slate-700 print-bg-light text-gray-600 dark:text-gray-300 print-text-gray text-[8px] font-bold rounded uppercase tracking-wider">{{ $order->product->category }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-slate-900/50 print-bg-light rounded-lg p-3 mb-5 border border-gray-100 dark:border-slate-700 print-border">
                    <p class="text-[12px] text-gray-500 dark:text-gray-400 print-text-muted uppercase font-bold mb-1">Penerima Tagihan</p>
                    <p class="font-bold text-gray-900 dark:text-white print-text-black text-xs">{{ Auth::user()->name }}</p>
                    <p class="text-[12px] text-gray-600 dark:text-gray-400 print-text-gray mt-0.5">{{ Auth::user()->email }}</p>
                </div>

                <div class="mt-auto bg-blue-50 dark:bg-blue-900/20 print-bg-light rounded-lg p-4 border border-blue-100 dark:border-blue-800/50 print-border flex flex-col justify-center">
                    <div class="flex justify-between items-center mb-1">
                        <p class="text-xs font-bold text-blue-800 dark:text-blue-400 print-text-black">Total Tagihan</p>
                        <h2 class="text-xl sm:text-2xl font-normal text-brand-primary print-text-black tracking-tight">
                            Rp {{ $mainPrice }}<span class="text-red-500 dark:text-red-400 print-text-black">{{ $lastDigits }}</span>
                        </h2>
                    </div>
                    <p class="text-[10px] text-blue-600/80 dark:text-blue-300/80 print-text-muted text-right mt-1">
                        *Harap transfer tepat hingga 3 digit terakhir ({{ $lastDigits }}).
                    </p>
                </div>
            </div>

            <div class="flex flex-col h-full">
                
                @if($order->status == 'pending')
                    <h3 class="text-[12px] font-bold text-gray-400 dark:text-gray-500 print-text-muted uppercase tracking-widest mb-3 border-b border-gray-100 dark:border-slate-700 print-border-b pb-1.5">Tujuan Pembayaran</h3>
                    
                    <div class="flex-1 space-y-3 mb-5">
                        <?php if(isset($paymentMethods) && count($paymentMethods) > 0): ?>
                            <?php foreach($paymentMethods as $bank): ?>
                                @php
                                    $bankNameLower = strtolower($bank->bank_name);
                                    $themeColor = 'brand-primary';
                                    $themeHex = '#3B82F6';
                                    $icon = 'fa-building-columns';
                                    
                                    if(str_contains($bankNameLower, 'bca')) { $themeHex = '#0066AE'; }
                                    elseif(str_contains($bankNameLower, 'mandiri')) { $themeHex = '#003D79'; }
                                    elseif(str_contains($bankNameLower, 'bni')) { $themeHex = '#005E6A'; }
                                    elseif(str_contains($bankNameLower, 'bri')) { $themeHex = '#00529C'; }
                                    elseif(str_contains($bankNameLower, 'gopay') || str_contains($bankNameLower, 'dana') || str_contains($bankNameLower, 'ovo')) { 
                                        $icon = 'fa-wallet'; 
                                        $themeHex = str_contains($bankNameLower, 'gopay') ? '#00AED6' : (str_contains($bankNameLower, 'dana') ? '#118EEA' : '#4C3494');
                                    }
                                @endphp
                                
                                <div class="border border-gray-200 dark:border-slate-700 print-border rounded-lg p-3 flex items-center gap-4 bg-white dark:bg-slate-800 transition-colors hover:border-gray-300 dark:hover:border-slate-600 relative overflow-hidden">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 opacity-80 print-hide" style="background-color: {{ $themeHex }};"></div>
                                    <div class="w-10 h-10 rounded-full bg-gray-50 dark:bg-slate-900 print-hide flex items-center justify-center border border-gray-100 dark:border-slate-700 text-gray-400">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-0.5 print-text-gray">{{ $bank->bank_name }}</p>
                                        <p class="text-sm font-bold font-mono text-gray-900 dark:text-white print-text-black tracking-wide">{{ $bank->account_number }}</p>
                                        <p class="text-[12px] text-gray-500 dark:text-gray-400 print-text-muted mt-0.5">A.N {{ $bank->account_owner }}</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="border border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-4 text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Hubungi admin untuk info rekening.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    @php
                        $nomorAdmin = "6281311665601";
                        $pesan = "Halo Admin Projekrisk, saya ingin konfirmasi pembayaran.%0A%0A"
                               . "ID Pesanan: *" . $order->order_number . "*%0A"
                               . "Produk: *" . $order->product->name . "*%0A"
                               . "Total Transfer: *Rp " . number_format($finalPrice, 0, ',', '.') . "*%0A%0A"
                               . "Berikut saya lampirkan bukti transfernya:";
                        $linkWA = "https://wa.me/{$nomorAdmin}?text={$pesan}";
                    @endphp

                    <div class="print:hidden mt-auto border-t border-gray-100 dark:border-slate-700 pt-4">
                        <div class="flex items-start gap-2 mb-4 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/30 p-2.5 rounded-lg">
                            <i class="fa-solid fa-circle-exclamation text-yellow-500 mt-0.5 text-xs shrink-0"></i>
                            <p class="text-[10px] text-yellow-700 dark:text-yellow-500/80 leading-relaxed font-medium">Setelah transfer, klik tombol WA di bawah ini dan kirimkan bukti setruk/screenshot transaksi Anda ke Admin.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <a href="{{ $linkWA }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#128C7E] text-white text-center font-bold py-2 px-3 rounded-lg transition-colors text-xs flex items-center justify-center gap-1.5 shadow-sm shadow-green-500/20">
                                <i class="fa-brands fa-whatsapp text-sm"></i> Konfirmasi WA
                            </a>
                            <button onclick="window.print()" class="w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 text-center font-bold py-2 px-3 rounded-lg transition-colors text-xs flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-print text-sm"></i> Cetak PDF
                            </button>
                        </div>
                        
                        <a href="{{ route('dashboard') }}" class="block w-full text-center text-gray-500 hover:text-gray-900 dark:hover:text-white font-medium py-1.5 rounded-lg transition-colors text-[11px]">
                            Kembali ke Dasbor
                        </a>
                    </div>
                @else
                    <h3 class="text-[10px] font-bold text-gray-400 dark:text-gray-500 print-text-muted uppercase tracking-widest mb-3 border-b border-gray-100 dark:border-slate-700 print-border-b pb-1.5">Status Pesanan</h3>
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-6 bg-gray-50 dark:bg-slate-900/50 print-bg-light rounded-xl border border-gray-100 dark:border-slate-700 print-border">
                        @if($order->status == 'paid')
                            <div class="w-16 h-16 bg-green-100 dark:bg-green-500/20 text-green-500 rounded-full flex items-center justify-center text-3xl mb-3 border border-green-200 dark:border-green-500/30 print-border">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white print-text-black mb-1">Pembayaran Lunas</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 print-text-gray mb-4">Terima kasih, pembayaran Anda telah diverifikasi.</p>
                            <a href="{{ route('dashboard') }}" class="print:hidden inline-flex px-5 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white font-bold rounded-lg transition-colors shadow-sm text-xs gap-1.5 items-center">
                                Akses Produk <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @else
                            <div class="w-16 h-16 bg-red-100 dark:bg-red-500/20 text-red-500 rounded-full flex items-center justify-center text-3xl mb-3 border border-red-200 dark:border-red-500/30 print-border">
                                <i class="fa-solid fa-xmark"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white print-text-black mb-1">Pesanan Dibatalkan</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 print-text-gray mb-4">Pesanan ini telah dibatalkan oleh Admin.</p>
                            <a href="{{ route('dashboard') }}" class="print:hidden inline-flex px-5 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-gray-200 font-bold rounded-lg transition-colors shadow-sm text-xs">
                                Kembali
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            
        </div>

        <div class="hidden print:block p-6 pt-3 border-t border-gray-200 print-border-b text-center text-[9px] text-gray-500 print-text-muted mt-2">
            <p>Invoice ini sah dan diterbitkan secara otomatis oleh sistem pada {{ now()->format('d M Y, H:i') }}.</p>
        </div>
    </div>

    <button id="theme-toggle" class="fixed bottom-4 right-4 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors flex items-center justify-center w-10 h-10 bg-white dark:bg-slate-800 rounded-full shadow-lg border border-gray-200 dark:border-slate-700 print:hidden z-50">
        <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
    </button>
    
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleIcon = document.getElementById('theme-toggle-icon');
        const html = document.documentElement;
        
        if (html.classList.contains('dark')) { setIcons('dark'); } else { setIcons('light'); }
        
        function setIcons(theme) {
            if(theme === 'dark') { themeToggleIcon.classList.replace('fa-moon', 'fa-sun'); } 
            else { themeToggleIcon.classList.replace('fa-sun', 'fa-moon'); }
        }
        
        themeToggleBtn.addEventListener('click', () => {
            if (html.classList.contains('dark')) { 
                html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light'); 
            } else { 
                html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark'); 
            }
        });
    </script>
</body>
</html>