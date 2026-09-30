<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - Projekrisk</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Roboto"', 'sans-serif'] }, colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB' } } } } }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) { document.documentElement.classList.add('dark'); } else { document.documentElement.classList.remove('dark'); }
    </script>
    <style> .glass-nav { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); } .glass-nav.scrolled { box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05); } </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-900 dark:bg-brand-dark dark:text-gray-100 transition-colors duration-300 flex flex-col min-h-screen">

    <header class="fixed w-full top-0 z-50 glass-nav bg-white/80 dark:bg-brand-dark/85 border-b border-gray-200 dark:border-white/5 transition-all duration-300" id="navbar">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-brand-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-home"></i> Beranda</a>
                    <div class="w-px h-6 bg-gray-300 dark:bg-gray-700"></div>
                    <button id="theme-toggle" class="text-gray-500 hover:text-brand-primary transition-colors w-8 h-8 flex items-center justify-center rounded-full"><i id="theme-toggle-icon" class="fa-solid fa-moon"></i></button>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-32 pb-24 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                
                <div class="w-20 h-20 bg-blue-50 dark:bg-slate-700 text-brand-primary rounded-full flex items-center justify-center mx-auto text-3xl mb-6">
                    <i class="fa-solid fa-headset"></i>
                </div>
                
                <h1 class="text-3xl font-normal text-gray-900 dark:text-white mb-3">Butuh Bantuan?</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base leading-relaxed mb-8 max-w-lg mx-auto">Tim kami siap membantu Anda menyelesaikan masalah teknis, konfirmasi pembayaran, maupun pertanyaan terkait kustomisasi produk.</p>

                <div class="space-y-4 max-w-sm mx-auto">
                    @php
                        $waNumber = env('WHATSAPP_ADMIN_NUMBER', '6281311665601');
                        $waLink = "https://wa.me/" . $waNumber . "?text=Halo%20Tim%20Projekrisk,%20saya%20butuh%20bantuan%20mengenai...";
                    @endphp
                    
                    <a href="{{ $waLink }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#1ebd5b] text-white font-bold py-2.5 rounded-xl transition-all shadow-lg shadow-green-500/30 flex items-center justify-center gap-3">
                        <i class="fa-brands fa-whatsapp text-xl"></i> Chat WhatsApp
                    </a>
                    
                    <a href="mailto:support@projekrisk.com" class="w-full bg-gray-100 dark:bg-slate-900 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 font-bold py-2.5 rounded-xl transition-colors border border-gray-200 dark:border-slate-600 flex items-center justify-center gap-3">
                        <i class="fa-regular fa-envelope text-lg"></i> Kirim Email
                    </a>
                </div>

                <div class="mt-10 border-t border-gray-100 dark:border-slate-700 pt-6">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-widest">Jam Operasional Pelayanan</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 font-bold">Senin - Jumat (09:00 - 17:00 WIB)</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 py-8 text-center text-gray-500 text-sm">
        <div class="max-w-[1100px] mx-auto px-4">&copy; {{ date('Y') }} Projekrisk.</div>
    </footer>

    <script>
        const btn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');
        const html = document.documentElement;
        if (html.classList.contains('dark')) { icon.classList.replace('fa-moon', 'fa-sun'); }
        btn.addEventListener('click', () => {
            if (html.classList.contains('dark')) { html.classList.remove('dark'); localStorage.theme = 'light'; icon.classList.replace('fa-sun', 'fa-moon'); } 
            else { html.classList.add('dark'); localStorage.theme = 'dark'; icon.classList.replace('fa-moon', 'fa-sun'); }
        });
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => { if (window.scrollY > 20) { navbar.classList.add('scrolled'); } else { navbar.classList.remove('scrolled'); } });
    </script>
</body>
</html>