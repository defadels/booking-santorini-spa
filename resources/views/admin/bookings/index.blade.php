<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Booking Santorini Spa') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeBooking: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success notification -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filters & Search Bar Card -->
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <!-- Tabs Status -->
                    <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-2xl text-[11px] font-semibold text-slate-500 max-w-max">
                        <a href="{{ route('admin.bookings.index', ['status' => 'all', 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'all' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">
                            Semua
                        </a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'pending', 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'pending' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed', 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'confirmed' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">
                            Dikonfirmasi
                        </a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'completed', 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'completed' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">
                            Selesai
                        </a>
                        <a href="{{ route('admin.bookings.index', ['status' => 'cancelled', 'search' => $search]) }}" 
                           class="px-4 py-2 rounded-xl transition-all duration-200 {{ $status === 'cancelled' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">
                            Dibatalkan
                        </a>
                    </div>

                    <!-- Search Input -->
                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}" 
                            placeholder="Cari nama atau kode booking..." 
                            class="w-full px-4 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none transition-all duration-200"
                        >
                        <button type="submit" class="px-4 py-2 bg-[#0D5C75] hover:bg-[#0A475B] text-white text-xs font-semibold rounded-xl transition-colors">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bookings List Table -->
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Kode Booking</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Treatment</th>
                                <th class="p-4">Terapis</th>
                                <th class="p-4">Jadwal Booking</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-right">Biaya</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6 font-bold text-[#0D5C75]">{{ $booking->booking_code }}</td>
                                    <td class="p-4 font-semibold text-slate-800">{{ $booking->customer_name }}</td>
                                    <td class="p-4 text-slate-600 font-medium">{{ $booking->treatment->name }}</td>
                                    <td class="p-4 text-slate-600">{{ $booking->therapist->name }}</td>
                                    <td class="p-4 font-medium text-slate-600">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                        <span class="text-slate-400 text-[10px] ml-1">{{ substr($booking->booking_time, 0, 5) }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($booking->status === 'pending')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 rounded-full border border-amber-200">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-sky-50 text-[#0D5C75] rounded-full border border-sky-200">Konfirmasi</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">Selesai</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-rose-50 text-rose-500 rounded-full border border-rose-200">Batal</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-bold text-slate-800">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 pr-6 text-center space-x-2 whitespace-nowrap">
                                        <!-- Confirm Button for Pending -->
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-sky-50 text-[#0D5C75] border border-sky-200 font-bold rounded-lg hover:bg-[#0D5C75] hover:text-white transition-colors duration-200">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Detail Button -->
                                        <button 
                                            @click="activeBooking = {
                                                id: {{ $booking->id }},
                                                code: '{{ $booking->booking_code }}',
                                                name: '{{ $booking->customer_name }}',
                                                treatment: '{{ $booking->treatment->name }}',
                                                category: '{{ $booking->treatment->category }}',
                                                duration: '{{ $booking->treatment->duration }}',
                                                therapist: '{{ $booking->therapist->name }}',
                                                date: '{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}',
                                                time: '{{ substr($booking->booking_time, 0, 5) }}',
                                                status: '{{ $booking->status }}',
                                                price: '{{ number_format($booking->total_price, 0, ',', '.') }}',
                                                notes: '{{ $booking->notes ? addslashes($booking->notes) : '' }}',
                                                update_url: '{{ route('admin.bookings.status', $booking->id) }}'
                                            }"
                                            type="button" 
                                            class="px-3 py-1.5 bg-slate-50 text-slate-600 border border-slate-200 font-bold rounded-lg hover:bg-slate-100 transition-colors"
                                        >
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400 font-medium">Data transaksi booking kosong.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination links -->
                @if($bookings->hasPages())
                    <div class="p-4 border-t border-sky-50 bg-slate-50">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>

        </div>

        <!-- 4. Interactive Detail Modal (Overlay) -->
        <div 
            x-show="activeBooking !== null" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="activeBooking = null"
        >
            <div class="bg-white rounded-3xl max-w-lg w-full border border-sky-100 shadow-xl overflow-hidden" @click.away="activeBooking = null">
                <!-- Modal Header -->
                <div class="bg-[#0D5C75] p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-sky-200">Transaction details</span>
                        <h3 class="font-serif text-lg font-bold mt-0.5" x-text="'Booking #' + (activeBooking ? activeBooking.code : '')"></h3>
                    </div>
                    <button @click="activeBooking = null" class="text-sky-200 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6 text-xs text-slate-600 max-h-[75vh] overflow-y-auto">
                    <!-- Client Details -->
                    <div class="grid grid-cols-2 gap-4 border-b border-sky-50 pb-4">
                        <div>
                            <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-1">Nama Customer</span>
                            <span class="font-bold text-slate-800 text-sm" x-text="activeBooking ? activeBooking.name : ''"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-1">Status Saat Ini</span>
                            <div>
                                <template x-if="activeBooking && activeBooking.status === 'pending'">
                                    <span class="px-2.5 py-0.5 font-bold uppercase tracking-wider text-[9px] bg-amber-50 text-amber-700 rounded-full border border-amber-200">Pending</span>
                                </template>
                                <template x-if="activeBooking && activeBooking.status === 'confirmed'">
                                    <span class="px-2.5 py-0.5 font-bold uppercase tracking-wider text-[9px] bg-sky-50 text-[#0D5C75] rounded-full border border-sky-200">Konfirmasi</span>
                                </template>
                                <template x-if="activeBooking && activeBooking.status === 'completed'">
                                    <span class="px-2.5 py-0.5 font-bold uppercase tracking-wider text-[9px] bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">Selesai</span>
                                </template>
                                <template x-if="activeBooking && activeBooking.status === 'cancelled'">
                                    <span class="px-2.5 py-0.5 font-bold uppercase tracking-wider text-[9px] bg-rose-50 text-rose-500 rounded-full border border-rose-200">Batal</span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment specs -->
                    <div class="grid grid-cols-2 gap-4 border-b border-sky-50 pb-4">
                        <div>
                            <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-1">Jadwal Perawatan</span>
                            <span class="font-bold text-slate-700" x-text="activeBooking ? activeBooking.date + ' pukul ' + activeBooking.time + ' WIB' : ''"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-1">Terapis Pilihan</span>
                            <span class="font-bold text-slate-700" x-text="activeBooking ? activeBooking.therapist : ''"></span>
                        </div>
                    </div>

                    <!-- Selected Treatment details -->
                    <div>
                        <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-2">Layanan yang Dipesan</span>
                        <div class="bg-slate-50 p-4 rounded-xl space-y-2">
                            <div class="flex justify-between items-baseline">
                                <span class="font-bold text-slate-800" x-text="activeBooking ? activeBooking.treatment : ''"></span>
                                <span class="font-bold text-slate-700" x-text="activeBooking ? 'Rp ' + activeBooking.price : ''"></span>
                            </div>
                            <span class="text-[10px] text-slate-400 block" x-text="activeBooking ? activeBooking.category + ' &bull; ' + activeBooking.duration + ' Menit' : ''"></span>
                        </div>
                    </div>

                    <!-- Notes field -->
                    <div>
                        <span class="text-slate-400 block font-medium uppercase tracking-wider text-[10px] mb-1.5">Catatan Customer</span>
                        <p class="text-slate-500 italic p-3 bg-slate-50 rounded-xl border border-slate-100 min-h-[50px]" 
                           x-text="activeBooking && activeBooking.notes ? activeBooking.notes : 'Tidak ada catatan khusus dari customer.'"></p>
                    </div>

                    <!-- Update Status Action Form -->
                    <form :action="activeBooking ? activeBooking.update_url : ''" method="POST" class="border-t border-sky-50 pt-5 space-y-4">
                        @csrf
                        <div>
                            <label for="status" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Ubah Status Transaksi</label>
                            <select 
                                name="status" 
                                id="status" 
                                :value="activeBooking ? activeBooking.status : ''"
                                class="w-full px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D5C75] text-xs text-slate-700 bg-white"
                            >
                                <option value="pending">Pending</option>
                                <option value="confirmed">Konfirmasi (Confirmed)</option>
                                <option value="completed">Selesai (Completed)</option>
                                <option value="cancelled">Batalkan (Cancelled)</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold rounded-xl transition-all duration-200 shadow-sm text-center">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
