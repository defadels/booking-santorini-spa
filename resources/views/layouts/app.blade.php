<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Santorini Spa — Admin Portal</title>

        <!-- Google Fonts: Playfair Display for Serif headings, Plus Jakarta Sans for body text -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F8FAFC;
            }
            .font-serif {
                font-family: 'Playfair Display', serif;
            }
        </style>
    </head>
    <body class="antialiased text-slate-800 min-h-screen">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Left Sidebar (Desktop only) -->
            <aside class="w-72 bg-[#0D5C75] text-white flex flex-col justify-between flex-shrink-0 border-r border-[#0A475B] hidden md:flex">
                <div>
                    <!-- Logo / Brand Header -->
                    <div class="p-6 border-b border-[#0A475B] flex items-center space-x-3.5">
                        <div class="w-10 h-10 rounded-full bg-white text-[#0D5C75] flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div>
                            <span class="font-serif text-xl font-bold tracking-wide block">Santorini</span>
                            <span class="text-[9px] uppercase tracking-widest block font-semibold text-[#E6C89C]">Admin Control</span>
                        </div>
                    </div>

                    <!-- Navigation Sidebar Links -->
                    <nav class="p-4 space-y-1.5">
                        <!-- Dashboard -->
                        <a 
                            href="{{ route('admin.dashboard') }}" 
                            class="flex items-center px-4 py-3.5 text-xs font-semibold rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white border-l-4 border-[#C5A880] pl-3' : 'text-sky-100 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Kelola Booking -->
                        <a 
                            href="{{ route('admin.bookings.index') }}" 
                            class="flex items-center px-4 py-3.5 text-xs font-semibold rounded-2xl transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-white/10 text-white border-l-4 border-[#C5A880] pl-3' : 'text-sky-100 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Kelola Booking
                        </a>

                        <!-- Manajemen Terapis -->
                        <a 
                            href="{{ route('admin.therapists.index') }}" 
                            class="flex items-center px-4 py-3.5 text-xs font-semibold rounded-2xl transition-all {{ request()->routeIs('admin.therapists.*') ? 'bg-white/10 text-white border-l-4 border-[#C5A880] pl-3' : 'text-sky-100 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Manajemen Terapis
                        </a>

                        <!-- Manajemen Treatment -->
                        <a 
                            href="{{ route('admin.treatments.index') }}" 
                            class="flex items-center px-4 py-3.5 text-xs font-semibold rounded-2xl transition-all {{ request()->routeIs('admin.treatments.*') ? 'bg-white/10 text-white border-l-4 border-[#C5A880] pl-3' : 'text-sky-100 hover:bg-white/5 hover:text-white' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Manajemen Treatment
                        </a>
                    </nav>
                </div>

                <!-- Footer User Profile and Actions -->
                <div class="p-4 border-t border-[#0A475B] bg-[#0A475B]/25">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs uppercase text-sky-100 border border-white/10">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <div>
                                <span class="font-bold text-xs block truncate max-w-[140px] text-white">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] text-sky-300 block truncate max-w-[140px]">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('home') }}" target="_blank" class="flex-grow inline-flex items-center justify-center px-3 py-2 text-[10px] font-semibold bg-white/5 hover:bg-white/10 rounded-lg text-sky-100 transition-colors border border-white/5">
                            Lihat Web ↗
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-[10px] font-semibold bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white rounded-lg transition-colors duration-200">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Mobile Navbar Header (Visible only on screens < md) -->
            <header class="bg-white border-b border-sky-100 h-16 flex items-center justify-between px-6 md:hidden">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-[#0D5C75] text-white flex items-center justify-center font-serif font-bold text-sm">S</div>
                    <span class="font-serif text-lg font-bold text-[#0D5C75]">Santorini</span>
                </a>
                
                <!-- Toggle menu via Alpine -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Dropdown responsive menu -->
                    <div 
                        x-show="open" 
                        @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-52 bg-white border border-sky-100 rounded-2xl shadow-lg py-2.5 z-50 text-xs text-slate-700"
                        style="display: none;"
                    >
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 font-semibold">Dashboard</a>
                        <a href="{{ route('admin.bookings.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-semibold">Kelola Booking</a>
                        <a href="{{ route('admin.therapists.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-semibold">Manajemen Terapis</a>
                        <a href="{{ route('admin.treatments.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-semibold">Manajemen Treatment</a>
                        <div class="border-t border-sky-50 my-1.5"></div>
                        <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 hover:bg-slate-50 font-semibold text-sky-600">Lihat Website Utama ↗</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-rose-50 font-semibold text-rose-500">Keluar</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Right Side main screen content -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Page Breadcrumbs/Header (Desktop only) -->
                @isset($header)
                    <header class="bg-white border-b border-sky-100/30 hidden md:block">
                        <div class="max-w-7xl mx-auto py-5 px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Main Content Body -->
                <main class="flex-grow p-6 md:p-8">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>
