@extends('layouts.spa')

@section('title', 'Dasbor Pelanggan — Santorini Spa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ tab: '{{ request('tab', 'bookings') }}' }">
    
    <!-- Dashboard Header Banner -->
    <div class="relative bg-gradient-to-r from-[#0D5C75] to-[#1A82A4] rounded-3xl p-8 sm:p-12 text-white overflow-hidden shadow-lg shadow-[#0D5C75]/10 mb-8">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 1440 320" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,160L48,176C96,192,192,224,288,208C384,192,480,128,576,128C672,128,768,192,864,224C960,256,1056,256,1152,224C1248,192,1344,128,1392,96L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="currentColor"></path>
            </svg>
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-sky-200">Oasis Pelanggan</span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold mt-2">Selamat Datang, {{ $user->name }}!</h1>
                <p class="text-sky-100 text-xs sm:text-sm mt-1.5 font-light">Kelola reservasi Anda dan sesuaikan data profil Anda dengan mudah.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#C5A880] text-[#0D5C75] font-bold text-xs uppercase tracking-widest rounded-xl hover:bg-[#D4AF37] hover:text-white transition-all duration-300 shadow-md shadow-black/10 self-start sm:self-auto">
                Pesan Treatment Baru
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tab navigation -->
    <div class="flex border-b border-sky-100 mb-8">
        <button 
            @click="tab = 'bookings'"
            :class="tab === 'bookings' ? 'border-[#0D5C75] text-[#0D5C75] font-bold' : 'border-transparent text-slate-500 hover:text-slate-800'"
            class="pb-4 px-6 border-b-2 text-sm font-semibold transition-all duration-300 flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Riwayat Booking
        </button>
        <button 
            @click="tab = 'profile'"
            :class="tab === 'profile' ? 'border-[#0D5C75] text-[#0D5C75] font-bold' : 'border-transparent text-slate-500 hover:text-slate-800'"
            class="pb-4 px-6 border-b-2 text-sm font-semibold transition-all duration-300 flex items-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Pengaturan Profil
        </button>
    </div>

    <!-- Tab contents -->
    <div>
        <!-- TAB 1: BOOKING HISTORY -->
        <div x-show="tab === 'bookings'" class="space-y-6">
            @if($bookings->isEmpty())
                <div class="text-center py-16 bg-white rounded-3xl border border-sky-100 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="font-serif text-lg font-bold text-slate-600 mt-4">Belum Ada Reservasi</h3>
                    <p class="text-xs text-slate-400 mt-2">Anda belum melakukan pemesanan perawatan spa.</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-[#0D5C75] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-[#0A475B] transition-colors">
                        Mulai Booking Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-3xl border border-sky-100 p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <!-- Header: Code & Status -->
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-xs font-extrabold text-[#0D5C75] tracking-wider uppercase bg-sky-50 px-3 py-1.5 rounded-lg border border-sky-100/50">
                                        {{ $booking->booking_code }}
                                    </span>
                                    
                                    @if($booking->status === 'pending')
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-100 flex items-center">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                            Menunggu Konfirmasi
                                        </span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Terkonfirmasi
                                        </span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-sky-50 text-sky-600 border border-sky-100 flex items-center">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-slate-50 text-slate-400 border border-slate-100 flex items-center">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </div>

                                <!-- Treatment details -->
                                <div class="space-y-3 pt-1 border-t border-sky-50/50 mt-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-slate-400">Treatment:</span>
                                        <span class="text-xs font-bold text-slate-800 text-right">{{ $booking->treatment->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-slate-400">Kategori & Durasi:</span>
                                        <span class="text-xs text-slate-600 text-right">{{ $booking->treatment->category }} &bull; {{ $booking->treatment->duration }} Menit</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-slate-400">Terapis:</span>
                                        <span class="text-xs font-bold text-slate-800 text-right">{{ $booking->therapist->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-slate-400">Jadwal:</span>
                                        <span class="text-xs font-bold text-slate-800 text-right">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }} pukul {{ substr($booking->booking_time, 0, 5) }} WIB</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-slate-400">Total Biaya:</span>
                                        <span class="text-xs font-extrabold text-[#0D5C75]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    @if($booking->notes)
                                        <div class="mt-2.5 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                            <span class="text-[10px] text-slate-400 block font-semibold uppercase tracking-wider mb-1">Catatan Khusus:</span>
                                            <p class="text-xs text-slate-600 italic font-light">"{{ $booking->notes }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-6 pt-4 border-t border-sky-50 flex items-center justify-between gap-3">
                                <a href="{{ route('booking.confirmation', $booking->booking_code) }}" class="text-xs font-semibold text-[#0D5C75] hover:underline flex items-center">
                                    Lihat Struk Reservasi
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>

                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                    <form action="{{ route('customer.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-[10px] font-bold text-rose-500 hover:text-white bg-rose-50 hover:bg-rose-500 rounded-xl transition-all duration-300 border border-rose-100 hover:border-transparent">
                                            Batalkan Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB 2: PROFILE SETTINGS -->
        <div x-show="tab === 'profile'" class="grid grid-cols-1 lg:grid-cols-2 gap-8" style="display: none;">
            <!-- Profile Info Form -->
            <div class="bg-white rounded-3xl border border-sky-100 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="font-serif text-lg font-bold text-slate-800">Detail Profil</h3>
                    <p class="text-xs text-slate-400 mt-1">Ubah nama lengkap dan alamat email yang Anda gunakan di sistem.</p>
                </div>

                <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}" 
                            required
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            required
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-6 py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md shadow-[#0D5C75]/15 flex items-center justify-center">
                        Simpan Profil
                    </button>
                </form>
            </div>

            <!-- Password Form -->
            <div class="bg-white rounded-3xl border border-sky-100 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="font-serif text-lg font-bold text-slate-800">Perbarui Password</h3>
                    <p class="text-xs text-slate-400 mt-1">Pastikan akun Anda menggunakan password yang aman dan unik.</p>
                </div>

                <form action="{{ route('customer.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Current Password -->
                    <div class="space-y-1.5">
                        <label for="current_password" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Password Saat Ini</label>
                        <input 
                            id="current_password" 
                            type="password" 
                            name="current_password" 
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                        @error('current_password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Password Baru</label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Konfirmasi Password Baru</label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                        @error('password_confirmation')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-6 py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md shadow-[#0D5C75]/15 flex items-center justify-center">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
