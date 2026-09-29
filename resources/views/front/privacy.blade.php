<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - Projekrisk</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Roboto"', 'sans-serif'] }, colors: { brand: { dark: '#151A22', primary: '#3B82F6' } } } } }
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
                    <button onclick="history.back()" class="text-sm font-bold text-gray-600 dark:text-gray-300 hover:text-brand-primary transition-colors flex items-center gap-2"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
                    <div class="w-px h-6 bg-gray-300 dark:bg-gray-700"></div>
                    <button id="theme-toggle" class="text-gray-500 hover:text-brand-primary transition-colors w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800"><i id="theme-toggle-icon" class="fa-solid fa-moon"></i></button>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 pt-32 pb-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div>
                
                <h1 class="text-3xl md:text-4xl font-normal text-gray-900 dark:text-white mb-3">Kebijakan Privasi</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-5 border-b border-gray-100 dark:border-slate-700 pb-6 flex items-center gap-2">
                    <i class="fa-regular fa-clock"></i> Berlaku Efektif: {{ date('d M Y') }}
                </p>

                <div class="prose prose-blue dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                    
                    <p>
                        Keamanan dan privasi data Anda adalah prioritas utama kami. Dokumen Kebijakan Privasi ini menjelaskan jenis informasi yang dikumpulkan oleh <strong class="text-gray-900 dark:text-white">Projekrisk</strong> dan bagaimana kami menggunakannya.
                    </p>

                        <h2 class="text-2xl mt-10 font-normal text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                            Informasi yang Kami Kumpulkan
                        </h2>
                        <p>Saat Anda mendaftar atau bertransaksi di website kami, kami menyimpan informasi dasar yang Anda berikan, yaitu:</p>
                        <ul>
                            <li>
                                Nama Lengkap untuk identitas member.
                            </li>
                            <li>
                                Alamat Email Aktif untuk login dan pengiriman invoice.
                            </li>
                            <li>
                                Nomor WhatsApp untuk konfirmasi pesanan yang lebih cepat.
                            </li>
                            <li>
                                Riwayat Transaksi dan IP Address untuk standar keamanan.
                            </li>
                        </ul>

                        <h2 class="text-2xl mt-10 font-normal text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                            Penggunaan Data Anda
                        </h2>
                        <p>Data yang dikumpulkan secara eksklusif hanya digunakan untuk keperluan internal layanan kami, yaitu:</p>
                        <ul>
                            <li>
                                Memverifikasi kepemilikan akun dan pembayaran Anda.
                            </li>
                            <li>
                                Mengirimkan detail akses produk dan bukti pembayaran.
                            </li>
                            <li>
                                Menginformasikan pembaruan teknis (update aplikasi/bug) terkait produk yang Anda beli.
                            </li>
                        </ul>
                        
                        <div class="p-5 py-0 bg-blue-50 dark:bg-slate-900/50 mt-5 rounded-2xl border border-blue-100 dark:border-slate-700 flex items-start gap-4">
                            <p class="text-blue-900 dark:text-blue-100 leading-relaxed">
                                Kami menjamin penuh bahwa <strong class="font-bold">data Anda tidak akan pernah dijual atau dibagikan</strong> kepada pihak ketiga mana pun untuk kepentingan pemasaran eksternal.
                            </p>
                        </div>

                        <h2 class="text-2xl mt-10 font-normal text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                            Keamanan Data
                        </h2>
                        <p>Sistem kami menggunakan enkripsi (Hashing) modern standar industri (Bcrypt) untuk melindungi kata sandi Anda. Kami sangat menyarankan agar Anda menggunakan kata sandi yang kuat dan tidak membagikannya kepada siapa pun.</p>

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 border-t border-gray-800 py-8 text-center text-gray-500 text-sm mt-auto">
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