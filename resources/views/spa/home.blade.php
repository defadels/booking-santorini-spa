@extends('layouts.spa')

@section('title', 'Beranda — Santorini Spa')

@section('content')
<!-- Hero Section -->
<div class="relative bg-[#0D5C75] overflow-hidden">
    <!-- Background overlay gradients -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#0D5C75] via-[#116A86] to-[#1A82A4]"></div>
    <!-- Subtle geometric background wave -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,160L48,176C96,192,192,224,288,208C384,192,480,128,576,128C672,128,768,192,864,224C960,256,1056,256,1152,224C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="currentColor"></path>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-24 text-center">
        <span class="text-xs font-bold uppercase tracking-widest text-[#E6C89C] mb-3 block">Selamat Datang di Santorini Spa</span>
        <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-wide max-w-3xl mx-auto leading-tight">
            Kembalikan Keseimbangan & Keindahan Jiwa Anda
        </h1>
        <p class="mt-6 text-base sm:text-lg text-sky-100 max-w-xl mx-auto font-light leading-relaxed">
            Rasakan kombinasi perawatan mewah terinspirasi iklim laut Mediterania dan tradisi penyembuhan holistik terbaik dunia.
        </p>

        <!-- Search Bar Container -->
        <div class="mt-10 max-w-xl mx-auto">
            <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row items-stretch gap-2 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20 shadow-lg">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative flex-grow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-200 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari perawatan spa..." 
                        class="w-full pl-12 pr-4 py-3 bg-white/95 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0D5C75] border-0 text-sm"
                    >
                </div>
                <button type="submit" class="px-6 py-3 bg-[#C5A880] text-[#0D5C75] font-semibold rounded-xl hover:bg-[#D4AF37] hover:text-white transition-all duration-300 text-sm shadow-md shadow-black/10">
                    Cari Layanan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Category Filter Chips -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-sky-100 pb-8">
        <div>
            <h2 class="font-serif text-2xl font-bold text-slate-800">Kategori Perawatan</h2>
            <p class="text-xs text-slate-500 mt-1">Temukan berbagai menu terapi untuk kesegaran raga Anda</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <!-- All Chip -->
            <a 
                href="{{ route('home', ['category' => 'All', 'search' => $search]) }}" 
                class="px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider transition-all duration-300 shadow-sm {{ $selectedCategory === 'All' ? 'bg-[#0D5C75] text-white' : 'bg-white text-slate-600 border border-sky-100 hover:bg-sky-50' }}"
            >
                Semua
            </a>

            @foreach($categories as $category)
                <a 
                    href="{{ route('home', ['category' => $category, 'search' => $search]) }}" 
                    class="px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider transition-all duration-300 shadow-sm {{ $selectedCategory === $category ? 'bg-[#0D5C75] text-white' : 'bg-white text-slate-600 border border-sky-100 hover:bg-sky-50' }}"
                >
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Active Filter/Search Alerts -->
    @if($search || $selectedCategory !== 'All')
        <div class="mt-6 flex items-center justify-between p-3 bg-sky-50 rounded-xl text-sky-800 text-xs border border-sky-100">
            <div>
                Menampilkan hasil untuk: 
                @if($selectedCategory !== 'All')
                    kategori <span class="font-bold">"{{ $selectedCategory }}"</span>
                @endif
                @if($search)
                    @if($selectedCategory !== 'All') dan @endif
                    pencarian <span class="font-bold">"{{ $search }}"</span>
                @endif
            </div>
            <a href="{{ route('home') }}" class="font-semibold text-[#0D5C75] hover:underline">Hapus Filter</a>
        </div>
    @endif

    <!-- Treatment Cards Grid -->
    <div class="mt-8">
        @if($treatments->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-sky-100 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="font-serif text-lg font-bold text-slate-600 mt-4">Treatment Tidak Ditemukan</h3>
                <p class="text-xs text-slate-400 mt-2">Coba ganti kata kunci pencarian Anda atau bersihkan filter.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex items-center px-4 py-2 bg-[#0D5C75] text-white text-xs font-semibold rounded-xl hover:bg-[#0A475B] transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($treatments as $treatment)
                    <!-- Single Treatment Card -->
                    <div class="bg-white rounded-3xl overflow-hidden border border-sky-100 shadow-sm hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 flex flex-col h-full group">
                        <!-- Image section -->
                        <div class="relative h-60 overflow-hidden bg-slate-100 flex-shrink-0">
                            <img 
                                src="{{ $treatment->image }}" 
                                alt="{{ $treatment->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                            >
                            <!-- Category Badge -->
                            <span class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-[#0D5C75] text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                                {{ $treatment->category }}
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-grow">
                            <!-- Duration & Availability -->
                            <div class="flex items-center justify-between text-[11px] text-slate-400 font-semibold mb-3">
                                <span class="flex items-center bg-sky-50 text-[#0D5C75] px-2.5 py-1 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $treatment->duration }} Menit
                                </span>
                                @if($treatment->is_available)
                                    <span class="flex items-center text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="flex items-center text-rose-500 bg-rose-50 px-2.5 py-1 rounded-md">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="font-serif text-xl font-bold text-slate-800 group-hover:text-[#0D5C75] transition-colors duration-300 leading-snug">
                                <a href="{{ route('treatments.show', $treatment->slug) }}">
                                    {{ $treatment->name }}
                                </a>
                            </h3>

                            <!-- Description snippet -->
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                {{ $treatment->description }}
                            </p>

                            <!-- Spacer -->
                            <div class="flex-grow"></div>

                            <!-- Footer Section -->
                            <div class="border-t border-sky-50 mt-6 pt-4 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-400 block font-medium uppercase tracking-wider">Harga Layanan</span>
                                    <span class="text-lg font-bold text-[#0D5C75]">
                                        Rp {{ number_format($treatment->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a 
                                    href="{{ route('treatments.show', $treatment->slug) }}" 
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-sky-50 text-[#0D5C75] group-hover:bg-[#0D5C75] group-hover:text-white transition-all duration-300 shadow-sm"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
