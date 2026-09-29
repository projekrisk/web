<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $product->name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Roboto"', 'sans-serif'] }, colors: { brand: { dark: '#151A22', primary: '#3B82F6', primaryHover: '#2563EB' } } } } }
    </script>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 flex flex-col min-h-screen">

    <header class="w-full bg-white dark:bg-brand-dark border-b border-gray-200 dark:border-gray-800 z-50">
        <div class="max-w-[1100px] mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('icon.png') }}" alt="Projekrisk" class="w-8 h-8 object-contain drop-shadow-sm">
                <span class="font-bold text-lg tracking-tight text-gray-900 dark:text-white">Projekrisk<span class="text-brand-primary">.</span></span>
            </a>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400"><i class="fa-solid fa-lock text-brand-primary mr-1"></i> Checkout Aman</span>
        </div>
    </header>

    <main class="flex-1 py-12 flex items-center justify-center px-4">
        <div class="w-full max-w-[800px]">
            
            <a href="{{ route('front.product', $product->slug) }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-primary transition-colors mb-6">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke detail produk
            </a>

            <div class="bg-white dark:bg-brand-dark rounded-2xl shadow-xl shadow-blue-900/5 border border-gray-200 dark:border-gray-800 overflow-hidden flex flex-col md:flex-row">
                
                <div class="p-8 md:w-3/5">
                    <h2 class="text-xl font-normal text-gray-900 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-800 pb-4">Ringkasan Pesanan</h2>
                    
                    <div class="flex items-start gap-4 mb-8">
                        @if($product->featured_image)
                            <img src="{{ asset('uploads/' . $product->featured_image) }}" alt="Produk" class="w-20 h-20 rounded-xl object-cover border border-gray-200 dark:border-gray-700">
                        @else
                            <div class="w-20 h-20 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-box text-2xl"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <span class="text-[10px] uppercase font-bold text-brand-primary tracking-wider">{{ $product->category }}</span>
                            <h3 class="font-bold text-normal text-gray-900 dark:text-white leading-tight mt-1">{{ $product->name }}</h3>
                        </div>
                    </div>

                    <h2 class="text-lg font-normal text-gray-900 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-800 pb-4">Detail Akun Penerima</h2>
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-brand-primary mt-3"><i class="fa-solid fa-circle-info mr-1"></i>Akses produk akan dikirimkan ke akun ini.</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/80 p-8 md:w-2/5 flex flex-col justify-between border-l border-gray-200 dark:border-gray-800">
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Total Pembayaran</h3>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Harga Produk</span>
                            <span class="text-gray-900 dark:text-white font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">Biaya Admin</span>
                            <span class="text-gray-900 dark:text-white font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <span class="font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-2xl font-normal text-brand-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <form action="{{ route('front.checkout.process', $product->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-brand-primary hover:bg-brand-primaryHover text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-shield-check"></i> Proses Pembayaran
                            </button>
                        </form>
                        <p class="text-[11px] text-center text-gray-500 dark:text-gray-400 mt-4 leading-relaxed">
                            Dengan memproses pembayaran, Anda menyetujui Syarat dan Ketentuan layanan Projekrisk.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>