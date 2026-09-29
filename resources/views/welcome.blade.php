<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @php
        $defaultTitle = "Projekrisk - Software Web, Desktop & Android Premium";
        $pageTitle = request('search') ? 'Hasil Pencarian: ' . request('search') . ' - Projekrisk' : $defaultTitle;
        $metaDescription = "Projekrisk menyediakan berbagai source code, template, dan aplikasi berbasis Web, Desktop, dan Android premium berkualitas tinggi untuk mempercepat proyek dan bisnis Anda.";
        $currentUrl = request('search') ? url()->full() : url()->current();
        $metaImage = asset('og-image.png');
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="source code premium, aplikasi web, software desktop, aplikasi android, source code sistem kasir, hris, e-commerce, download source code, projekrisk">
    <meta name="author" content="Projekrisk">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ parse_url(url('/'), PHP_URL_HOST) }}">
    <meta property="twitter:url" content="{{ $currentUrl }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['"Roboto"', 'sans-serif'] },
                    colors: {
                        brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB', accent: '#10B981' }
                    }
                }
            }
        };
    </script>

    <style>
        .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .glass-nav.scrolled { box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        #search-modal.active { opacity: 1; pointer-events: auto; transform: translateY(0); }
        #search-modal { opacity: 0; pointer-events: none; transform: translateY(-10px); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 overflow-x-hidden">

    <div id="search-modal" class="fixed inset-0 z-[100] bg-white/95 dark:bg-brand-dark/95 backdrop-blur-md flex flex-col">
        <div class="flex justify-end p-6 md:p-8">
            <button id="close-search-btn" class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500 transition-colors w-12 h-12 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                <i class="fa-solid fa-xmark text-3xl"></i>
            </button>
        </div>
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 pb-24">
            <form action="{{ url('/') }}" method="GET" class="w-full max-w-4xl relative">
                <p class="text-sm font-bold text-brand-primary uppercase tracking-widest mb-4">Pencarian Global</p>
                <div class="relative flex items-center">
                    <input type="text" id="fullscreen-search-input" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci (misal: Kasir, HRIS)..." autocomplete="off" class="w-full bg-transparent text-gray-900 dark:text-white text-3xl sm:text-5xl md:text-6xl font-black border-b-2 border-gray-300 dark:border-gray-700 focus:border-brand-primary dark:focus:border-brand-primary pb-4 pr-16 outline-none transition-colors placeholder:text-gray-300 dark:placeholder:text-gray-700">
                    <button type="submit" class="absolute right-0 bottom-6 text-brand-primary hover:text-brand-primaryHover text-3xl sm:text-5xl transition-transform hover:translate-x-2">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/60 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
    <aside id="mobile-sidebar" class="fixed top-0 right-0 h-full w-[280px] bg-white dark:bg-gray-900 z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col border-l border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <img src="{{ asset('icon.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
            </div>
            <button id="close-sidebar-btn" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-5 flex-1 overflow-y-auto">
            <nav class="flex flex-col space-y-2 mt-4">
                <a href="#produk" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Produk</a>
                <a href="#fitur" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Keunggulan</a>
                <a href="#testimoni" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Testimoni</a>
                <a href="#artikel" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Artikel</a>
                
                <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2"></div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary hover:bg-brand-primaryHover text-center rounded-lg transition-colors shadow-md">Dashboard Saya</a>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 text-center rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary hover:bg-brand-primaryHover text-center rounded-lg transition-colors shadow-md mt-2">Daftar Sekarang</a>
                @endauth
            </nav>
        </div>
    </aside>

    <div class="bg-white dark:bg-brand-dark text-gray-900 dark:text-white relative z-20 transition-colors duration-300">
        <header class="fixed w-full top-0 z-50 glass-nav bg-white/80 dark:bg-brand-dark/85 border-b border-gray-200 dark:border-white/5 transition-all duration-300" id="navbar">
            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                        <img src="{{ asset('icon.png') }}" alt="Projekrisk Logo" class="w-10 h-10 object-contain drop-shadow-md">
                        <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                    </a>

                    <div class="hidden md:flex items-center gap-8">
                        <nav class="flex gap-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                            <a href="#produk" class="hover:text-brand-primary dark:hover:text-white transition-colors">Produk</a>
                            <a href="#fitur" class="hover:text-brand-primary dark:hover:text-white transition-colors">Keunggulan</a>
                            <a href="#testimoni" class="hover:text-brand-primary dark:hover:text-white transition-colors">Testimoni</a>
                            <a href="#artikel" class="hover:text-brand-primary dark:hover:text-white transition-colors">Artikel</a>
                        </nav>

                        <div class="flex items-center gap-4 border-l border-gray-300 dark:border-gray-700 pl-6">
                            
                            <button class="open-search-modal text-gray-500 hover:text-brand-primary dark:text-gray-400 dark:hover:text-brand-primary transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-blue-50 dark:hover:bg-gray-800" aria-label="Search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            
                            <button id="theme-toggle" class="text-gray-500 hover:text-brand-primary dark:text-gray-400 dark:hover:text-brand-primary transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-blue-50 dark:hover:bg-gray-800" aria-label="Toggle Dark Mode">
                                <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                            </button>

                            <div class="ml-2 flex gap-3 items-center">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-blue-500/20">Dashboard Saya</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white transition-colors">Login</a>
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-blue-500/20">Daftar</a>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <div class="md:hidden flex items-center gap-2">
                        <button class="open-search-modal text-gray-500 hover:text-brand-primary dark:text-gray-400 dark:hover:text-brand-primary transition-colors w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button id="theme-toggle-mobile" class="text-gray-500 hover:text-brand-primary dark:text-gray-400 dark:hover:text-brand-primary transition-colors w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                            <i id="theme-toggle-icon-mobile" class="fa-solid fa-moon"></i>
                        </button>
                        <button id="mobile-menu-btn" class="text-gray-600 hover:text-brand-primary dark:text-gray-300 dark:hover:text-brand-primary focus:outline-none w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-bars text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        @if(!request('search'))
        <section class="h-[100svh] min-h-[650px] w-full relative flex items-center justify-center pt-20 overflow-hidden">
            
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-brand-primary/10 rounded-full blur-[80px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-brand-accent/10 rounded-full blur-[80px]"></div>
            </div>

            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center flex flex-col items-center w-full">
                <div class="w-full space-y-6 flex flex-col items-center">
                    
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 dark:text-white leading-[1.1] tracking-tight max-w-4xl">
                        Solusi Digital untuk <br class="hidden sm:block" />
                        <span class="text-brand-primary">Kebutuhan Anda</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl mx-auto font-light mt-4">
                        Cari source code, template, atau aplikasi siap pakai untuk mempercepat proyek dan bisnis Anda.
                    </p>
                    
                    <div class="w-full max-w-2xl mx-auto relative group mt-4 cursor-pointer open-search-modal">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" readonly placeholder="Cari Sistem Kasir, HRIS, E-Commerce..." class="w-full bg-white dark:bg-slate-800 text-gray-900 dark:text-white border-2 border-gray-200 dark:border-slate-700 rounded-2xl pl-14 pr-28 sm:pr-32 py-5 shadow-xl transition-all text-base sm:text-lg cursor-pointer">
                        <button type="button" class="absolute right-2 top-2 bottom-2 bg-brand-primary text-white px-6 sm:px-8 rounded-xl font-bold shadow-md">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="absolute bottom-10 left-0 w-full flex justify-center z-20 pointer-events-none">
                <div class="animate-bounce flex flex-col items-center gap-2 opacity-50">
                    <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest pl-1">Scroll</span>
                    <i class="fa-solid fa-arrow-down text-gray-400"></i>
                </div>
            </div>
        </section>
        @else
        <section class="pt-36 pb-16 bg-blue-50/50 dark:bg-brand-primary/10 border-b border-gray-200 dark:border-gray-800 text-center">
            <div class="max-w-[1100px] mx-auto px-4 relative z-10">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">Hasil untuk: <span class="text-brand-primary">"{{ request('search') }}"</span></h2>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-red-500 hover:text-white bg-white hover:bg-red-500 dark:bg-slate-800 dark:hover:bg-red-500 border border-red-100 dark:border-red-500/20 px-6 py-2.5 rounded-xl transition-all shadow-sm">
                    <i class="fa-solid fa-xmark"></i> Hapus Pencarian
                </a>
            </div>
        </section>
        @endif
    </div>

    <main>
        <section id="produk" class="py-24 bg-slate-100 dark:bg-slate-800 transition-colors duration-300 scroll-mt-10">
            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    @if(request('search'))
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-3">Katalog Produk</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white mb-4">Ditemukan {{ count($products) }} Produk</h3>
                    @else
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-3">Katalog Premium</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white mb-4">Produk Pilihan Kami</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Berbagai source code dan aplikasi siap pakai yang dirancang untuk mempercepat pertumbuhan bisnis Anda.</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if(count($products) > 0): ?>
                        <?php foreach($products as $product): ?>
                        <div class="bg-white dark:bg-slate-700/50 rounded-2xl overflow-hidden shadow-sm border border-gray-200/80 dark:border-slate-600/50 flex flex-col card-hover">
                            <div class="relative aspect-video">
                                @if($product->featured_image)
                                    <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image text-5xl"></i>
                                    </div>
                                @endif
                                <a href="{{ route('front.products', ['category' => $product->category]) }}" class="absolute top-4 left-4 bg-brand-primary hover:bg-brand-primaryHover text-white text-[10px] font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm transition-colors z-10" title="Filter by {{ $product->category }}">
                                    {{ $product->category }}
                                </a>
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-brand-primary transition-colors cursor-pointer">
                                    <a href="{{ url('/produk/'.$product->slug) }}">{{ $product->name }}</a>
                                </h4>
                                
                                <div class="mt-auto pt-5 border-t border-gray-100 dark:border-slate-600/50">
                                    <div class="flex flex-wrap items-end gap-2 mb-5">
                                        <span class="text-brand-primary font-normal text-2xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @if($product->strike_price)
                                            <span class="text-gray-400 dark:text-gray-500 line-through text-sm mb-1">Rp {{ number_format($product->strike_price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <div class="flex gap-3">
                                        <a href="{{ route('front.checkout', $product->slug) }}" class="flex-1 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold py-2.5 rounded-xl transition-colors text-center shadow-md shadow-blue-500/20">Beli</a>
                                        <a href="{{ url('/produk/'.$product->slug) }}" class="flex-1 text-center bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-900 text-gray-900 dark:text-white text-sm font-bold py-2.5 rounded-xl transition-colors border border-gray-200 dark:border-slate-600">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-20 bg-white dark:bg-slate-700/30 rounded-3xl border-2 border-dashed border-gray-200 dark:border-slate-600">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                @if(request('search'))
                                    <i class="fa-solid fa-magnifying-glass text-3xl text-gray-400"></i>
                                @else
                                    <i class="fa-solid fa-box-open text-3xl text-gray-400"></i>
                                @endif
                            </div>
                            <h4 class="text-lg font-normal text-gray-900 dark:text-white mb-2">
                                {{ request('search') ? 'Produk Tidak Ditemukan' : 'Katalog Masih Kosong' }}
                            </h4>
                            <p class="text-gray-500 text-sm">
                                {{ request('search') ? 'Maaf, kami tidak menemukan produk dengan kata kunci tersebut.' : 'Admin belum menambahkan produk yang aktif.' }}
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
                
                @if(!request('search') && count($products) > 0)
                <div class="mt-14 text-center">
                    <a href="{{ route('front.products') }}" class="px-8 py-3.5 bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-brand-primary hover:text-brand-primary dark:hover:border-brand-primary dark:hover:text-brand-primary font-bold rounded-xl transition-all shadow-sm inline-flex items-center gap-2 group">
                        Lihat Semua Produk <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
            </div>
        </section>

        @if(!request('search'))
        <section id="fitur" class="py-24 bg-white dark:bg-brand-dark transition-colors duration-300">
            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-3">Keunggulan Kami</h2>
                    <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white mb-4">Mengapa Memilih Projekrisk?</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Kami memberikan ekosistem produk yang dapat diandalkan untuk menumbuhkan bisnis Anda tanpa pusing memikirkan masalah teknis.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-gray-100 dark:border-slate-700/50 shadow-sm card-hover flex flex-col items-start text-left">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-500/10 text-brand-primary flex items-center justify-center text-2xl mb-6 shadow-sm border border-blue-200 dark:border-blue-500/20"><i class="fa-solid fa-layer-group"></i></div>
                        <h4 class="text-lg font-normal text-gray-900 dark:text-white mb-3">Kode Bersih & Terstruktur</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Arsitektur aplikasi dibangun dengan best-practice terkini, memudahkan kustomisasi atau pengembangan fitur lebih lanjut.</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-gray-100 dark:border-slate-700/50 shadow-sm card-hover flex flex-col items-start text-left">
                        <div class="w-14 h-14 rounded-2xl bg-green-100 dark:bg-green-500/10 text-brand-accent flex items-center justify-center text-2xl mb-6 shadow-sm border border-green-200 dark:border-green-500/20"><i class="fa-solid fa-headset"></i></div>
                        <h4 class="text-lg font-normal text-gray-900 dark:text-white mb-3">Dukungan Teknis Premium</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Tim ahli kami siap membantu Anda mulai dari proses instalasi, perbaikan bug minor, hingga konsultasi pengembangan.</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-gray-100 dark:border-slate-700/50 shadow-sm card-hover flex flex-col items-start text-left">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl mb-6 shadow-sm border border-purple-200 dark:border-purple-500/20"><i class="fa-solid fa-bolt"></i></div>
                        <h4 class="text-lg font-normal text-gray-900 dark:text-white mb-3">Siap Pakai (Deployment)</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">Hemat ratusan jam waktu development. Aplikasi kami telah melalui tahap QA dan siap di-deploy ke lingkungan production.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-24 bg-brand-primary dark:bg-slate-800 transition-colors duration-300 relative overflow-hidden">
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden opacity-20">
                <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-white rounded-full blur-[100px]"></div>
                <div class="absolute bottom-[-10%] left-[-5%] w-[300px] h-[300px] bg-white rounded-full blur-[100px]"></div>
            </div>

            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-blue-100 dark:text-brand-primary font-bold tracking-widest uppercase text-sm mb-3">Ulasan Nyata</h2>
                    <h3 class="text-2xl md:text-3xl font-normal text-white mb-4">Apa Kata Pengguna Kami</h3>
                </div>

                <?php if(isset($reviews) && count($reviews) > 0): ?>
                <div class="relative group">
                    <button id="slideLeft" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-6 w-12 h-12 bg-white dark:bg-slate-700 rounded-full shadow-2xl z-20 flex items-center justify-center text-brand-primary dark:text-white opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:opacity-0 hidden md:flex hover:scale-110">
                        <i class="fa-solid fa-chevron-left text-lg"></i>
                    </button>

                    <div id="testimoni-container" class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-8 no-scrollbar scroll-smooth">
                        <?php foreach($reviews as $review): ?>
                        <div class="snap-center shrink-0 w-[85vw] md:w-[400px] p-8 bg-white dark:bg-slate-700/80 rounded-3xl shadow-xl relative flex flex-col card-hover">
                            <i class="fa-solid fa-quote-right text-4xl text-gray-100 dark:text-slate-600 absolute top-6 right-6"></i>
                            
                            <div class="flex text-yellow-400 text-sm mb-5 testimonial-stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?php echo $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-slate-600'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            
                            <div class="mb-8 relative z-10 flex-1">
                                <p class="text-gray-700 dark:text-gray-200 italic line-clamp-4 testimonial-text font-medium leading-relaxed">{{ $review->comment }}</p>
                                <button class="read-more-btn hidden text-brand-primary text-sm font-bold hover:underline mt-3 inline-flex items-center gap-1 focus:outline-none">Selengkapnya <i class="fa-solid fa-angle-down text-[10px]"></i></button>
                            </div>
                            
                            <div class="flex items-center gap-4 mt-auto border-t border-gray-100 dark:border-slate-600/50 pt-5">
                                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-slate-800 text-brand-primary flex items-center justify-center font-bold text-lg testimonial-img-placeholder border-2 border-blue-100 dark:border-slate-600 shrink-0">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                
                                <div class="min-w-0">
                                    <h5 class="text-gray-900 dark:text-white font-bold testimonial-author truncate">{{ $review->user->name ?? 'User Anonim' }}</h5>
                                    <p class="text-gray-500 dark:text-gray-400 text-[11px] font-medium testimonial-role uppercase tracking-wider truncate">Produk: {{ $review->product->name ?? 'Dihapus' }}</p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button id="slideRight" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-6 w-12 h-12 bg-white dark:bg-slate-700 rounded-full shadow-2xl z-20 flex items-center justify-center text-brand-primary dark:text-white opacity-0 group-hover:opacity-100 transition-all duration-300 disabled:opacity-0 hidden md:flex hover:scale-110">
                        <i class="fa-solid fa-chevron-right text-lg"></i>
                    </button>
                </div>
                
                <?php if(count($reviews) > 1): ?>
                <p class="text-white/60 text-center text-xs mt-2 md:hidden animate-pulse"><i class="fa-solid fa-arrows-left-right mr-1"></i> Geser untuk melihat lebih banyak</p>
                <?php endif; ?>

                <?php else: ?>
                <div class="text-center p-12 bg-white/10 rounded-3xl border border-white/20 backdrop-blur-sm max-w-2xl mx-auto">
                    <i class="fa-regular fa-comment-dots text-5xl text-white/50 mb-4"></i>
                    <p class="text-white/90 font-medium text-lg">Belum ada ulasan pengguna yang diterbitkan.</p>
                    <p class="text-white/60 text-sm mt-2">Jadilah yang pertama mengulas setelah melakukan pembelian!</p>
                </div>
                <?php endif; ?>
            </div>
        </section>
        @endif

        <section id="artikel" class="py-24 bg-gray-50 dark:bg-brand-dark transition-colors duration-300">
            <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center md:items-end gap-6 mb-12 border-b border-gray-200 dark:border-gray-800 pb-6">
                    <div class="text-center md:text-left">
                        @if(request('search'))
                            <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Hasil Pencarian</h2>
                            <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">Ditemukan {{ count($articles) }} Artikel</h3>
                        @else
                            <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Wawasan & Update</h2>
                            <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">Artikel Terbaru</h3>
                        @endif
                    </div>
                    @if(!request('search'))
                    <a href="{{ route('front.articles') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 font-bold hover:text-brand-primary dark:hover:text-brand-primary transition-colors">
                        Lihat Semua Blog <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if(count($articles) > 0): ?>
                        <?php foreach($articles as $article): ?>
                        <article class="bg-white dark:bg-slate-700/50 rounded-2xl overflow-hidden shadow-sm border border-gray-200/80 dark:border-slate-600/50 flex flex-col card-hover">
                            
                            <div class="relative aspect-video overflow-hidden">
                                @if($article->featured_image)
                                    <img src="{{ asset('uploads/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-400">
                                        <i class="fa-regular fa-image text-4xl"></i>
                                    </div>
                                @endif
                                <a href="{{ route('front.articles', ['category' => $article->category]) }}" class="absolute top-4 left-4 bg-brand-primary hover:bg-brand-primaryHover text-white text-[10px] font-bold px-3 py-1.5 rounded-md uppercase tracking-wider shadow-sm transition-colors z-10" title="Filter by {{ $article->category }}">
                                    {{ $article->category }}
                                </a>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center text-xs font-bold text-gray-400 mb-3 uppercase tracking-wider">
                                    <i class="fa-regular fa-calendar mr-2"></i> {{ $article->created_at->format('d M Y') }}
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white leading-snug hover:text-brand-primary transition-colors line-clamp-2 mb-3 cursor-pointer">
                                    <a href="{{ route('front.article', $article->slug) }}">{{ $article->title }}</a>
                                </h4>
                                
                                <div class="mt-auto pt-5 border-t border-gray-100 dark:border-slate-600/50">
                                    <a href="{{ route('front.article', $article->slug) }}" class="flex items-center justify-center gap-2 w-full bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-900 text-gray-900 dark:text-white text-sm font-bold py-2.5 rounded-xl transition-colors border border-gray-200 dark:border-slate-600">
                                        Baca Selengkapnya <i class="fa-solid fa-arrow-right-long text-brand-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-gray-200 dark:border-slate-700">
                            <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center mb-4">
                                @if(request('search'))
                                    <i class="fa-solid fa-magnifying-glass text-2xl text-gray-400"></i>
                                @else
                                    <i class="fa-regular fa-newspaper text-2xl text-gray-400"></i>
                                @endif
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                {{ request('search') ? 'Artikel Tidak Ditemukan' : 'Belum Ada Artikel' }}
                            </h4>
                            <p class="text-gray-500 text-sm">
                                {{ request('search') ? 'Coba cari dengan kata kunci lain.' : 'Admin belum menulis artikel untuk dipublikasikan.' }}
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 py-10 text-center md:text-left">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-8 h-8 opacity-80 grayscale hover:grayscale-0 transition-all">
                <p class="text-gray-400 text-sm font-medium">
                    &copy; {{ date('Y') }} Projekrisk.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-500 font-medium">
                <a href="{{ route('front.terms') }}" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('front.privacy') }}" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="{{ route('front.contact') }}" class="hover:text-white transition-colors">Kontak Kami</a>
            </div>
        </div>
    </footer>

    <div id="testimoni-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
        <div id="testimoni-overlay" class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        <div id="testimoni-content" class="relative bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl p-6 md:p-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 border border-gray-100 dark:border-slate-700">
            <button id="close-testimoni" class="absolute top-5 right-5 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-slate-700 focus:outline-none">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div id="modal-stars" class="flex text-yellow-400 text-lg mb-6"></div>
            <p id="modal-text" class="text-gray-700 dark:text-gray-200 italic mb-8 text-lg leading-relaxed font-medium"></p>
            <div class="flex items-center gap-4 border-t border-gray-100 dark:border-slate-700 pt-6">
                <div id="modal-img-container" class="w-14 h-14 rounded-full bg-blue-100 dark:bg-slate-800 text-brand-primary flex items-center justify-center font-bold text-xl border-2 border-gray-100 dark:border-slate-600 shrink-0"></div>
                <div>
                    <h5 id="modal-author" class="text-gray-900 dark:text-white font-bold text-lg"></h5>
                    <p id="modal-role" class="text-gray-500 dark:text-gray-400 text-xs font-medium uppercase tracking-wider mt-0.5"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchModal = document.getElementById('search-modal');
            const searchInput = document.getElementById('fullscreen-search-input');
            const closeSearchBtn = document.getElementById('close-search-btn');
            const openSearchTriggers = document.querySelectorAll('.open-search-modal');

            function openSearch() {
                searchModal.classList.remove('hidden');
                void searchModal.offsetWidth;
                searchModal.classList.add('active');
                setTimeout(() => { searchInput.focus(); }, 100);
                document.body.style.overflow = 'hidden';
            }

            function closeSearch() {
                searchModal.classList.remove('active');
                setTimeout(() => { searchModal.classList.add('hidden'); }, 400);
                document.body.style.overflow = '';
            }

            openSearchTriggers.forEach(btn => btn.addEventListener('click', openSearch));
            if(closeSearchBtn) closeSearchBtn.addEventListener('click', closeSearch);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && searchModal.classList.contains('active')) {
                    closeSearch();
                }
            });

            const btnOpen = document.getElementById('mobile-menu-btn');
            const btnClose = document.getElementById('close-sidebar-btn');
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const navLinks = document.querySelectorAll('.mobile-nav-link');

            function openSidebar() {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.add('translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => { overlay.classList.add('hidden'); }, 300);
                document.body.style.overflow = '';
            }

            btnOpen.addEventListener('click', openSidebar);
            btnClose.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);
            navLinks.forEach(link => link.addEventListener('click', closeSidebar));

            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');
            const themeToggleIconMobile = document.getElementById('theme-toggle-icon-mobile');
            const html = document.documentElement;

            if (html.classList.contains('dark')) { setIcons('dark'); } else { setIcons('light'); }

            function setIcons(theme) {
                if(theme === 'dark') {
                    themeToggleIcon?.classList.replace('fa-moon', 'fa-sun');
                    if(themeToggleIconMobile) themeToggleIconMobile.classList.replace('fa-moon', 'fa-sun');
                } else {
                    themeToggleIcon?.classList.replace('fa-sun', 'fa-moon');
                    if(themeToggleIconMobile) themeToggleIconMobile.classList.replace('fa-sun', 'fa-moon');
                }
            }

            function toggleTheme() {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light');
                } else {
                    html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark');
                }
            }

            themeToggleBtn.addEventListener('click', toggleTheme);
            if(themeToggleBtnMobile) themeToggleBtnMobile.addEventListener('click', toggleTheme);

            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) { navbar.classList.add('scrolled'); } 
                else { navbar.classList.remove('scrolled'); }
            });

            const testimoniModal = document.getElementById('testimoni-modal');
            const testimoniOverlay = document.getElementById('testimoni-overlay');
            const testimoniContent = document.getElementById('testimoni-content');
            const btnCloseTestimoni = document.getElementById('close-testimoni');
            
            document.querySelectorAll('.read-more-btn').forEach(btn => {
                const p = btn.previousElementSibling;
                const checkTruncation = () => {
                    if (p.scrollHeight > p.clientHeight) btn.classList.remove('hidden');
                    else btn.classList.add('hidden');
                };
                checkTruncation();
                window.addEventListener('resize', checkTruncation);

                btn.addEventListener('click', function() {
                    const card = this.closest('.card-hover');
                    
                    document.getElementById('modal-stars').innerHTML = card.querySelector('.testimonial-stars').innerHTML;
                    document.getElementById('modal-text').textContent = card.querySelector('.testimonial-text').textContent;
                    
                    const imgPlaceholder = card.querySelector('.testimonial-img-placeholder');
                    document.getElementById('modal-img-container').textContent = imgPlaceholder.textContent.trim();

                    document.getElementById('modal-author').textContent = card.querySelector('.testimonial-author').textContent;
                    document.getElementById('modal-role').textContent = card.querySelector('.testimonial-role').textContent;

                    testimoniModal.classList.remove('hidden'); testimoniModal.classList.add('flex');
                    void testimoniModal.offsetWidth;
                    testimoniOverlay.classList.remove('opacity-0');
                    testimoniContent.classList.remove('scale-95', 'opacity-0');
                    document.body.style.overflow = 'hidden';
                });
            });

            function closeTestimoniModal() {
                testimoniOverlay.classList.add('opacity-0');
                testimoniContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => { testimoniModal.classList.add('hidden'); testimoniModal.classList.remove('flex'); }, 300);
                document.body.style.overflow = '';
            }

            if(btnCloseTestimoni) {
                btnCloseTestimoni.addEventListener('click', closeTestimoniModal);
                testimoniOverlay.addEventListener('click', closeTestimoniModal);
            }
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !testimoniModal.classList.contains('hidden')) { closeTestimoniModal(); }
            });

            const testContainer = document.getElementById('testimoni-container');
            const slideLeft = document.getElementById('slideLeft');
            const slideRight = document.getElementById('slideRight');

            if(testContainer && slideLeft && slideRight) {
                const cardWidth = 424; 
                
                slideRight.addEventListener('click', () => {
                    testContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
                });
                
                slideLeft.addEventListener('click', () => {
                    testContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                });
                
                testContainer.addEventListener('scroll', () => {
                    slideLeft.disabled = testContainer.scrollLeft <= 0;
                    slideRight.disabled = testContainer.scrollLeft + testContainer.clientWidth >= testContainer.scrollWidth - 5;
                });
                
                testContainer.dispatchEvent(new Event('scroll'));
            }
        });
    </script>
</body>
</html>