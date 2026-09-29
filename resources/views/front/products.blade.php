<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ request('search') ? 'Cari: '.request('search').' - ' : (request('category') ? 'Kategori: '.request('category').' - ' : '') }}Katalog Produk - Projekrisk</title>
    
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
        }
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
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 overflow-x-hidden">

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
                <a href="{{ url('/') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Beranda</a>
                <a href="{{ route('front.products') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary rounded-lg transition-colors shadow-md">Semua Produk</a>
                <a href="{{ route('front.articles') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Artikel</a>

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
                            <a href="{{ url('/') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Beranda</a>
                            <a href="{{ route('front.products') }}" class="text-brand-primary font-bold transition-colors">Semua Produk</a>
                            <a href="{{ route('front.articles') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Artikel</a>
                        </nav>

                        <div class="flex items-center gap-4 border-l border-gray-300 dark:border-gray-700 pl-6">
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
    </div>

    <main class="pt-28 pb-24 min-h-screen">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center md:items-end gap-6 mb-8 border-b border-gray-200 dark:border-gray-800 pb-6 pt-6">
                <div class="text-center md:text-left w-full md:w-auto">
                    @if(request('search'))
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Hasil Pencarian</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">"{{ request('search') }}"</h3>
                    @elseif(request('category'))
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Kategori Produk</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">{{ request('category') }}</h3>
                        <a href="{{ route('front.products') }}" class="inline-block mt-3 text-sm text-red-500 hover:text-red-700 font-medium bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg border border-red-100 dark:border-red-500/20"><i class="fa-solid fa-circle-xmark"></i> Hapus Filter Kategori</a>
                    @else
                        <h2 class="text-brand-primary font-bold tracking-widest uppercase text-sm mb-2">Katalog Premium</h2>
                        <h3 class="text-2xl md:text-3xl font-normal text-gray-900 dark:text-white">Semua Produk</h3>
                    @endif
                </div>

                <form action="{{ route('front.products') }}" method="GET" class="w-full md:w-96 relative">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aplikasi atau source code..." class="w-full bg-white dark:bg-slate-800 border-2 border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-2xl pl-5 pr-14 py-3.5 outline-none focus:border-brand-primary dark:focus:border-brand-primary transition-all shadow-sm text-sm">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 w-10 bg-brand-primary text-white rounded-xl hover:bg-brand-primaryHover transition-colors flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </form>
            </div>

            @if(request('search') && isset($isSimilarSearch) &&$isSimilarSearch)
                <div class="mb-8 p-4 rounded-xl bg-orange-50 dark:bg-orange-500/10 border border-orange-200 dark:border-orange-500/20 text-orange-700 dark:text-orange-400 flex items-start sm:items-center gap-3">
                    <i class="fa-solid fa-circle-info text-lg mt-0.5 sm:mt-0"></i>
                    <div>
                        <p class="font-bold text-sm">Pencarian tidak menemukan kecocokan yang persis.</p>
                        <p class="text-xs mt-1">Berikut adalah beberapa produk yang mungkin berhubungan dengan <strong>"{{ request('search') }}"</strong> berdasarkan kata kunci yang mirip.</p>
                    </div>
                </div>
            @elseif(request('search') && session('recommendation'))
                <div class="mb-8 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/20 text-blue-700 dark:text-blue-400 flex items-start sm:items-center gap-3">
                    <i class="fa-solid fa-lightbulb text-lg mt-0.5 sm:mt-0"></i>
                    <div>
                        <p class="font-bold text-sm">Maaf, kami tidak menemukan produk untuk "{{ request('search') }}".</p>
                        <p class="text-xs mt-1">Namun jangan khawatir, berikut adalah rekomendasi katalog produk premium kami untuk Anda eksplorasi.</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if(count($products) > 0): ?>
                    <?php foreach($products as$product): ?>
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
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 flex flex-col items-center justify-center py-10 bg-white dark:bg-slate-700/30 rounded-3xl border-2 border-dashed border-gray-200 dark:border-slate-600">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                            @if(request('search'))
                                <i class="fa-solid fa-magnifying-glass text-3xl text-gray-400"></i>
                            @else
                                <i class="fa-solid fa-box-open text-3xl text-gray-400"></i>
                            @endif
                        </div>
                        <h4 class="text-xl font-normal text-gray-900 dark:text-white mb-2">
                            {{ request('search') || request('category') ? 'Produk Tidak Ditemukan' : 'Katalog Masih Kosong' }}
                        </h4>
                        <p class="text-gray-500 text-sm max-w-md text-center">
                            {{ request('search') || request('category') ? 'Maaf, kami tidak menemukan produk yang sesuai dengan kriteria filter Anda.' : 'Admin belum menambahkan produk yang aktif.' }}
                        </p>
                        @if(request('search') || request('category'))
                            <a href="{{ route('front.products') }}" class="mt-6 px-6 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white font-bold rounded-xl transition-colors shadow-sm text-sm">Kembali ke Semua Katalog</a>
                        @endif
                    </div>
                <?php endif; ?>
            </div>

            @if ($products->hasPages())
            <div class="mt-14 flex justify-center">
                {{ $products->links() }}
            </div>
            @endif

        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 py-10 text-center md:text-left">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-8 h-8 opacity-80 grayscale hover:grayscale-0 transition-all">
                <p class="text-gray-400 text-sm font-medium">
                    &copy; {{ date('Y') }} Projekrisk. Hak Cipta Dilindungi.
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
        document.addEventListener('DOMContentLoaded', () => {
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

            if(btnOpen) btnOpen.addEventListener('click', openSidebar);
            if(btnClose) btnClose.addEventListener('click', closeSidebar);
            if(overlay) overlay.addEventListener('click', closeSidebar);
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

            if(themeToggleBtn) themeToggleBtn.addEventListener('click', toggleTheme);
            if(themeToggleBtnMobile) themeToggleBtnMobile.addEventListener('click', toggleTheme);

            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) { navbar?.classList.add('scrolled'); } 
                else { navbar?.classList.remove('scrolled'); }
            });
        });
    </script>
</body>
</html>