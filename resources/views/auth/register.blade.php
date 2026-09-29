<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Projekrisk</title>
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
                    colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB' } } 
                } 
            } 
        }
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 min-h-screen py-10 px-4 flex flex-col items-center justify-center transition-colors duration-300 relative overflow-x-hidden">

    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-brand-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-lg relative z-10">
        
        <div class="sm:bg-white sm:dark:bg-slate-800 sm:rounded-3xl sm:shadow-2xl sm:border border-transparent sm:border-gray-100 sm:dark:border-slate-700/50 p-4 sm:p-10 relative">
            
            <button id="theme-toggle" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors flex items-center justify-center w-10 h-10 bg-gray-50 dark:bg-slate-900 rounded-full shadow-sm border border-gray-200 dark:border-slate-700">
                <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
            </button>

            <div class="text-center mb-8 pt-6 sm:pt-0">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 cursor-pointer">
                    <img src="{{ asset('icon.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-3xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>
                <p class="text-gray-500 dark:text-gray-400 mt-3 text-sm">Buat akun baru untuk mulai mengakses produk digital kami.</p>
            </div>
            
            <?php if ($errors->any()): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                        <?php foreach ($errors->all() as$error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-user text-gray-400"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor WhatsApp</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-brands fa-whatsapp text-gray-400"></i>
                        </div>
                        <input id="whatsapp_number" type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required placeholder="Contoh: 081234567890" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-8">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock-open text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                    Daftar Sekarang <i class="fa-solid fa-user-plus text-sm"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-slate-700/50 pt-6">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:underline transition-colors">Masuk di sini</a>
            </div>
        </div>
        
    </div>

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