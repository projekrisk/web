<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Projekrisk</title>
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

    <div class="w-full max-w-md relative z-10">
        <div class="sm:bg-white sm:dark:bg-slate-800 sm:rounded-3xl sm:shadow-2xl sm:border border-transparent sm:border-gray-100 sm:dark:border-slate-700/50 p-4 sm:p-10 relative">
            
            <button id="theme-toggle" class="absolute top-2 right-2 sm:top-6 sm:right-6 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors flex items-center justify-center w-10 h-10 bg-white sm:bg-gray-50 dark:bg-slate-800 sm:dark:bg-slate-900 rounded-full shadow-sm border border-gray-200 dark:border-slate-700">
                <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
            </button>

            <div class="text-center mb-8 pt-8 sm:pt-0">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 cursor-pointer">
                    <img src="{{ asset('icon.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-3xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>
                <p class="text-gray-500 dark:text-gray-400 mt-3 text-sm">Masuk ke akun Anda untuk mengakses produk.</p>
            </div>
            
            <?php if (session('status')): ?>
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 p-3 bg-green-50 dark:bg-green-500/10 rounded-lg border border-green-200 dark:border-green-500/20">
                    <?php echo session('status'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($errors->any()): ?>
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                        <?php foreach ($errors->all() as$error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="email@anda.com" class="w-full pl-10 pr-4 py-3 bg-white sm:bg-gray-50 dark:bg-slate-800 sm:dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-5">
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-brand-primary hover:text-brand-primaryHover transition-colors">Lupa sandi?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-white sm:bg-gray-50 dark:bg-slate-800 sm:dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="mb-6 flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary dark:bg-slate-800 dark:border-slate-700 cursor-pointer">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">Ingat Saya</label>
                </div>

                <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                    Masuk ke Sistem <i class="fa-solid fa-arrow-right text-sm"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400 sm:border-t sm:border-gray-100 sm:dark:border-slate-700/50 sm:pt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-brand-primary hover:underline transition-colors">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <script>
        const btn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');
        const html = document.documentElement;
        if (html.classList.contains('dark')) { icon.classList.replace('fa-moon', 'fa-sun'); }
        btn.addEventListener('click', () => {
            if (html.classList.contains('dark')) { 
                html.classList.remove('dark'); localStorage.theme = 'light'; icon.classList.replace('fa-sun', 'fa-moon'); 
            } else { 
                html.classList.add('dark'); localStorage.theme = 'dark'; icon.classList.replace('fa-moon', 'fa-sun'); 
            }
        });
    </script>
</body>
</html>