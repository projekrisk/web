<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Projekrisk</title>
    
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
                    fontFamily: {
                        sans: ['"Roboto"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#151A22',
                            primary: '#3B82F6',
                            primaryHover: '#2563EB',
                            success: '#10B981',
                            danger: '#EF4444',
                            warning: '#F59E0B'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-900 dark:bg-slate-900 dark:text-gray-100 transition-colors duration-300 relative">

    <div id="toast-container" class="fixed top-5 right-5 z-[100] flex flex-col gap-3"></div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden lg:hidden opacity-0 transition-opacity duration-300"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-64 bg-white dark:bg-brand-dark border-r border-gray-200 dark:border-gray-800 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
        <div class="h-16 flex items-center gap-3 px-6 border-b border-gray-200 dark:border-gray-800">
            <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-10 h-10 object-contain drop-shadow-md">
            </a>
            <span class="font-bold text-xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                Dasbor
            </a>
            
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.products.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-box-open w-5 text-center"></i>
                Produk
            </a>

            @php
                $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
            @endphp
            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3 py-2.5 {{ request()->routeIs('admin.orders.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
                    Pesanan
                </div>
                @if($pendingOrders > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $pendingOrders }}</span>
                @endif
            </a>

            <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.articles.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-newspaper w-5 text-center"></i>
                Artikel
            </a>

            <a href="{{ route('admin.documents.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.documents.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-book w-5 text-center"></i>
                Dokumentasi
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-star w-5 text-center"></i> Ulasan
            </a>

            <a href="{{ route('admin.payment_methods.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.payment_methods.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-building-columns w-5 text-center"></i> Rekening
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary/10 text-brand-primary dark:bg-brand-primary/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-gray-900 dark:hover:text-white' }} rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-users w-5 text-center"></i> Pengguna
            </a>           
            
        </nav>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-brand-danger transition-colors p-2" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        <header class="sticky top-0 z-30 h-16 bg-white dark:bg-brand-dark border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-4 sm:px-6 transition-colors duration-300 shadow-sm">
            <div class="flex items-center gap-4 flex-1">
                <button id="mobile-menu-btn" class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                
                <div class="hidden sm:flex relative w-full max-w-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Cari data..." class="w-full bg-gray-100 dark:bg-slate-800 text-gray-900 dark:text-white text-sm rounded-lg pl-9 pr-4 py-2 border border-transparent focus:border-brand-primary focus:bg-white dark:focus:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 transition-all">
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-5">
                <button id="theme-toggle" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                    <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                </button>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        function showCustomToast(type, title, message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            let iconClass, bgColor, borderColor, textColor, iconColor;
            
            if(type === 'success') {
                iconClass = 'fa-circle-check';
                bgColor = 'bg-white dark:bg-slate-800';
                borderColor = 'border-green-500';
                textColor = 'text-gray-900 dark:text-white';
                iconColor = 'text-green-500';
            } else if(type === 'error') {
                iconClass = 'fa-circle-exclamation';
                bgColor = 'bg-white dark:bg-slate-800';
                borderColor = 'border-red-500';
                textColor = 'text-gray-900 dark:text-white';
                iconColor = 'text-red-500';
            }

            toast.className = `flex items-center gap-3 p-4 rounded-xl shadow-xl border-l-4 ${borderColor} ${bgColor} transform translate-x-full opacity-0 transition-all duration-300 min-w-[300px]`;
            toast.innerHTML = `
                <i class="fa-solid ${iconClass} ${iconColor} text-2xl"></i>
                <div class="flex-1">
                    <h4 class="font-bold ${textColor} text-sm">${title}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => { toast.classList.remove('translate-x-full', 'opacity-0'); }, 10);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => { toast.remove(); }, 300);
            }, 3500);
        }

        @if(session('success')) showCustomToast('success', 'Berhasil!', '{{ session("success") }}'); @endif
        @if(session('error')) showCustomToast('error', 'Gagal!', '{{ session("error") }}'); @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');
            const html = document.documentElement;

            if (html.classList.contains('dark')) { setIcons('dark'); } else { setIcons('light'); }

            function setIcons(theme) {
                if(theme === 'dark') {
                    themeToggleIcon.classList.remove('fa-moon'); themeToggleIcon.classList.add('fa-sun');
                } else {
                    themeToggleIcon.classList.remove('fa-sun'); themeToggleIcon.classList.add('fa-moon');
                }
            }

            themeToggleBtn.addEventListener('click', () => {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light');
                } else {
                    html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark');
                }
            });

            const btnMobileMenu = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            btnMobileMenu.addEventListener('click', () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
                document.body.style.overflow = 'hidden'; 
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => { overlay.classList.add('hidden'); }, 300);
                document.body.style.overflow = '';
            });
        });
    </script>
</body>
</html>