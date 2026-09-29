<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Area - Projekrisk</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class', 
            theme: { 
                extend: { 
                    fontFamily: { sans: ['"Roboto"', 'sans-serif'] }, 
                    colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB', success: '#10B981', danger: '#EF4444', warning: '#F59E0B' } } 
                } 
            } 
        }
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .glass-nav.scrolled { box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col">

    <header class="fixed w-full top-0 z-50 glass-nav bg-white/80 dark:bg-brand-dark/85 border-b border-gray-200 dark:border-gray-800 transition-all duration-300" id="navbar">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>

                <div class="flex items-center gap-4">
                    <button id="theme-toggle" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                    </button>
                    
                    <div class="h-6 w-px bg-gray-300 dark:bg-gray-700 mx-1"></div>

                    <div class="flex items-center gap-3 pl-2">
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mt-0.5">Member</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-brand-primary flex items-center justify-center font-bold shadow-sm border border-blue-200 dark:border-blue-800/50">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors w-9 h-9 flex items-center justify-center rounded-full hover:bg-red-50 dark:hover:bg-red-500/10" title="Keluar">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-28 pb-20">
        <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-normal text-gray-900 dark:text-white mb-2 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Selamat datang di Dasbor Member. Berikut daftar pesanan produk digital Anda.</p>
                </div>
                <a href="{{ url('/#produk') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-xl hover:border-brand-primary dark:hover:border-brand-primary transition-colors shadow-sm">
                    <i class="fa-solid fa-compass text-brand-primary"></i> Jelajahi Produk
                </a>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="p-5 md:px-8 md:py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-800/50">
                    <h2 class="text-lg font-normal text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-brand-primary"></i> Riwayat Pesanan Saya
                    </h2>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-slate-700/80">
                    @forelse($orders as $order)
                        <div class="p-6 md:p-8 flex flex-col md:flex-row gap-6 items-start hover:bg-gray-50/50 dark:hover:bg-slate-800/80 transition-colors group">
                            
                            <div class="w-full md:w-40 h-48 md:h-32 shrink-0 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-700 bg-gray-100 dark:bg-slate-900 relative">
                                @if($order->product->featured_image)
                                    <img src="{{ asset('uploads/' . $order->product->featured_image) }}" alt="{{ $order->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-box text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 w-full">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-300 rounded uppercase tracking-widest border border-gray-200 dark:border-slate-600">{{ $order->product->category }}</span>
                                    
                                    @if($order->status == 'pending')
                                        <span class="text-[10px] font-bold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-500/10 px-2 py-0.5 rounded border border-orange-200 dark:border-orange-500/20"><i class="fa-solid fa-clock mr-1"></i> PENDING</span>
                                    @elseif($order->status == 'paid')
                                        <span class="text-[10px] font-bold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-500/10 px-2 py-0.5 rounded border border-green-200 dark:border-green-500/20"><i class="fa-solid fa-check-circle mr-1"></i> LUNAS</span>
                                    @else
                                        <span class="text-[10px] font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 px-2 py-0.5 rounded border border-red-200 dark:border-red-500/20"><i class="fa-solid fa-xmark-circle mr-1"></i> BATAL</span>
                                    @endif
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2.5 leading-snug line-clamp-2">
                                    <a href="{{ url('/produk/'.$order->product->slug) }}" target="_blank" class="hover:text-brand-primary transition-colors">{{ $order->product->name }}</a>
                                </h3>
                                
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500 dark:text-gray-400 mb-4 font-medium">
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-hashtag text-gray-400"></i> <span class="font-mono">{{ $order->order_number }}</span></span>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-gray-400"></i> {{ $order->created_at->format('d M Y') }}</span>
                                </div>
                                
                                <p class="text-brand-primary font-normal text-xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <div class="w-full md:w-48 flex flex-col gap-2 shrink-0 border-t md:border-none border-gray-100 dark:border-slate-700 pt-4 md:pt-0">
                                @if($order->status == 'pending')
                                    <a href="{{ route('front.invoice', $order->order_number) }}" class="w-full text-center px-4 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-colors shadow-sm flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-wallet"></i> Bayar Sekarang
                                    </a>
                                @elseif($order->status == 'paid')
                                    @if($order->product->download_type == 'link' && $order->product->download_link)
                                        <a href="{{ $order->product->download_link }}" target="_blank" class="w-full text-center px-4 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-sm flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-cloud-arrow-down"></i> Akses Produk
                                        </a>
                                    @elseif($order->product->download_type == 'file' && $order->product->download_file)
                                        <a href="{{ asset('uploads/'.$order->product->download_file) }}" download class="w-full text-center px-4 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-sm flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-file-zipper"></i> Download File
                                        </a>
                                    @else
                                        <span class="w-full text-center px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 text-sm font-bold rounded-lg flex items-center justify-center">
                                            Sedang Disiapkan
                                        </span>
                                    @endif

                                    <a href="{{ url('/produk/' . $order->product->slug . '#ulasan-produk') }}" class="w-full text-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 hover:border-yellow-400 dark:hover:border-yellow-500 hover:bg-yellow-50 dark:hover:bg-yellow-500/10 text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2 group">
                                        <i class="fa-solid fa-star text-gray-400 group-hover:text-yellow-500 transition-colors"></i> Ulas Produk
                                    </a>

                                    <a href="{{ route('front.invoice', $order->order_number) }}" class="w-full text-center px-4 py-2 bg-transparent hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-500 dark:text-gray-400 text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1.5 mt-1">
                                        <i class="fa-solid fa-file-invoice"></i> Lihat Tagihan
                                    </a>
                                @else
                                    <a href="{{ url('/produk/'.$order->product->slug) }}" class="w-full text-center px-4 py-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200 text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-rotate-right"></i> Pesan Ulang
                                    </a>
                                    <a href="{{ route('front.invoice', $order->order_number) }}" class="w-full text-center px-4 py-2 bg-transparent hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-500 dark:text-gray-400 text-xs font-semibold rounded-lg transition-colors flex items-center justify-center gap-1.5 mt-1">
                                        <i class="fa-solid fa-file-invoice"></i> Lihat Tagihan
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-12 md:p-20 flex flex-col items-center justify-center text-center">
                            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-gray-300 dark:text-slate-600 mb-6 border border-gray-100 dark:border-slate-700">
                                <i class="fa-solid fa-basket-shopping text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Transaksi</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto text-sm leading-relaxed">Anda belum melakukan pembelian produk digital apa pun. Jelajahi katalog kami untuk menemukan *source code* dan aplikasi terbaik.</p>
                            <a href="{{ url('/#produk') }}" class="px-8 py-3 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-xl transition-all shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass"></i> Cari Produk
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

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
            if (html.classList.contains('dark')) { html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light'); } 
            else { html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark'); }
        });

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) { navbar?.classList.add('scrolled'); } else { navbar?.classList.remove('scrolled'); }
        });
    </script>
</body>
</html>