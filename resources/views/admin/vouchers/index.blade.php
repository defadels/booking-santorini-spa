<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Voucher Diskon') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        showAdd: false,
        showEdit: false,
        showDelete: false,
        editVoucher: {},
        deleteVoucherId: null,
        deleteVoucherCode: '',
        openEdit(v) {
            this.editVoucher = { ...v };
            this.showEdit = true;
        },
        openDelete(id, code) {
            this.deleteVoucherId = id;
            this.deleteVoucherCode = code;
            this.showDelete = true;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Header + Add Button --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Daftar Voucher</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Kelola voucher diskon untuk customer Santorini Spa.</p>
                </div>
                <button @click="showAdd = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0D5C75] hover:bg-[#0A475B] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Voucher
                </button>
            </div>

            {{-- Stats Row --}}
            @php
                $today = \Carbon\Carbon::today();
                $totalVouchers  = $vouchers->count();
                $activeVouchers = $vouchers->filter(fn($v) => $v->is_active && $v->start_date <= $today && $v->end_date >= $today && $v->used_count < $v->quota)->count();
                $totalUsed      = $vouchers->sum('used_count');
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-sky-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-[#0D5C75] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Voucher</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $totalVouchers }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Voucher Aktif</p>
                        <p class="text-2xl font-extrabold text-emerald-600">{{ $activeVouchers }}</p>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Pemakaian</p>
                        <p class="text-2xl font-extrabold text-amber-600">{{ $totalUsed }}x</p>
                    </div>
                </div>
            </div>

            {{-- Voucher Table --}}
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Kode Voucher</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4 text-center">Diskon</th>
                                <th class="p-4 text-center">Kuota / Terpakai</th>
                                <th class="p-4">Periode Berlaku</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50/70">
                            @forelse($vouchers as $voucher)
                                @php
                                    $today       = \Carbon\Carbon::today();
                                    $isExpired   = $voucher->end_date < $today;
                                    $isExhausted = $voucher->used_count >= $voucher->quota;
                                    $isNotStarted= $voucher->start_date > $today;
                                    $isAvailable = $voucher->is_active && !$isExpired && !$isExhausted && !$isNotStarted;
                                    $pct         = $voucher->quota > 0 ? min(100, ($voucher->used_count / $voucher->quota) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <span class="font-extrabold text-[#0D5C75] tracking-widest bg-sky-50 px-2.5 py-1 rounded-lg border border-sky-100 text-[11px] font-mono">
                                            {{ $voucher->code }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-semibold text-slate-700 max-w-[160px] truncate">{{ $voucher->name }}</td>
                                    <td class="p-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 font-extrabold text-sm border border-rose-100">
                                            {{ $voucher->discount_percent }}%
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="font-bold text-slate-700">{{ $voucher->used_count }}</span>
                                            <span class="text-slate-300">/</span>
                                            <span class="text-slate-500">{{ $voucher->quota }}</span>
                                        </div>
                                        <div class="w-24 mx-auto mt-1.5 bg-slate-100 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full {{ $isExhausted ? 'bg-rose-500' : 'bg-emerald-500' }}" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-slate-600">
                                        <div class="font-semibold">{{ $voucher->start_date->format('d M Y') }}</div>
                                        <div class="text-slate-400">s/d {{ $voucher->end_date->format('d M Y') }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($isAvailable)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                                        @elseif(!$voucher->is_active)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">Nonaktif</span>
                                        @elseif($isExhausted)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">Habis</span>
                                        @elseif($isExpired)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">Kadaluarsa</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-600 border border-sky-200">Belum Mulai</span>
                                        @endif
                                    </td>
                                    <td class="p-4 pr-6">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <a href="{{ route('admin.vouchers.usages', $voucher->id) }}"
                                                title="Lihat Pemakaian"
                                                class="p-2 rounded-lg text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <button
                                                @click="openEdit({{ json_encode(['id' => $voucher->id, 'code' => $voucher->code, 'name' => $voucher->name, 'discount_percent' => $voucher->discount_percent, 'quota' => $voucher->quota, 'start_date' => $voucher->start_date->format('Y-m-d'), 'end_date' => $voucher->end_date->format('Y-m-d'), 'is_active' => $voucher->is_active]) }})"
                                                title="Edit Voucher"
                                                class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button
                                                @click="openDelete({{ $voucher->id }}, '{{ $voucher->code }}')"
                                                title="Hapus Voucher"
                                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <p class="font-semibold text-sm">Belum ada voucher</p>
                                        <p class="text-xs mt-1">Klik "Tambah Voucher" untuk membuat voucher pertama.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL: TAMBAH --}}
        <div x-show="showAdd" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showAdd = false"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 z-10" @click.stop>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-serif text-lg font-bold text-slate-800">Tambah Voucher Baru</h3>
                    <button @click="showAdd = false" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kode Voucher *</label>
                            <input type="text" name="code" required placeholder="contoh: SANTO20" value="{{ old('code') }}"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 uppercase font-mono font-bold placeholder-slate-400 focus:outline-none transition-all">
                        </div>
                        <div class="col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Voucher *</label>
                            <input type="text" name="name" required placeholder="contoh: Diskon Spesial Akhir Tahun" value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Diskon (%) *</label>
                            <div class="relative">
                                <input type="number" name="discount_percent" required min="1" max="100" value="{{ old('discount_percent') }}" placeholder="20"
                                    class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all pr-10">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">%</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kuota *</label>
                            <input type="number" name="quota" required min="1" value="{{ old('quota') }}" placeholder="100"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Mulai *</label>
                            <input type="date" name="start_date" required value="{{ old('start_date') }}"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Akhir *</label>
                            <input type="date" name="end_date" required value="{{ old('end_date') }}"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="col-span-2 flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="add_is_active" value="1" checked
                                class="w-4 h-4 rounded border-slate-300 text-[#0D5C75] focus:ring-[#0D5C75]">
                            <label for="add_is_active" class="text-sm font-semibold text-slate-700">Aktifkan voucher setelah disimpan</label>
                        </div>
                    </div>
                    @if($errors->any())
                        <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-700 space-y-1">
                            @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                        </div>
                    @endif
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="showAdd = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Simpan Voucher</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: EDIT --}}
        <div x-show="showEdit" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showEdit = false"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg p-8 z-10" @click.stop>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-serif text-lg font-bold text-slate-800">Edit Voucher</h3>
                    <button @click="showEdit = false" class="p-1.5 rounded-lg text-slate-400 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form :action="'/admin/vouchers/' + editVoucher.id + '/update'" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kode Voucher *</label>
                            <input type="text" name="code" required x-model="editVoucher.code"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 uppercase font-mono font-bold focus:outline-none transition-all">
                        </div>
                        <div class="col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Voucher *</label>
                            <input type="text" name="name" required x-model="editVoucher.name"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Diskon (%) *</label>
                            <div class="relative">
                                <input type="number" name="discount_percent" required min="1" max="100" x-model="editVoucher.discount_percent"
                                    class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all pr-10">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">%</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kuota *</label>
                            <input type="number" name="quota" required min="1" x-model="editVoucher.quota"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Mulai *</label>
                            <input type="date" name="start_date" required x-model="editVoucher.start_date"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tanggal Akhir *</label>
                            <input type="date" name="end_date" required x-model="editVoucher.end_date"
                                class="w-full px-4 py-3 border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/20 rounded-xl text-sm text-slate-800 focus:outline-none transition-all">
                        </div>
                        <div class="col-span-2 flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                :checked="editVoucher.is_active"
                                @change="editVoucher.is_active = $event.target.checked"
                                class="w-4 h-4 rounded border-slate-300 text-[#0D5C75] focus:ring-[#0D5C75]">
                            <label for="edit_is_active" class="text-sm font-semibold text-slate-700">Voucher aktif</label>
                        </div>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="showEdit = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: DELETE --}}
        <div x-show="showDelete" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showDelete = false"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 z-10 text-center" @click.stop>
                <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-lg">Hapus Voucher?</h3>
                <p class="text-sm text-slate-500 mt-1 mb-6">Voucher <span class="font-extrabold text-[#0D5C75] font-mono" x-text="deleteVoucherCode"></span> akan dihapus secara permanen.</p>
                <form :action="'/admin/vouchers/' + deleteVoucherId" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" @click="showDelete = false" class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-colors">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
