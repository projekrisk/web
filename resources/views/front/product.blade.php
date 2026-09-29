<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Projekrisk</title>
    
    @if($product->meta_description)
    <meta name="description" content="{{ $product->meta_description }}">
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
        
        .prose p { margin-top: 1em !important; margin-bottom: 1em !important; line-height: 1.7 !important; }
        .prose ul { list-style-type: disc !important; margin-top: 0.5em !important; margin-bottom: 0.5em !important; padding-left: 1.5rem !important; }
        .prose ol { list-style-type: decimal !important; margin-top: 0.5em !important; margin-bottom: 0.5em !important; padding-left: 1.5rem !important; }
        .prose li { margin-top: 0.25em !important; margin-bottom: 0.25em !important; line-height: 1.6 !important; }
        .prose li p { margin-top: 0 !important; margin-bottom: 0 !important; }
        .prose h1, .prose h2, .prose h3, .prose h4 { margin-top: 1.5em !important; margin-bottom: 0.5em !important; line-height: 1.3 !important; font-weight: 700 !important; }
    </style>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-white text-gray-900 dark:bg-brand-dark dark:text-gray-100 transition-colors duration-300 overflow-x-hidden">

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
                <a href="{{ url('/#artikel') }}" class="mobile-nav-link block px-4 py-3 text-base font-medium text-gray-700 dark:text-gray-300 hover:text-brand-primary dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">Artikel</a>
                
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
                    <img src="{{ asset('icon.png') }}" alt="Projekrisk Logo" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <nav class="flex gap-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                        <a href="{{ url('/') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Beranda</a>
                        <a href="{{ route('front.products') }}" class="hover:text-brand-primary dark:hover:text-white transition-colors">Semua Produk</a>
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
                                <a href="{{ route('register') }}" class="px-5 py-2 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-medium rounded-lg transition-colors shadow-md shadow-blue-500/20">Daftar</a>
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
        <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 text-green-700 dark:text-green-400 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <nav class="text-sm text-gray-500 dark:text-gray-400 mb-8 flex items-center gap-2">
                <a href="{{ url('/') }}" class="hover:text-brand-primary transition-colors">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="{{ route('front.products') }}" class="hover:text-brand-primary transition-colors">Produk</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-gray-900 dark:text-gray-200 truncate">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-16">
                <div class="space-y-4">
                    <?php
                        $allImages = [];
                        if ($product->featured_image) {
                            $allImages[] = asset('uploads/' . $product->featured_image);
                        }
                        if ($product->gallery && is_array($product->gallery)) {
                            foreach($product->gallery as $img) {
                                $allImages[] = asset('uploads/' . $img);
                            }
                        }
                        $imgJson = json_encode($allImages);
                    ?>

                    <div class="w-full aspect-square rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-gray-800/50 relative group cursor-zoom-in" onclick="openLightbox(0)">
                        @if($product->featured_image)
                            <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-expand text-white opacity-0 group-hover:opacity-100 transition-opacity text-3xl drop-shadow-md"></i>
                        </div>
                    </div>

                    <?php if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0): ?>
                    <div class="grid grid-cols-4 gap-4">
                        <?php foreach($product->gallery as $index => $img): ?>
                            <div class="w-full aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 bg-gray-50 dark:bg-gray-800/50 relative group cursor-zoom-in" onclick="openLightbox({{ $index + 1 }})">
                                <img src="{{ asset('uploads/' . $img) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col justify-start">
                    <div class="flex items-center gap-3 mb-3">
                        <a href="{{ route('front.products', ['category' => $product->category]) }}" class="inline-block text-brand-primary dark:text-blue-400 hover:text-brand-primaryHover text-xs font-bold uppercase tracking-wider transition-colors" title="Lihat semua produk di kategori {{ $product->category }}">
                            <i class="fa-solid fa-tag mr-1"></i> {{ $product->category }}
                        </a>
                        
                        <?php
                            $avg = $product->averageRating();
                            $cnt = $product->reviewsCount();
                        ?>
                        <a href="#ulasan-produk" class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 hover:text-brand-primary transition-colors">
                            <div class="flex text-yellow-400 text-xs">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?php echo $i <= round($avg) ? 'text-yellow-400' : 'text-gray-200 dark:text-slate-600'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ number_format($avg, 1) }}</span>
                            <span>({{ $cnt }} ulasan)</span>
                        </a>
                    </div>
                    
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white leading-normal mb-4">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="mb-6 flex flex-wrap items-end gap-3">
                        <p class="text-brand-primary font-normal text-4xl">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @if($product->strike_price)
                            <p class="text-gray-400 dark:text-gray-500 line-through text-lg pb-1">Rp {{ number_format($product->strike_price, 0, ',', '.') }}</p>
                        @endif
                    </div>

                    <div class="text-gray-600 dark:text-gray-400 text-[16px] md:text-[18px] leading-relaxed mb-8">
                        {{ $product->meta_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description), 200, '...') }}
                    </div>

                    <div class="mt-2 flex flex-col sm:flex-row gap-3 w-full sm:w-auto mb-8">
                        <a href="{{ route('front.checkout', $product->slug) }}" class="flex-1 sm:flex-none px-6 py-3.5 bg-brand-primary hover:bg-brand-primaryHover text-white font-bold rounded-xl transition-all shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 text-sm group inline-flex">
                            <i class="fa-solid fa-cart-shopping group-hover:-rotate-12 transition-transform"></i> Beli Sekarang
                        </a>
                        
                        @if($product->demo_url)
                            <a href="{{ $product->demo_url }}" target="_blank" class="flex-1 sm:flex-none px-6 py-3.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-gray-200 hover:border-brand-primary dark:hover:border-brand-primary hover:text-brand-primary font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 text-sm group">
                                @if(isset($isYoutube) && $isYoutube)
                                    <i class="fa-brands fa-youtube text-red-500 text-lg group-hover:scale-110 transition-transform"></i> Tonton Video
                                @else
                                    <i class="fa-solid fa-desktop text-gray-400 group-hover:text-brand-primary transition-colors"></i> Lihat Demo
                                @endif
                            </a>
                        @else
                            <button disabled class="flex-1 sm:flex-none px-6 py-3.5 bg-gray-100 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700/50 text-gray-400 dark:text-gray-500 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2 text-sm">
                                <i class="fa-solid fa-desktop opacity-50"></i> Demo Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div id="detail-lengkap" class="mt-20 pt-16 border-t border-gray-200 dark:border-gray-800">
                <h3 class="text-2xl font-normal text-gray-900 dark:text-white mb-8 relative inline-block">
                    Detail Produk
                    <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-brand-primary rounded-full"></span>
                </h3>
                
                <div class="prose prose-base md:prose-lg dark:prose-invert max-w-none w-full prose-blue prose-img:rounded-xl">
                    {!! $product->description !!}
                </div>
                
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-slate-800 mb-12">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Bagikan Produk:</p>
                    <?php 
                        $currentUrl = urlencode(url()->current()); 
                        $shareText = urlencode('Lihat produk keren ini: ' . $product->name); 
                    ?>
                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $currentUrl }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-50 dark:bg-slate-800 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center text-sm" title="Bagikan ke Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ $currentUrl }}&text={{ $shareText }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-50 dark:bg-slate-800 text-blue-400 hover:bg-blue-400 hover:text-white transition-colors flex items-center justify-center text-sm" title="Bagikan ke Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20-%20{{ $currentUrl }}" target="_blank" class="w-9 h-9 rounded-full bg-green-50 dark:bg-slate-800 text-green-500 hover:bg-green-500 hover:text-white transition-colors flex items-center justify-center text-sm" title="Bagikan ke WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <?php if(isset($relatedProducts) && count($relatedProducts) > 0): ?>
                <div class="pt-10 border-t border-gray-200 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-normal text-gray-900 dark:text-white">Produk Terkait</h3>
                        <a href="{{ route('front.products', ['category' => $product->category]) }}" class="text-sm font-bold text-brand-primary hover:underline hidden sm:inline-block">Lihat lainnya <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach($relatedProducts as $related): ?>
                        <div class="bg-white dark:bg-slate-700/50 rounded-2xl overflow-hidden shadow-sm border border-gray-200/80 dark:border-slate-600/50 flex flex-col card-hover">
                            <div class="relative aspect-video">
                                @if($related->featured_image)
                                    <img src="{{ asset('uploads/' . $related->featured_image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image text-5xl"></i>
                                    </div>
                                @endif
                                <a href="{{ route('front.products', ['category' => $related->category]) }}" class="absolute top-3 left-3 bg-brand-primary hover:bg-brand-primaryHover text-white text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider shadow-sm transition-colors z-10" title="Filter by {{ $related->category }}">
                                    {{ $related->category }}
                                </a>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h4 class="text-normal font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-brand-primary transition-colors cursor-pointer">
                                    <a href="{{ url('/produk/'.$related->slug) }}">{{ $related->name }}</a>
                                </h4>
                                <div class="mt-auto pt-4 border-t border-gray-100 dark:border-slate-600/50">
                                    <p class="text-brand-primary font-normal text-lg mb-2">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                    <a href="{{ url('/produk/'.$related->slug) }}" class="w-full text-center inline-block bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-900 text-gray-900 dark:text-white text-xs font-bold py-2.5 rounded-lg transition-colors border border-gray-200 dark:border-slate-600">Detail</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <section id="ulasan-produk" class="mt-10 pt-10 border-t border-gray-200 dark:border-gray-800 scroll-mt-24">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div>
                        <h3 class="text-2xl font-normal text-gray-900 dark:text-white">Ulasan Pembeli</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Review asli dari member yang telah membeli dan menggunakan produk ini.</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-800 p-4 rounded-2xl border border-gray-200 dark:border-slate-700 flex items-center gap-4">
                        <div class="text-center px-2">
                            <span class="text-4xl font-normal text-gray-900 dark:text-white leading-none">{{ number_format($avg, 1) }}</span>
                            <span class="text-xs text-gray-400 block mt-1">dari 5.0</span>
                        </div>
                        <div class="border-l border-gray-200 dark:border-slate-700 pl-4">
                            <div class="flex text-yellow-400 text-sm mb-1">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?php echo $i <= round($avg) ? 'text-yellow-400' : 'text-gray-200 dark:text-slate-600'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Berdasarkan <strong>{{ $cnt }}</strong> ulasan</p>
                        </div>
                    </div>
                </div>

                @if($canReview)
                    @if(!$userReview)
                        <div class="bg-blue-50/60 dark:bg-slate-800/80 rounded-2xl p-6 md:p-8 border border-blue-100 dark:border-slate-700 mb-12">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Tulis Ulasan Anda</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Bagikan pengalaman Anda menggunakan produk ini untuk membantu pembeli lain.</p>

                            <form action="{{ route('front.review.store', $product->slug) }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2">Pilih Rating Bintang:</label>
                                    <div class="flex items-center gap-2" id="star-rating-container">
                                        <?php $selectedRating = old('rating', 5); ?>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <button type="button" data-val="{{ $i }}" class="star-btn text-2xl transition-transform hover:scale-125 focus:outline-none <?php echo $i <= $selectedRating ? 'text-yellow-400' : 'text-gray-300 dark:text-slate-600'; ?>">
                                                <i class="fa-solid fa-star"></i>
                                            </button>
                                        <?php endfor; ?>
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ $selectedRating }}">
                                </div>
                                <div class="mb-5">
                                    <label for="comment" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-2">Komentar / Pengalaman Anda:</label>
                                    <textarea name="comment" id="comment" rows="3" required placeholder="Ceritakan bagaimana produk ini membantu proyek Anda..." class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl p-4 text-sm focus:ring-2 focus:ring-brand-primary outline-none transition-all">{{ old('comment') }}</textarea>
                                </div>
                                <button type="submit" class="px-6 py-2.5 bg-brand-primary hover:bg-brand-primaryHover text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-blue-500/20">
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mb-10 p-4 rounded-xl bg-green-50 dark:bg-slate-800/80 border border-green-200 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-500/20 text-green-600 dark:text-green-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-check-circle text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-green-800 dark:text-green-400 text-sm">Anda telah memberikan ulasan</p>
                                <p class="text-xs text-green-700 dark:text-gray-400 mt-0.5">Terima kasih atas tanggapan Anda mengenai produk ini. Ulasan Anda sangat berharga.</p>
                            </div>
                        </div>
                    @endif
                @endif

                <div class="space-y-6">
                    <?php if(count($product->reviews) > 0): ?>
                        <?php foreach($product->reviews as $review): ?>
                        <div class="p-6 rounded-2xl bg-gray-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-brand-primary text-white font-bold flex items-center justify-center text-sm shadow-sm">
                                        {{ substr($review->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-gray-900 dark:text-white text-sm leading-tight">{{ $review->user->name ?? 'User Anonim' }}</h5>
                                        <span class="inline-flex items-center gap-1 text-[10px] text-green-600 dark:text-green-400 font-semibold mt-0.5">
                                            <i class="fa-solid fa-circle-check"></i> Pembeli Terverifikasi
                                        </span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex text-yellow-400 text-xs mb-3">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-solid fa-star <?php echo $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-slate-600'; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                {{ $review->comment }}
                            </p>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-12 text-center bg-gray-50 dark:bg-slate-800/40 rounded-2xl border border-dashed border-gray-200 dark:border-slate-700">
                            <i class="fa-regular fa-comment-dots text-4xl text-gray-300 dark:text-slate-600 mb-3 block"></i>
                            <h4 class="font-bold text-gray-900 dark:text-white text-base mb-1">Belum Ada Ulasan</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">Jadilah yang pertama mengulas produk ini setelah melakukan pembelian!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

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

    <div id="lightbox-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-sm p-4 transition-opacity">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white/70 hover:text-white focus:outline-none transition-colors w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 z-50">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
        
        <button id="lb-prev" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white focus:outline-none transition-colors w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 z-50 hidden">
            <i class="fa-solid fa-chevron-left text-2xl"></i>
        </button>
        
        <img id="lightbox-img" src="" alt="Preview" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transition-transform duration-300">
        
        <button id="lb-next" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white focus:outline-none transition-colors w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 z-50 hidden">
            <i class="fa-solid fa-chevron-right text-2xl"></i>
        </button>
    </div>

    <script>
        const galleryImages = <?php echo isset($imgJson) ? $imgJson : '[]'; ?>;
        let currentImageIndex = 0;
        
        const lbModal = document.getElementById('lightbox-modal');
        const lbImg = document.getElementById('lightbox-img');
        const btnPrev = document.getElementById('lb-prev');
        const btnNext = document.getElementById('lb-next');

        function openLightbox(index) {
            if (galleryImages.length === 0) return;
            
            currentImageIndex = index;
            updateLightboxContent();
            
            lbModal.classList.remove('hidden');
            lbModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            if (galleryImages.length > 1) {
                btnPrev.classList.remove('hidden');
                btnNext.classList.remove('hidden');
            }
        }

        function closeLightbox() {
            lbModal.classList.add('hidden');
            lbModal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function updateLightboxContent() {
            lbImg.src = galleryImages[currentImageIndex];
            
            btnPrev.onclick = (e) => {
                e.stopPropagation(); 
                currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                updateLightboxContent();
            };
            btnNext.onclick = (e) => {
                e.stopPropagation();
                currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                updateLightboxContent();
            };
        }

        document.addEventListener('keydown', (e) => {
            if (!lbModal.classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft' && galleryImages.length > 1) btnPrev.click();
                if (e.key === 'ArrowRight' && galleryImages.length > 1) btnNext.click();
            }
        });

        lbModal.addEventListener('click', (e) => {
            if (e.target.id === 'lightbox-modal') { closeLightbox(); }
        });

        const btnOpenMenu = document.getElementById('mobile-menu-btn');
        const btnCloseMenu = document.getElementById('close-sidebar-btn');
        const menuSidebar = document.getElementById('mobile-sidebar');
        const menuOverlay = document.getElementById('sidebar-overlay');
        const navLinks = document.querySelectorAll('.mobile-nav-link');

        function openSidebar() { menuSidebar.classList.remove('translate-x-full'); menuOverlay.classList.remove('hidden'); setTimeout(() => { menuOverlay.classList.remove('opacity-0'); menuOverlay.classList.add('opacity-100'); }, 10); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { menuSidebar.classList.add('translate-x-full'); menuOverlay.classList.remove('opacity-100'); menuOverlay.classList.add('opacity-0'); setTimeout(() => { menuOverlay.classList.add('hidden'); }, 300); document.body.style.overflow = ''; }

        if(btnOpenMenu) btnOpenMenu.addEventListener('click', openSidebar);
        if(btnCloseMenu) btnCloseMenu.addEventListener('click', closeSidebar);
        if(menuOverlay) menuOverlay.addEventListener('click', closeSidebar);
        navLinks.forEach(link => link.addEventListener('click', closeSidebar));

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

        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');

        if(starBtns) {
            starBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-val'));
                    ratingInput.value = val;

                    starBtns.forEach((sBtn, idx) => {
                        if (idx < val) {
                            sBtn.classList.remove('text-gray-300', 'dark:text-slate-600');
                            sBtn.classList.add('text-yellow-400');
                        } else {
                            sBtn.classList.remove('text-yellow-400');
                            sBtn.classList.add('text-gray-300', 'dark:text-slate-600');
                        }
                    });
                });
            });
        }
    </script>
</body>
</html>