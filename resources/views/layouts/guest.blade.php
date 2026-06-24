<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login — Santorini Spa Admin Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Side: Cover Image (7 Columns) -->
            <div class="lg:col-span-7 relative hidden lg:flex flex-col justify-between p-12 bg-slate-900 text-white overflow-hidden">
                <!-- Cover Image Background -->
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=80');"></div>
                <!-- Aegean Blue overlay with gradient -->
                <div class="absolute inset-0 bg-gradient-to-tr from-[#0D5C75]/95 via-[#0D5C75]/60 to-transparent"></div>

                <!-- Watermark Wave -->
                <div class="absolute right-0 bottom-0 opacity-10 text-white pointer-events-none translate-x-1/4 translate-y-1/4">
                    <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 12l10 5 10-5M2 17l10 5 10-5"/>
                    </svg>
                </div>

                <!-- Top Logo -->
                <a href="/" class="relative flex items-center space-x-3 group z-10">
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-md bg-white">
                        <img src="{{ asset('storage/image/logo.jpeg') }}" alt="Santorini Logo" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-wide">Santorini</span>
                        <span class="text-xs uppercase tracking-widest block font-semibold text-[#E6C89C]">Spa & Wellness</span>
                    </div>
                </a>

                <!-- Hero Text -->
                <div class="relative z-10 max-w-lg mt-auto">
                    <h2 class="font-serif text-4xl font-bold tracking-wide leading-tight text-white">
                        Kelola Kemewahan & Kenyamanan Layanan
                    </h2>
                    <p class="mt-4 text-sm text-sky-100 font-light leading-relaxed">
                        Selamat datang kembali di Portal Santorini Spa. Kelola antrean booking, ketersediaan terapis, dan menu perawatan Anda dalam satu dashboard modern berkelas dunia.
                    </p>
                </div>

                <!-- Footer info -->
                <div class="relative z-10 text-xs text-sky-200 mt-12">
                    &copy; {{ date('Y') }} Santorini Spa. All rights reserved.
                </div>
            </div>

            <!-- Right Side: Login Form (5 Columns) -->
            <div class="lg:col-span-5 flex flex-col justify-center px-6 sm:px-12 lg:px-20 py-12 bg-white relative">
                <!-- Mobile header logo (shown only on mobile) -->
                <div class="lg:hidden text-center mb-8 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full overflow-hidden shadow-md mb-2">
                        <img src="{{ asset('storage/image/logo.jpeg') }}" alt="Santorini Logo" class="w-full h-full object-cover">
                    </div>
                    <span class="font-serif text-xl font-bold tracking-wide text-[#0D5C75]">Santorini Spa</span>
                    <span class="text-[9px] uppercase tracking-widest block font-semibold text-slate-400">Admin Portal</span>
                </div>

                <!-- Form container wrapper -->
                <div class="max-w-md w-full mx-auto space-y-6">
                    <!-- Main Auth Slots -->
                    <div class="mt-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
