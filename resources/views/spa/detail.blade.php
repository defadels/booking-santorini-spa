@extends('layouts.spa')

@section('title', $treatment->name . ' — Santorini Spa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Back Navigation Link -->
    <div class="mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#0D5C75] transition-colors duration-200 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Semua Layanan
        </a>
    </div>

    <!-- Main Detail Grid -->
    <div class="bg-white rounded-3xl overflow-hidden border border-sky-100 shadow-sm grid grid-cols-1 lg:grid-cols-12 gap-0">
        <!-- Image Gallery Side (L: 5 Columns) -->
        <div class="lg:col-span-5 relative h-[350px] sm:h-[450px] lg:h-full bg-slate-100">
            <img 
                src="{{ $treatment->image }}" 
                alt="{{ $treatment->name }}" 
                class="w-full h-full object-cover"
            >
            <!-- Float Category Badge -->
            <span class="absolute top-6 left-6 px-4 py-1.5 bg-white/95 backdrop-blur-sm text-[#0D5C75] text-[10px] font-bold uppercase tracking-wider rounded-full shadow-sm">
                {{ $treatment->category }}
            </span>
        </div>

        <!-- Info Content Side (R: 7 Columns) -->
        <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
            <div class="space-y-6">
                <!-- Category Name -->
                <span class="text-xs uppercase tracking-widest font-bold text-[#C5A880]">{{ $treatment->category }}</span>
                
                <!-- Treatment Title -->
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-800 leading-tight">
                    {{ $treatment->name }}
                </h1>

                <!-- Durasi & Availability badges -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center bg-sky-50 text-[#0D5C75] px-3.5 py-1.5 rounded-lg text-xs font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Durasi: {{ $treatment->duration }} Menit
                    </span>

                    @if($treatment->is_available)
                        <span class="inline-flex items-center text-emerald-600 bg-emerald-50 px-3.5 py-1.5 rounded-lg text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                            Layanan Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 bg-rose-50 px-3.5 py-1.5 rounded-lg text-xs font-semibold">
                            Tidak Tersedia Sementara
                        </span>
                    @endif
                </div>

                <!-- Horizontal Divider -->
                <div class="border-t border-sky-50 my-6"></div>

                <!-- Description -->
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-2.5">Deskripsi Perawatan</h3>
                    <p class="text-slate-600 text-sm leading-relaxed font-light">
                        {{ $treatment->description }}
                    </p>
                </div>
            </div>

            <!-- Booking Section -->
            <div class="border-t border-sky-50 mt-10 pt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <!-- Price info -->
                <div>
                    <span class="text-xs text-slate-400 block uppercase tracking-wider font-semibold">Investasi Kesehatan</span>
                    <span class="text-2xl sm:text-3xl font-extrabold text-[#0D5C75]">
                        Rp {{ number_format($treatment->price, 0, ',', '.') }}
                    </span>
                </div>

                <!-- CTA Booking Button -->
                @if($treatment->is_available)
                    <a 
                        href="{{ route('booking.form', $treatment->slug) }}" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-[#0D5C75] text-white font-semibold rounded-2xl hover:bg-[#0A475B] transition-colors duration-300 shadow-md shadow-[#0D5C75]/10 text-center text-sm"
                    >
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @else
                    <button 
                        disabled 
                        class="px-8 py-4 bg-slate-200 text-slate-400 font-semibold rounded-2xl cursor-not-allowed text-center text-sm"
                    >
                        Tutup Sementara
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
