<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Santorini Spa — Relaksasi Mewah Bernuansa Yunani')</title>

    <!-- Google Fonts: Playfair Display for Serif headings, Plus Jakarta Sans for body text -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS and Alpine.js via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F4F9FB; /* Soft blue-gray background */
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        /* Glassmorphism utility */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(224, 242, 254, 0.7);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F4F9FB;
        }
        ::-webkit-scrollbar-thumb {
            background: #0D5C75;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0A475B;
        }
    </style>
    @yield('styles')
</head>
<body class="antialiased text-slate-800 min-h-screen flex flex-col">

    <!-- Header / Translucent Sticky Navbar -->
    <header class="sticky top-0 z-50 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <!-- Santorini Logo Image -->
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-md shadow-[#0D5C75]/20 group-hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('storage/image/logo.jpeg') }}" alt="Santorini Logo" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-wide text-[#0D5C75]">Santorini</span>
                        <span class="text-xs uppercase tracking-widest block font-semibold text-[#C5A880]">Spa & Wellness</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold hover:text-[#0D5C75] transition-colors {{ request()->routeIs('home') ? 'text-[#0D5C75]' : 'text-slate-600' }}">Beranda</a>
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-200"></span>
                    <span class="text-sm text-slate-500 font-medium">Layanan Premium</span>
                </nav>

                <!-- Navigation Access Points -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full border border-[#0D5C75]/20 text-[#0D5C75] bg-white hover:bg-sky-50 transition-all duration-300 shadow-sm shadow-[#0D5C75]/5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Admin Panel
                            </a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full border border-[#0D5C75]/20 text-[#0D5C75] bg-white hover:bg-sky-50 transition-all duration-300 shadow-sm shadow-[#0D5C75]/5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#C5A880]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Area Pelanggan
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full text-white bg-rose-500 hover:bg-rose-600 transition-all duration-300 shadow-sm">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-[#0D5C75] transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full bg-[#0D5C75] text-white hover:bg-[#0A475B] transition-all duration-300 shadow-sm shadow-[#0D5C75]/10">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Santorini Custom Footer -->
    <footer class="bg-white border-t border-sky-100 text-slate-600 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Branding column -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-serif text-2xl font-bold tracking-wide text-[#0D5C75]">Santorini Spa</span>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Menghadirkan kesegaran laut Aegean dan keindahan putih Santorini langsung ke tubuh Anda melalui terapi penyembuhan holistik terbaik.
                    </p>
                </div>

                <!-- Hours & Location -->
                <div class="space-y-4">
                    <h3 class="text-sm uppercase tracking-widest font-bold text-[#C5A880]">Jam Operasional & Kontak</h3>
                    <ul class="text-sm space-y-2 text-slate-500">
                        <li class="flex items-center">
                            <span class="font-semibold text-slate-600 mr-2">Setiap Hari:</span> 09:00 – 21:00 WIB
                        </li>
                        <li class="flex items-center">
                            <span class="font-semibold text-slate-600 mr-2">Telepon:</span> +62 (21) 500-SANTO
                        </li>
                        <li class="flex items-center">
                            <span class="font-semibold text-slate-600 mr-2">Email:</span> hello@santorinispa.com
                        </li>
                    </ul>
                </div>

                <!-- Address -->
                <div class="space-y-4">
                    <h3 class="text-sm uppercase tracking-widest font-bold text-[#C5A880]">Alamat Oasis Kami</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Kawasan Resort Dago Pakar Hills Blok C-12,<br>
                        Bandung, Jawa Barat, 40198
                    </p>
                </div>
            </div>

            <!-- Copyright footer bar -->
            <div class="border-t border-sky-50 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} Santorini Spa. Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <span class="hover:text-[#0D5C75] cursor-pointer">Kebijakan Privasi</span>
                    <span>&bull;</span>
                    <span class="hover:text-[#0D5C75] cursor-pointer">Syarat & Ketentuan</span>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
