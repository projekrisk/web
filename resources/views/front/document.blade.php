<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Panduan {{ $document->product->name ?? 'Produk' }}</title>
    
    @if($document->meta_description)
    <meta name="description" content="{{ $document->meta_description }}">
    @endif

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class', 
            theme: { 
                extend: { 
                    fontFamily: { sans: ['"Roboto"', 'sans-serif'] }, 
                    colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB' } } 
                } 
            } 
        }
    </script>
    <style>
        .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .glass-nav.scrolled { box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        
        /* Memaksa elemen H2, H3 dll di dalam konten mengikuti aturan yang bersih */
        .prose h2 { font-size: 1.75rem; font-weight: 800; margin-top: 2em; margin-bottom: 1em; color: inherit; scroll-margin-top: 100px; }
        .prose h3 { font-size: 1.25rem; font-weight: 700; margin-top: 1.5em; margin-bottom: 0.5em; color: inherit; scroll-margin-top: 100px; }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-white text-gray-900 dark:bg-brand-dark dark:text-gray-100 transition-colors duration-300">

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/60 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
    <div id="toc-overlay" class="fixed inset-0 bg-gray-900/60 z-[60] hidden opacity-0 transition-opacity duration-300 lg:hidden"></div>
    
    <aside id="mobile-sidebar" class="fixed top-0 right-0 h-full w-[280px] bg-white dark:bg-gray-900 z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col border-l border-gray-200 dark:border-gray-800">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800">
            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Menu</span>
            <button id="close-sidebar-btn" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-5 flex-1 overflow-y-auto">
            <nav class="flex flex-col space-y-2">
                <a href="{{ url('/#produk') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg">Produk</a>
                <a href="{{ url('/#artikel') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg">Artikel</a>
                <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2"></div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-white bg-brand-primary hover:bg-brand-primaryHover text-center rounded-lg transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 text-center rounded-lg transition-colors">Login</a>
                @endauth
            </nav>
        </div>
    </aside>

    <aside id="mobile-toc-drawer" class="fixed top-0 left-0 h-full w-[280px] bg-white dark:bg-gray-900 z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col border-r border-gray-200 dark:border-gray-800 lg:hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-gray-800">
            <span class="font-bold text-lg tracking-tight text-gray-900 dark:text-white">Navigasi Panduan</span>
            <button id="close-toc-btn" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-5 flex-1 overflow-y-auto custom-scrollbar">
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Daftar Panduan</h4>
            <div class="space-y-1 mb-6">
                @foreach($related_docs as $rdoc)
                    <a href="{{ route('front.document', $rdoc->slug) }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ $rdoc->id == $document->id ? 'bg-blue-50 text-brand-primary dark:bg-blue-900/20 font-semibold' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        {{ $rdoc->title }}
                    </a>
                @endforeach
            </div>
            
            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Daftar Isi Halaman</h4>
            <div id="toc-mobile-list" class="space-y-2"></div>
        </div>
    </aside>

    <button id="mobile-toc-trigger" class="lg:hidden fixed bottom-6 left-6 z-[45] bg-brand-primary text-white w-12 h-12 rounded-full shadow-xl flex items-center justify-center transform transition-transform hover:scale-110">
        <i class="fa-solid fa-book-open text-lg"></i>
    </button>

    <header class="fixed w-full top-0 z-50 glass-nav bg-white/80 dark:bg-brand-dark/85 border-b border-gray-200 dark:border-white/5 transition-all duration-300" id="navbar">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <div class="w-10 h-10 bg-brand-primary rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i class="fa-solid fa-code text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <nav class="flex gap-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                        <a href="{{ url('/#produk') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Produk</a>
                        <a href="{{ url('/#artikel') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Artikel</a>
                    </nav>

                    <div class="flex items-center gap-4 border-l border-gray-300 dark:border-gray-700 pl-6">
                        <button id="theme-toggle" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                            <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                        </button>
                        <div class="ml-2 flex gap-3 items-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-medium rounded-lg transition-colors shadow-md shadow-blue-500/20">Dashboard Saya</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white transition-colors">Login</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="md:hidden flex items-center gap-4">
                    <button id="theme-toggle-mobile" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-full">
                        <i id="theme-toggle-icon-mobile" class="fa-solid fa-moon"></i>
                    </button>
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline-none w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-32 pb-24 min-h-screen">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-8 flex items-center gap-2">
                <a href="{{ url('/') }}" class="hover:text-brand-primary transition-colors">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="{{ url('/produk/'.$document->product->slug) }}" class="hover:text-brand-primary transition-colors">{{ $document->product->name ?? 'Produk' }}</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-brand-primary bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded">Dokumentasi</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative">
                
                <aside class="hidden lg:block lg:col-span-3 relative border-r border-gray-200 dark:border-gray-800 pr-6">
                    <div class="sticky top-28">
                        
                        <div class="mb-6 flex items-center gap-3 bg-gray-50 dark:bg-slate-800 p-4 rounded-xl border border-gray-100 dark:border-slate-700">
                            <div class="w-10 h-10 bg-brand-primary rounded-lg flex items-center justify-center text-white shrink-0"><i class="fa-solid fa-box"></i></div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase">Panduan Untuk:</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $document->product->name ?? 'Produk' }}</p>
                            </div>
                        </div>

                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4"><i class="fa-solid fa-layer-group mr-2 text-brand-primary"></i> Daftar Panduan</h4>
                        <div class="space-y-1">
                            @forelse($related_docs as $rdoc)
                                <a href="{{ route('front.document', $rdoc->slug) }}" class="block px-3 py-2 text-sm rounded-lg transition-colors {{ $rdoc->id == $document->id ? 'bg-blue-50 text-brand-primary dark:bg-blue-900/20 font-semibold' : 'text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-white' }}">
                                    {{ $rdoc->title }}
                                </a>
                            @empty
                                <p class="text-xs text-gray-500">Belum ada panduan lain.</p>
                            @endforelse
                        </div>

                        <div id="toc-desktop-wrapper" class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-800 hidden">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-list-ul text-brand-primary"></i> Di Halaman Ini
                            </h4>
                            <div id="toc-desktop-list" class="space-y-1.5 max-h-[40vh] overflow-y-auto custom-scrollbar pr-2">
                            </div>
                        </div>
                        
                    </div>
                </aside>

                <div class="lg:col-span-9 pl-0 lg:pl-4">
                    
                    @if($document->status == 'draft')
                        <div class="mb-6 bg-orange-50 text-orange-600 border border-orange-200 dark:bg-orange-900/20 dark:text-orange-400 dark:border-orange-800 p-4 rounded-xl font-bold flex items-center gap-3">
                            <i class="fa-solid fa-triangle-exclamation"></i> Anda melihat mode PREVIEW. Dokumen ini masih berstatus DRAFT dan disembunyikan dari publik.
                        </div>
                    @endif

                    @if($document->featured_image)
                        <div class="w-full aspect-[21/9] rounded-2xl overflow-hidden mb-8 bg-gray-100 dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-800">
                            <img src="{{ asset('uploads/' . $document->featured_image) }}" alt="{{ $document->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white leading-[1.25] mb-6">
                        {{ $document->title }}
                    </h1>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 pb-8 border-b border-gray-200 dark:border-gray-800 mb-8">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left"></i> 
                            Diperbarui pada {{ $document->updated_at->format('d F Y') }}
                        </span>
                    </div>

                    <article id="document-content" class="prose text-[16px] dark:prose-invert max-w-none prose-blue prose-img:rounded-xl">
                        {!! $document->content !!}
                    </article>
                    
                </div>
                
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 py-6 mt-12">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} Projekrisk. Hak Cipta Dilindungi.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-white transition-colors">Disclaimer</a>
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const docContent = document.getElementById('document-content');
            const headings = docContent.querySelectorAll('h2, h3');
            const tocDesktopWrapper = document.getElementById('toc-desktop-wrapper');
            const tocDesktopList = document.getElementById('toc-desktop-list');
            const tocMobileList = document.getElementById('toc-mobile-list');

            if (headings.length > 0) {
                let tocHTML = '';
                headings.forEach((heading, index) => {
                    const id = 'heading-' + index;
                    heading.id = id; 
                    
                    const level = heading.tagName.toLowerCase();
                    const styling = level === 'h2' 
                        ? 'font-bold text-gray-800 dark:text-gray-200 text-sm mt-3' 
                        : 'pl-4 text-gray-600 dark:text-gray-400 text-[13px] border-l-2 border-gray-200 dark:border-gray-700 ml-1';
                    
                    tocHTML += `<a href="#${id}" class="block py-1 hover:text-brand-primary transition-colors toc-link ${styling}">${heading.innerText}</a>`;
                });

                tocDesktopList.innerHTML = tocHTML;
                tocMobileList.innerHTML = tocHTML;
                tocDesktopWrapper.classList.remove('hidden');
                
                document.querySelectorAll('.toc-link').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetId = link.getAttribute('href').substring(1);
                        const targetEl = document.getElementById(targetId);
                        if (targetEl) {
                            window.scrollTo({ top: targetEl.offsetTop - 100, behavior: 'smooth' });
                        }
                        closeTocSidebar(); 
                    });
                });
            } else {
                tocDesktopList.innerHTML = '<p class="text-xs text-gray-500">Tidak ada daftar isi.</p>';
                tocMobileList.innerHTML = '<p class="text-xs text-gray-500">Tidak ada daftar isi.</p>';
            }

            const btnOpenToc = document.getElementById('mobile-toc-trigger');
            const btnCloseToc = document.getElementById('close-toc-btn');
            const tocDrawer = document.getElementById('mobile-toc-drawer');
            const tocOverlay = document.getElementById('toc-overlay');

            function openTocSidebar() { tocDrawer.classList.remove('-translate-x-full'); tocOverlay.classList.remove('hidden'); setTimeout(() => { tocOverlay.classList.remove('opacity-0'); }, 10); document.body.style.overflow = 'hidden'; }
            function closeTocSidebar() { tocDrawer.classList.add('-translate-x-full'); tocOverlay.classList.add('opacity-0'); setTimeout(() => { tocOverlay.classList.add('hidden'); }, 300); document.body.style.overflow = ''; }

            if(btnOpenToc) btnOpenToc.addEventListener('click', openTocSidebar);
            if(btnCloseToc) btnCloseToc.addEventListener('click', closeTocSidebar);
            if(tocOverlay) tocOverlay.addEventListener('click', closeTocSidebar);

            const btnOpenMenu = document.getElementById('mobile-menu-btn');
            const btnCloseMenu = document.getElementById('close-sidebar-btn');
            const menuSidebar = document.getElementById('mobile-sidebar');
            const menuOverlay = document.getElementById('sidebar-overlay');
            const navLinks = document.querySelectorAll('.mobile-nav-link');

            function openMenuSidebar() { menuSidebar.classList.remove('translate-x-full'); menuOverlay.classList.remove('hidden'); setTimeout(() => { menuOverlay.classList.remove('opacity-0'); }, 10); document.body.style.overflow = 'hidden'; }
            function closeMenuSidebar() { menuSidebar.classList.add('translate-x-full'); menuOverlay.classList.add('opacity-0'); setTimeout(() => { menuOverlay.classList.add('hidden'); }, 300); document.body.style.overflow = ''; }

            if(btnOpenMenu) btnOpenMenu.addEventListener('click', openMenuSidebar);
            if(btnCloseMenu) btnCloseMenu.addEventListener('click', closeMenuSidebar);
            if(menuOverlay) menuOverlay.addEventListener('click', closeMenuSidebar);
            navLinks.forEach(link => link.addEventListener('click', closeMenuSidebar));

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
            window.addEventListener('scroll', () => { if (window.scrollY > 20) { navbar?.classList.add('scrolled'); } else { navbar?.classList.remove('scrolled'); } });
        });
    </script>
</body>
</html>