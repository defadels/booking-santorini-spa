<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.vouchers.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tracking Pemakaian Voucher
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Voucher Info Card --}}
            <div class="bg-gradient-to-r from-[#0D5C75] to-[#1A82A4] rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-[#0D5C75]/20">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sky-200 text-xs font-bold uppercase tracking-widest">Voucher Diskon</p>
                            <h3 class="font-mono font-extrabold text-2xl sm:text-3xl tracking-widest mt-0.5">{{ $voucher->code }}</h3>
                            <p class="text-sky-100 text-sm mt-1">{{ $voucher->name }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 sm:gap-6 text-center">
                        <div>
                            <p class="text-sky-200 text-[10px] uppercase tracking-wider font-bold">Diskon</p>
                            <p class="text-white font-extrabold text-2xl mt-1">{{ $voucher->discount_percent }}%</p>
                        </div>
                        <div>
                            <p class="text-sky-200 text-[10px] uppercase tracking-wider font-bold">Terpakai</p>
                            <p class="text-white font-extrabold text-2xl mt-1">{{ $voucher->used_count }}<span class="text-sky-200 font-normal text-sm">/{{ $voucher->quota }}</span></p>
                        </div>
                        <div>
                            <p class="text-sky-200 text-[10px] uppercase tracking-wider font-bold">Periode</p>
                            <p class="text-white font-bold text-xs mt-1">{{ $voucher->start_date->format('d M Y') }}</p>
                            <p class="text-sky-200 text-[10px]">s/d {{ $voucher->end_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Usages Table --}}
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-sky-50 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-slate-800">Riwayat Pemakaian</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Daftar customer yang menggunakan voucher ini.</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg">
                        {{ $usages->count() }} transaksi
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Customer</th>
                                <th class="p-4">Treatment</th>
                                <th class="p-4">Terapis</th>
                                <th class="p-4">Tanggal Booking</th>
                                <th class="p-4 text-right">Harga Normal</th>
                                <th class="p-4 text-right">Diskon</th>
                                <th class="p-4 text-right pr-6">Harga Final</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50/70">
                            @forelse($usages as $usage)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <div class="font-semibold text-slate-800">{{ $usage->customer_name }}</div>
                                        <div class="text-slate-400 text-[10px] mt-0.5">{{ $usage->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-semibold text-slate-700">{{ $usage->treatment->name }}</div>
                                        <div class="text-slate-400 text-[10px] mt-0.5">{{ $usage->treatment->category }}</div>
                                    </td>
                                    <td class="p-4 text-slate-600 font-semibold">{{ $usage->therapist->name }}</td>
                                    <td class="p-4 text-slate-600">
                                        <div class="font-semibold">{{ \Carbon\Carbon::parse($usage->booking_date)->translatedFormat('d F Y') }}</div>
                                        <div class="text-slate-400 text-[10px] mt-0.5">{{ substr($usage->booking_time, 0, 5) }} WIB</div>
                                    </td>
                                    <td class="p-4 text-right text-slate-500">
                                        <span class="line-through">Rp {{ number_format($usage->original_price ?? $usage->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <span class="text-rose-600 font-bold">
                                            - Rp {{ number_format($usage->discount_amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="p-4 pr-6 text-right">
                                        <span class="font-extrabold text-[#0D5C75]">Rp {{ number_format($usage->total_price, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="font-semibold text-sm">Belum ada pemakaian</p>
                                        <p class="text-xs mt-1">Voucher ini belum digunakan oleh customer manapun.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
