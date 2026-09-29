<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @php
        $defaultTitle = "Blog & Wawasan - Projekrisk";
        $pageTitle = request('search') ? 'Cari Artikel: ' . request('search') . ' - Projekrisk' : (request('category') ? 'Topik: ' . request('category') . ' - Projekrisk' : $defaultTitle);
        $metaDescription = "Temukan berbagai artikel, tutorial, dan wawasan terbaru seputar dunia teknologi, pemrograman, dan pengembangan bisnis digital dari Projekrisk.";
        $currentUrl = request('search') ? url()->full() : url()->current();
        $metaImage = asset('og-image.png');
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="blog pemrograman, tutorial laravel, artikel teknologi, tips bisnis digital, projekrisk blog">
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
                    colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB', accent: '#10B981' } } 
                } 
            } 
        };
    </script>
    
    <style>
        .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .glass-nav.scrolled { box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-900 dark:bg-brand-dark dark:text-gray-100 transition-colors duration-300">

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/60 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
    <aside id="mobile-sidebar" class="fixed top-0 right-0 h-full w-[280px] bg-white dark:bg-gray-900 z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col border-l border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800">
            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Menu</span>
            <button id="close-sidebar-btn" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-5 flex-1 overflow-y-auto">
            <nav class="flex flex-col space-y-2">
                <a href="{{ url('/') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Beranda</a>
                <a href="{{ route('front.products') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Semua Produk</a>
                <a href="{{ route('front.articles') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-brand-primary bg-blue-50 dark:bg-blue-900/20 rounded-lg transition-colors">Artikel</a>
                
                <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2"></div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary hover:bg-brand-primaryHover text-center rounded-lg transition-colors">Dashboard Saya</a>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 text-center rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary hover:bg-brand-primaryHover text-center rounded-lg transition-colors mt-2">Daftar Sekarang</a>
                @endauth
            </nav>
        </div>
    </aside>

    <header class="fixed w-full top-0 z-50 glass-nav bg-white/80 dark:bg-brand-dark/85 border-b border-gray-200 dark:border-white/5 transition-all duration-300" id="navbar">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <nav class="flex gap-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                        <a href="{{ url('/') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Beranda</a>
                        <a href="{{ route('front.products') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Semua Produk</a>
                        <a href="{{ route('front.articles') }}" class="text-brand-primary font-bold transition-colors">Artikel</a>
                    </nav>

                    <div class="flex items-center gap-4 border-l border-gray-300 dark:border-gray-700 pl-6">
                        <button id="theme-toggle" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                            <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                        </button>
                        <div class="ml-2 flex gap-3 items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-blue-500/20">Dashboard Saya</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white transition-colors">Login</a>
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-lg transition-all shadow-md shadow-blue-500/20">Daftar</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="md:hidden flex items-center gap-4">
                    <button id="theme-toggle-mobile" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                        <i id="theme-toggle-icon-mobile" class="fa-solid fa-moon"></i>
                    </button>
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-brand-primary dark:text-gray-300 dark:hover:text-brand-primary focus:outline-none w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-32 pb-24 min-h-screen">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end gap-6 mb-12 border-b border-gray-200 dark:border-gray-800 pb-6 pt-6">
                <div class="text-center md:text-left w-full md:w-auto">
                    @if(request('search'))
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Hasil Pencarian</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">"{{ request('search') }}" <span class="text-brand-primary text-base font-normal ml-2">({{ $articles->total() }} ditemukan)</span></h3>
                    @elseif(request('category'))
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Topik Artikel</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">{{ request('category') }}</h3>
                        <a href="{{ route('front.articles') }}" class="inline-block mt-3 text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg border border-red-100 dark:border-red-500/20"><i class="fa-solid fa-circle-xmark"></i> Hapus Filter Kategori</a>
                    @else
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Wawasan & Panduan</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">Kumpulan Artikel</h3>
                    @endif
                </div>

                <form action="{{ route('front.articles') }}" method="GET" class="w-full md:w-96 relative">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel atau tutorial..." class="w-full bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-2xl pl-5 pr-14 py-3.5 outline-none focus:border-brand-primary dark:focus:border-brand-primary transition-all shadow-sm text-sm">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 w-10 bg-brand-primary text-white rounded-xl hover:bg-brand-primaryHover transition-colors flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </form>
            </div>

            @if(request('search') && isset($isSimilarSearch) && $isSimilarSearch)
                <div class="mb-8 p-4 rounded-xl bg-orange-50 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20 text-orange-700 dark:text-orange-400 flex items-start sm:items-center gap-3">
                    <i class="fa-solid fa-circle-info text-lg mt-0.5 sm:mt-0"></i>
                    <div>
                        <p class="font-bold text-sm">Pencarian tidak menemukan kecocokan yang persis.</p>
                        <p class="text-xs mt-1">Berikut adalah beberapa artikel yang mungkin berhubungan dengan <strong>"{{ request('search') }}"</strong>.</p>
                    </div>
                </div>
            @elseif(request('search') && session('recommendation'))
                <div class="mb-8 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 text-blue-700 dark:text-blue-400 flex items-start sm:items-center gap-3">
                    <i class="fa-solid fa-lightbulb text-lg mt-0.5 sm:mt-0"></i>
                    <div>
                        <p class="font-bold text-sm">Maaf, kami tidak menemukan artikel untuk "{{ request('search') }}".</p>
                        <p class="text-xs mt-1">Namun jangan khawatir, berikut adalah beberapa wawasan terbaru yang mungkin menarik bagi Anda.</p>
                    </div>
                </div>
            @endif

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
                            <a href="{{ route('front.articles', ['category' => $article->category]) }}" class="absolute top-4 left-4 bg-white/90 dark:bg-slate-900/90 hover:bg-brand-primary hover:text-white backdrop-blur text-gray-900 dark:text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm transition-colors z-10" title="Filter by {{ $article->category }}">
                                {{ $article->category }}
                            </a>
                        </div>
                        <div class="p-6 md:p-8 flex-1 flex flex-col">
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
                            {{ request('search') || request('category') ? 'Artikel Tidak Ditemukan' : 'Belum Ada Artikel' }}
                        </h4>
                        <p class="text-gray-500 text-sm">
                            {{ request('search') || request('category') ? 'Coba gunakan kata kunci pencarian atau filter yang lain.' : 'Admin belum menulis artikel untuk dipublikasikan.' }}
                        </p>
                        @if(request('search') || request('category'))
                            <a href="{{ route('front.articles') }}" class="mt-6 px-6 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white font-bold rounded-xl transition-colors shadow-sm text-sm inline-block">Tampilkan Semua Artikel</a>
                        @endif
                    </div>
                <?php endif; ?>
            </div>

            @if ($articles->hasPages())
            <div class="mt-14 flex justify-center">
                {{ $articles->links() }}
            </div>
            @endif

        </div>
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

    <script>
        const btnOpen = document.getElementById('mobile-menu-btn');
        const btnClose = document.getElementById('close-sidebar-btn');
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() { sidebar.classList.remove('translate-x-full'); overlay.classList.remove('hidden'); setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.add('translate-x-full'); overlay.classList.remove('opacity-100'); overlay.classList.add('opacity-0'); setTimeout(() => { overlay.classList.add('hidden'); }, 300); document.body.style.overflow = ''; }

        if(btnOpen) btnOpen.addEventListener('click', openSidebar);
        if(btnClose) btnClose.addEventListener('click', closeSidebar);
        if(overlay) overlay.addEventListener('click', closeSidebar);

        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');
        const themeToggleIcon = document.getElementById('theme-toggle-icon');
        const themeToggleIconMobile = document.getElementById('theme-toggle-icon-mobile');
        const html = document.documentElement;

        if (html.classList.contains('dark')) { setIcons('dark'); } else { setIcons('light'); }
        function setIcons(theme) {
            if(theme === 'dark') { themeToggleIcon?.classList.replace('fa-moon', 'fa-sun'); themeToggleIconMobile?.classList.replace('fa-moon', 'fa-sun'); } 
            else { themeToggleIcon?.classList.replace('fa-sun', 'fa-moon'); themeToggleIconMobile?.classList.replace('fa-sun', 'fa-moon'); }
        }
        function toggleTheme() {
            if (html.classList.contains('dark')) { html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light'); } 
            else { html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark'); }
        }
        if(themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);
        if(themeToggleBtnMobile) themeToggleBtnMobile.addEventListener('click', toggleTheme);

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) { navbar?.classList.add('scrolled'); } else { navbar?.classList.remove('scrolled'); }
        });
    </script>
</body>
</html>