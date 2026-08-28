@extends('layouts.spa')

@section('title', 'Pesan Layanan — Santorini Spa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" 
     x-data="{ 
         selectedTherapist: '{{ $therapists->first()->id ?? '' }}',
         selectedTherapistName: '{{ $therapists->first()->name ?? '' }}',
         selectedDate: '{{ $dates[0]['value'] }}',
         selectedDateFormatted: '{{ $dates[0]['day_name'] }}, {{ $dates[0]['day'] }} {{ $dates[0]['month'] }}',
         selectedTime: '',
         bookings: {{ json_encode($existingBookings) }},
         selectedVoucherCode: '',
         selectedVoucherName: '',
         selectedVoucherPercent: 0,
         basePrice: {{ $treatment->price }},
         get discountAmount() { return Math.round(this.basePrice * this.selectedVoucherPercent / 100); },
         get finalPrice() { return this.basePrice - this.discountAmount; },
         selectVoucher(code, name, percent) {
             if (this.selectedVoucherCode === code) {
                 this.selectedVoucherCode = '';
                 this.selectedVoucherName = '';
                 this.selectedVoucherPercent = 0;
             } else {
                 this.selectedVoucherCode = code;
                 this.selectedVoucherName = name;
                 this.selectedVoucherPercent = percent;
             }
         },
         updateTherapist(id, name) {
             this.selectedTherapist = id;
             this.selectedTherapistName = name;
             if (this.isSlotBooked(this.selectedTime)) {
                 this.selectedTime = '';
             }
         },
         updateDate(value, formatted) {
             this.selectedDate = value;
             this.selectedDateFormatted = formatted;
             if (this.isSlotBooked(this.selectedTime)) {
                 this.selectedTime = '';
             }
         },
         isSlotBooked(time) {
             if (!time) return false;
             return this.bookings.some(b => b.date === this.selectedDate && b.therapist_id == this.selectedTherapist && b.time === time);
         },
         formatRupiah(number) {
             return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
         }
     }">

    <!-- Top Info -->
    <div class="mb-8">
        <a href="{{ route('treatments.show', $treatment->slug) }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-[#0D5C75] transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Detail Perawatan
        </a>
        <h1 class="font-serif text-3xl font-bold text-slate-800 mt-4">Pesan Jadwal Perawatan</h1>
        <p class="text-xs text-slate-400 mt-1">Lengkapi detail pemesanan di bawah ini untuk membuat reservasi Anda.</p>
    </div>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl">
            <h4 class="font-semibold text-sm mb-2">Terjadi kesalahan input:</h4>
            <ul class="list-disc pl-5 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store', $treatment->slug) }}" method="POST">
        @csrf
        <!-- Hidden Inputs for Alpine values -->
        <input type="hidden" name="therapist_id" :value="selectedTherapist">
        <input type="hidden" name="booking_date" :value="selectedDate">
        <input type="hidden" name="booking_time" :value="selectedTime">
        <input type="hidden" name="voucher_code" :value="selectedVoucherCode">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Input Side (L: 8 Columns) -->
            <div class="lg:col-span-8 space-y-8">
                <!-- 1. Customer Name -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm">1</span>
                        <h2 class="text-lg font-bold text-slate-800">Nama Lengkap Anda</h2>
                    </div>
                    <div>
                        <label for="customer_name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="customer_name" 
                            name="customer_name" 
                            value="{{ old('customer_name', auth()->user()->name) }}" 
                            placeholder="Masukkan nama lengkap sesuai identitas..." 
                            required
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300"
                        >
                    </div>
                </div>

                <!-- 2. Choose Therapist -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm">2</span>
                        <h2 class="text-lg font-bold text-slate-800">Pilih Terapis Santorini</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($therapists as $therapist)
                            <div 
                                @click="updateTherapist('{{ $therapist->id }}', '{{ $therapist->name }}')"
                                :class="selectedTherapist == '{{ $therapist->id }}' ? 'border-2 border-[#0D5C75] bg-sky-50/30' : 'border border-slate-100 hover:border-sky-200 bg-white'"
                                class="flex items-center p-4 rounded-2xl cursor-pointer transition-all duration-300 shadow-sm select-none"
                            >
                                <!-- Therapist Photo -->
                                <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-100 flex-shrink-0">
                                    <img src="{{ $therapist->image }}" alt="{{ $therapist->name }}" class="w-full h-full object-cover">
                                </div>
                                <!-- Details -->
                                <div class="ml-4 flex-grow">
                                    <h4 class="font-bold text-sm text-slate-800 leading-tight">{{ $therapist->name }}</h4>
                                    <p class="text-[10px] text-slate-400 mt-1 leading-snug">{{ $therapist->specialization }}</p>

                                </div>
                                <!-- Radio indicator -->
                                <div class="ml-2">
                                    <div :class="selectedTherapist == '{{ $therapist->id }}' ? 'bg-[#0D5C75] border-transparent' : 'border-slate-300'" class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors">
                                        <div class="w-2 h-2 rounded-full bg-white" x-show="selectedTherapist == '{{ $therapist->id }}'"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 3. Choose Date (Calendar Strip) -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm">3</span>
                        <h2 class="text-lg font-bold text-slate-800">Pilih Tanggal Booking</h2>
                    </div>

                    <!-- Horizontal Weekly Strip -->
                    <div class="grid grid-cols-4 sm:grid-cols-7 gap-3">
                        @foreach($dates as $date)
                            <div 
                                @click="updateDate('{{ $date['value'] }}', '{{ $date['day_name'] }}, {{ $date['day'] }} {{ $date['month'] }}')"
                                :class="selectedDate == '{{ $date['value'] }}' ? 'bg-[#0D5C75] border-transparent text-white shadow-md shadow-[#0D5C75]/10' : 'bg-white border-slate-100 hover:border-sky-200 text-slate-600 border'"
                                class="flex flex-col items-center justify-center p-3 rounded-2xl cursor-pointer transition-all duration-300 select-none text-center h-20"
                            >
                                <span class="text-[10px] uppercase font-bold tracking-wider" :class="selectedDate == '{{ $date['value'] }}' ? 'text-sky-200' : 'text-slate-400'">
                                    {{ $date['day_name'] }}
                                </span>
                                <span class="text-lg font-extrabold mt-1 block">
                                    {{ $date['day'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 4. Choose Time Slots -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm">4</span>
                        <h2 class="text-lg font-bold text-slate-800">Pilih Jam Reservasi</h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($slots as $slot)
                            <button 
                                type="button"
                                @click="if(!isSlotBooked('{{ $slot }}')) selectedTime = '{{ $slot }}'"
                                :disabled="isSlotBooked('{{ $slot }}')"
                                :class="isSlotBooked('{{ $slot }}') 
                                    ? 'bg-slate-50 border border-slate-100 text-slate-300 cursor-not-allowed opacity-60' 
                                    : (selectedTime == '{{ $slot }}' 
                                        ? 'bg-[#0D5C75] text-white border-transparent shadow-md shadow-[#0D5C75]/10' 
                                        : 'bg-white border-slate-200 text-slate-700 hover:border-[#0D5C75]') "
                                class="py-3 px-4 rounded-xl font-bold text-xs border text-center transition-all duration-300 focus:outline-none"
                            >
                                <div class="text-sm">{{ $slot }}</div>
                                <div class="text-[9px] mt-0.5 font-semibold" 
                                     :class="isSlotBooked('{{ $slot }}') ? 'text-slate-400' : (selectedTime == '{{ $slot }}' ? 'text-sky-200' : 'text-emerald-500')">
                                    <span x-text="isSlotBooked('{{ $slot }}') ? 'Penuh' : 'Tersedia'"></span>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- 5. Optional Notes -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm">5</span>
                        <h2 class="text-lg font-bold text-slate-800">Catatan Khusus (Opsional)</h2>
                    </div>
                    <div>
                        <label for="notes" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Catatan</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3" 
                            placeholder="Tulis instruksi khusus terapis, keluhan medis, atau preferensi pijatan Anda..." 
                            class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-slate-800 text-sm focus:outline-none transition-all duration-300 resize-none"
                        >{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- 6. Voucher Diskon --}}
                @if($vouchers->isNotEmpty())
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-sky-100 shadow-sm">
                    <div class="flex items-center space-x-3 mb-5">
                        <span class="w-8 h-8 rounded-full bg-sky-50 text-[#0D5C75] flex items-center justify-center font-bold text-sm flex-shrink-0">6</span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Voucher Diskon</h2>
                            <p class="text-xs text-slate-400">Pilih 1 voucher untuk mendapatkan potongan harga.</p>
                        </div>
                    </div>

                    @error('voucher_code')
                        <div class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700">{{ $message }}</div>
                    @enderror

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($vouchers as $v)
                        <div
                            @click="selectVoucher('{{ $v->code }}', '{{ $v->name }}', {{ $v->discount_percent }})"
                            :class="selectedVoucherCode === '{{ $v->code }}'
                                ? 'border-[#0D5C75] bg-sky-50 ring-2 ring-[#0D5C75]/20'
                                : 'border-slate-200 hover:border-sky-300 bg-white'"
                            class="cursor-pointer rounded-2xl border-2 p-4 transition-all duration-200 flex items-center gap-3">

                            {{-- Checkmark --}}
                            <div :class="selectedVoucherCode === '{{ $v->code }}' ? 'bg-[#0D5C75] border-[#0D5C75]' : 'border-slate-300 bg-white'"
                                class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all">
                                <svg x-show="selectedVoucherCode === '{{ $v->code }}'" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-mono font-extrabold text-[#0D5C75] text-sm tracking-wider">{{ $v->code }}</span>
                                    <span class="bg-rose-100 text-rose-600 font-bold text-[10px] px-2 py-0.5 rounded-full flex-shrink-0">-{{ $v->discount_percent }}%</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5 leading-snug">{{ $v->name }}</p>
                                <p class="text-[10px] text-emerald-600 font-semibold mt-1">Hemat Rp {{ number_format(round($treatment->price * $v->discount_percent / 100), 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <p x-show="selectedVoucherCode" x-transition class="text-xs text-slate-400 mt-4 text-center">
                        Klik voucher yang sama lagi untuk membatalkan pilihan.
                    </p>
                </div>
                @endif
            </div>

            <!-- Booking Summary Side (R: 4 Columns) -->
            <div class="lg:col-span-4 sticky top-24">
                <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                    <div class="bg-[#0D5C75] p-6 text-white text-center">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-sky-200">Order Summary</span>
                        <h3 class="font-serif text-lg font-bold mt-1">Ringkasan Reservasi</h3>
                    </div>

                    <div class="p-6 space-y-6 text-xs text-slate-600">
                        <!-- Treatment details -->
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-bold text-slate-800 text-sm block">{{ $treatment->name }}</span>
                                <span class="text-slate-400 mt-0.5 block">{{ $treatment->category }} &bull; {{ $treatment->duration }} Menit</span>
                            </div>
                            <span class="font-bold text-slate-800 text-right">Rp {{ number_format($treatment->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-t border-sky-50 pt-4 space-y-3">
                            <!-- Therapist -->
                            <div class="flex justify-between">
                                <span class="text-slate-400">Terapis:</span>
                                <span class="font-bold text-slate-800" x-text="selectedTherapistName || '-'"></span>
                            </div>

                            <!-- Date -->
                            <div class="flex justify-between">
                                <span class="text-slate-400">Tanggal:</span>
                                <span class="font-bold text-slate-800" x-text="selectedDateFormatted"></span>
                            </div>

                            <!-- Time -->
                            <div class="flex justify-between">
                                <span class="text-slate-400">Waktu / Jam:</span>
                                <span class="font-bold text-slate-800" x-text="selectedTime ? selectedTime + ' WIB' : 'Pilih Jam...'"></span>
                            </div>
                        </div>

                        <!-- Price summary -->
                        <div class="border-t-2 border-dashed border-sky-100 pt-4 space-y-2">
                            <!-- Harga asli -->
                            <div class="flex justify-between items-baseline">
                                <span class="text-xs text-slate-400">Harga Treatment:</span>
                                <span class="text-xs font-semibold"
                                    :class="selectedVoucherPercent > 0 ? 'line-through text-slate-400' : 'text-slate-800'">
                                    Rp {{ number_format($treatment->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <!-- Potongan diskon -->
                            <div x-show="selectedVoucherPercent > 0" class="flex justify-between items-baseline">
                                <span class="text-xs text-emerald-600 font-semibold" x-text="'Diskon ' + selectedVoucherPercent + '%:'"></span>
                                <span class="text-xs text-emerald-600 font-bold" x-text="'- ' + formatRupiah(discountAmount)"></span>
                            </div>
                            <!-- Total -->
                            <div class="flex justify-between items-baseline pt-2 border-t border-sky-100">
                                <span class="text-sm font-bold text-slate-800">Total Biaya:</span>
                                <span class="text-xl font-extrabold text-[#0D5C75]" x-text="formatRupiah(finalPrice)"></span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button 
                                type="submit" 
                                :disabled="!selectedTime || !selectedTherapist"
                                :class="selectedTime && selectedTherapist 
                                    ? 'bg-[#0D5C75] hover:bg-[#0A475B] text-white cursor-pointer shadow-md shadow-[#0D5C75]/10' 
                                    : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                                class="w-full py-4 rounded-2xl font-bold text-sm text-center transition-all duration-300 focus:outline-none flex items-center justify-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z" />
                                </svg>
                                Konfirmasi Booking
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-3 leading-relaxed">
                                Pembayaran dilakukan secara langsung di outlet Santorini Spa setelah treatment selesai.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
