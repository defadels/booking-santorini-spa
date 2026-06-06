@extends('layouts.spa')

@section('title', 'Booking Sukses — Santorini Spa')

@section('styles')
<style>
    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        body {
            background: white !important;
            color: black !important;
        }
        .print-card {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 print-card" x-data="{ copied: false }">
    <!-- Success Tick Animation Area -->
    <div class="text-center mb-10 no-print">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-50 text-emerald-500 mb-6 border border-emerald-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-slate-800">Booking Anda Berhasil!</h1>
        <p class="text-slate-500 text-sm mt-2 max-w-md mx-auto leading-relaxed">
            Terima kasih telah mempercayakan waktu rileks Anda kepada Santorini Spa. Reservasi Anda telah masuk ke antrean kami.
        </p>
    </div>

    <!-- Booking Voucher / Receipt Card -->
    <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden p-6 sm:p-10 relative">
        <!-- Elegant Santorini Background Blue Watermark -->
        <div class="absolute right-0 bottom-0 opacity-[0.02] text-[#0D5C75] pointer-events-none translate-x-1/4 translate-y-1/4">
            <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 12l10 5 10-5M2 17l10 5 10-5"/>
            </svg>
        </div>

        <div class="relative space-y-8">
            <!-- Header Invoice -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-sky-50">
                <div>
                    <h2 class="font-serif text-2xl font-bold text-[#0D5C75]">Santorini Spa</h2>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-[#C5A880]">Wellness Receipt</span>
                </div>
                <div class="text-left sm:text-right text-xs text-slate-400">
                    <div>Tanggal Transaksi: <span class="font-bold text-slate-600">{{ $booking->created_at->isoFormat('D MMMM Y') }}</span></div>
                    <div class="mt-0.5">Waktu: <span class="font-bold text-slate-600">{{ $booking->created_at->format('H:i') }} WIB</span></div>
                </div>
            </div>

            <!-- Booking Code display -->
            <div class="bg-sky-50/50 p-6 rounded-2xl border border-sky-100 text-center space-y-2.5">
                <span class="text-[10px] text-[#0D5C75] uppercase tracking-widest font-bold">Kode Booking Unik</span>
                <div class="font-serif text-3xl sm:text-4xl font-extrabold text-[#0D5C75] tracking-widest">
                    {{ $booking->booking_code }}
                </div>
                <button 
                    @click="navigator.clipboard.writeText('{{ $booking->booking_code }}'); copied = true; setTimeout(() => copied = false, 2000)"
                    type="button"
                    class="no-print inline-flex items-center px-4 py-1.5 bg-white border border-sky-100 rounded-lg text-xs font-semibold text-[#0D5C75] hover:bg-sky-50 transition-colors shadow-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    <span x-text="copied ? 'Tersalin!' : 'Salin Kode'"></span>
                </button>
            </div>

            <!-- Client & Appointment Details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                <div>
                    <h4 class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-2">Informasi Tamu</h4>
                    <ul class="space-y-1.5">
                        <li><span class="text-slate-400 mr-1.5">Nama:</span> <span class="font-bold text-slate-700">{{ $booking->customer_name }}</span></li>
                        <li><span class="text-slate-400 mr-1.5">Status Booking:</span> 
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                Pending Konfirmasi
                            </span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-2">Jadwal Perawatan</h4>
                    <ul class="space-y-1.5">
                        <li><span class="text-slate-400 mr-1.5">Terapis:</span> <span class="font-bold text-slate-700">{{ $booking->therapist->name }}</span></li>
                        <li><span class="text-slate-400 mr-1.5">Jadwal:</span> <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM Y') }}</span></li>
                        <li><span class="text-slate-400 mr-1.5">Jam:</span> <span class="font-bold text-slate-700">{{ substr($booking->booking_time, 0, 5) }} WIB</span></li>
                    </ul>
                </div>
            </div>

            <!-- Items Table -->
            <div class="border-t border-sky-50 pt-6">
                <h4 class="text-xs uppercase tracking-widest font-bold text-slate-400 mb-3">Rincian Pembayaran</h4>
                <div class="bg-slate-50 rounded-2xl p-4 sm:p-6 space-y-4">
                    <div class="flex justify-between items-start text-xs">
                        <div>
                            <span class="font-bold text-slate-800 text-sm block">{{ $booking->treatment->name }}</span>
                            <span class="text-slate-400 block mt-0.5">{{ $booking->treatment->category }} &bull; {{ $booking->treatment->duration }} Menit</span>
                        </div>
                        <span class="font-bold text-slate-700 text-sm text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->notes)
                        <div class="border-t border-sky-100 pt-3 text-xs">
                            <span class="font-semibold text-slate-500 block">Catatan Tambahan:</span>
                            <p class="text-slate-500 italic mt-1 font-light bg-white p-2.5 rounded-lg border border-slate-100">
                                "{{ $booking->notes }}"
                            </p>
                        </div>
                    @endif

                    <div class="border-t border-dashed border-sky-200 pt-4 flex justify-between items-baseline">
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">Total Tagihan (Bayar di Tempat):</span>
                        <span class="text-lg font-extrabold text-[#0D5C75]">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Footer Message -->
            <div class="text-center text-[10px] text-slate-400 pt-4 border-t border-sky-50 leading-relaxed font-light">
                Mohon datang 15 menit sebelum jam perawatan Anda dimulai.<br>
                Jika Anda ingin mengubah jadwal atau membatalkan booking, silakan hubungi customer service kami di +62 (21) 500-SANTO.
            </div>
        </div>
    </div>

    <!-- Actions Buttons -->
    <div class="mt-8 flex flex-col sm:flex-row gap-3 no-print">
        <!-- Back Home -->
        <a 
            href="{{ route('home') }}" 
            class="flex-1 inline-flex items-center justify-center px-6 py-3.5 bg-white border border-[#0D5C75] text-[#0D5C75] font-semibold rounded-2xl hover:bg-sky-50 transition-colors shadow-sm text-sm"
        >
            Kembali ke Beranda
        </a>

        <!-- Print Receipt -->
        <button 
            @click="window.print()"
            type="button"
            class="flex-1 inline-flex items-center justify-center px-6 py-3.5 bg-[#0D5C75] text-white font-semibold rounded-2xl hover:bg-[#0A475B] transition-colors shadow-sm text-sm"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Bukti Reservasi
        </button>
    </div>
</div>
@endsection
