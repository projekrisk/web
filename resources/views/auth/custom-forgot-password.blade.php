<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Projekrisk</title>
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
            
            <button id="theme-toggle" class="absolute top-4 right-4 sm:top-6 sm:right-6 text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors flex items-center justify-center w-10 h-10 bg-gray-50 dark:bg-slate-900 rounded-full shadow-sm border border-gray-200 dark:border-slate-700">
                <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
            </button>

            <div class="text-center mb-8 pt-6 sm:pt-0">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 cursor-pointer">
                    <img src="{{ asset('icon.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-md">
                    <span class="font-bold text-3xl tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
                </a>
            </div>

            @if(session('verified_user_name'))
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm border border-green-200 dark:border-green-800/50">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2 class="font-normal text-2xl tracking-tight text-gray-900 dark:text-white mb-2">Akun Ditemukan!</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Verifikasi berhasil. Berikut adalah data Anda:</p>
                </div>

                <div class="bg-gray-50 dark:bg-slate-900 p-4 rounded-xl border border-gray-200 dark:border-slate-700 mb-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-primary text-white flex items-center justify-center text-xl font-bold shrink-0">
                        {{ substr(session('verified_user_name'), 0, 1) }}
                    </div>
                    <div class="text-left min-w-0">
                        <p class="font-bold text-gray-900 dark:text-white leading-tight truncate">{{ session('verified_user_name') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ session('verified_user_email') }}</p>
                    </div>
                </div>

                <p class="text-xs text-center text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">Untuk keamanan, proses reset kata sandi dilakukan secara manual. Silakan klik tombol di bawah untuk memohon reset kepada Admin kami melalui WhatsApp.</p>

                <a href="{{ session('wa_link') }}" target="_blank" class="w-full bg-[#25D366] hover:bg-[#1ebd5b] text-white font-bold py-2.5 rounded-xl transition-all shadow-lg shadow-green-500/30 flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Admin via WA
                </a>

            @else
                <div class="text-center mb-6">
                    <h2 class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">Lupa Kata Sandi?</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm leading-relaxed">Masukkan Email dan Nomor WhatsApp yang terdaftar untuk menemukan akun Anda.</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-sm font-medium flex gap-3 items-start">
                        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <?php if ($errors->any()): ?>
                    <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                            <?php foreach ($errors->all() as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="{{ route('password.verify_wa') }}">
                    @csrf
                    
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email Terdaftar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor WhatsApp Terdaftar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-brands fa-whatsapp text-gray-400"></i>
                            </div>
                            <input id="whatsapp_number" type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required placeholder="Contoh: 081234567890" class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-brand-primary focus:border-transparent outline-none transition-all">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                        Verifikasi Akun <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </form>
            @endif

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-slate-700/50 pt-6">
                Ingat kata sandi Anda? 
                <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:underline transition-colors">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script>
        const btn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');
        const html = document.documentElement;

        if (html.classList.contains('dark')) { setIcons('dark'); } else { setIcons('light'); }

        function setIcons(theme) {
            if(theme === 'dark') { icon.classList.replace('fa-moon', 'fa-sun'); } 
            else { icon.classList.replace('fa-sun', 'fa-moon'); }
        }

        btn.addEventListener('click', () => {
            if (html.classList.contains('dark')) { 
                html.classList.remove('dark'); localStorage.theme = 'light'; setIcons('light'); 
            } else { 
                html.classList.add('dark'); localStorage.theme = 'dark'; setIcons('dark'); 
            }
        });
    </script>
</body>
</html>