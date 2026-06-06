<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Treatment Santorini Spa') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ activeTreatment: null, addModalActive: false }">
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

            <!-- Overviews and Action Header -->
            <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base leading-snug">Kelola Menu Treatment</h3>
                    <p class="text-xs text-slate-400 mt-1">Tambah, perbarui durasi, harga, kategori, dan ketersediaan menu Santorini Spa</p>
                </div>
                <button 
                    @click="addModalActive = true"
                    type="button" 
                    class="inline-flex items-center px-4 py-2.5 bg-[#0D5C75] hover:bg-[#0A475B] text-white text-xs font-semibold rounded-xl transition-all duration-200 shadow-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Treatment Baru
                </button>
            </div>

            <!-- Treatments Table Card -->
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Foto</th>
                                <th class="p-4">Nama Treatment</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4 text-center">Durasi</th>
                                <th class="p-4 text-right">Harga</th>
                                <th class="p-4 text-center">Total Reservasi</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50">
                            @forelse($treatments as $treatment)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <div class="w-12 h-8 rounded-lg overflow-hidden bg-slate-100">
                                            <img src="{{ $treatment->image }}" alt="{{ $treatment->name }}" class="w-full h-full object-cover">
                                        </div>
                                    </td>
                                    <td class="p-4 font-bold text-slate-800 text-sm">{{ $treatment->name }}</td>
                                    <td class="p-4 font-semibold text-[#0D5C75]">{{ $treatment->category }}</td>
                                    <td class="p-4 text-center font-medium text-slate-600">{{ $treatment->duration }} Menit</td>
                                    <td class="p-4 text-right font-bold text-slate-800">
                                        Rp {{ number_format($treatment->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center font-semibold text-slate-700">{{ $treatment->total_bookings }} kali</td>
                                    <td class="p-4 text-center">
                                        @if($treatment->is_available)
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">Tersedia</span>
                                        @else
                                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-rose-50 text-rose-500 rounded-full border border-rose-200">Tutup</span>
                                        @endif
                                    </td>
                                    <td class="p-4 pr-6 text-center">
                                        <button 
                                            @click="activeTreatment = {
                                                id: {{ $treatment->id }},
                                                name: '{{ $treatment->name }}',
                                                category: '{{ $treatment->category }}',
                                                duration: '{{ $treatment->duration }}',
                                                price: '{{ intval($treatment->price) }}',
                                                image: '{{ $treatment->image }}',
                                                description: '{{ addslashes($treatment->description) }}',
                                                is_available: '{{ $treatment->is_available }}',
                                                update_url: '{{ route('admin.treatments.update', $treatment->id) }}'
                                            }"
                                            type="button" 
                                            class="px-3 py-1.5 bg-slate-50 text-slate-600 border border-slate-200 font-bold rounded-lg hover:bg-slate-100 transition-colors"
                                        >
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400 font-medium">Data treatment masih kosong. Silakan tambah menu baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Add Treatment Modal (Overlay) -->
        <div 
            x-show="addModalActive" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="addModalActive = false"
        >
            <div class="bg-white rounded-3xl max-w-md w-full border border-sky-100 shadow-xl overflow-hidden" @click.away="addModalActive = false">
                <!-- Header -->
                <div class="bg-[#0D5C75] p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-sky-200">New Treatment</span>
                        <h3 class="font-serif text-lg font-bold mt-0.5">Tambah Menu Baru</h3>
                    </div>
                    <button @click="addModalActive = false" class="text-sky-200 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.treatments.store') }}" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="new_name" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Treatment</label>
                        <input type="text" name="name" id="new_name" required placeholder="Contoh: Volcanic Massage" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="new_category" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</label>
                        <select name="category" id="new_category" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-white text-slate-800">
                            <option value="">Pilih Kategori...</option>
                            <option value="Massage">Massage (Pijat)</option>
                            <option value="Body Scrub">Body Scrub (Lulur)</option>
                            <option value="Facial">Facial (Perawatan Wajah)</option>
                            <option value="Spa Package">Spa Package (Paket Lengkap)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Duration -->
                        <div>
                            <label for="new_duration" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Durasi (Menit)</label>
                            <input type="number" name="duration" id="new_duration" min="15" required placeholder="90" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="new_price" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga (Rupiah)</label>
                            <input type="number" name="price" id="new_price" min="0" required placeholder="350000" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label for="new_image" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">URL Foto Treatment (Unsplash/Link Gambar)</label>
                        <input type="url" name="image" id="new_image" placeholder="https://images.unsplash.com/..." class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="new_description" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Deskripsi Layanan</label>
                        <textarea name="description" id="new_description" rows="3" required placeholder="Jelaskan teknik pijatan, manfaat kebugaran, dan detail terapi..." class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold rounded-xl transition-all duration-200 shadow-sm text-center">
                        Tambah Treatment
                    </button>
                </form>
            </div>
        </div>

        <!-- Edit Treatment Modal (Overlay) -->
        <div 
            x-show="activeTreatment !== null" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="activeTreatment = null"
        >
            <div class="bg-white rounded-3xl max-w-md w-full border border-sky-100 shadow-xl overflow-hidden" @click.away="activeTreatment = null">
                <!-- Header -->
                <div class="bg-[#0D5C75] p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-sky-200">Edit Treatment</span>
                        <h3 class="font-serif text-lg font-bold mt-0.5" x-text="activeTreatment ? activeTreatment.name : ''"></h3>
                    </div>
                    <button @click="activeTreatment = null" class="text-sky-200 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form :action="activeTreatment ? activeTreatment.update_url : ''" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="edit_name" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Treatment</label>
                        <input type="text" name="name" id="edit_name" required :value="activeTreatment ? activeTreatment.name : ''" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="edit_category" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori</label>
                        <select name="category" id="edit_category" required :value="activeTreatment ? activeTreatment.category : ''" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs bg-white text-slate-800">
                            <option value="Massage">Massage (Pijat)</option>
                            <option value="Body Scrub">Body Scrub (Lulur)</option>
                            <option value="Facial">Facial (Perawatan Wajah)</option>
                            <option value="Spa Package">Spa Package (Paket Lengkap)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Duration -->
                        <div>
                            <label for="edit_duration" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Durasi (Menit)</label>
                            <input type="number" name="duration" id="edit_duration" min="15" required :value="activeTreatment ? activeTreatment.duration : ''" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="edit_price" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga (Rupiah)</label>
                            <input type="number" name="price" id="edit_price" min="0" required :value="activeTreatment ? activeTreatment.price : ''" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label for="edit_image" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">URL Foto Treatment</label>
                        <input type="url" name="image" id="edit_image" :value="activeTreatment ? activeTreatment.image : ''" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800">
                    </div>

                    <!-- Status Available -->
                    <div>
                        <label for="edit_is_available" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Ketersediaan</label>
                        <select 
                            name="is_available" 
                            id="edit_is_available" 
                            :value="activeTreatment ? activeTreatment.is_available : '1'"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D5C75] text-xs bg-white text-slate-800"
                        >
                            <option value="1">Tersedia (Available)</option>
                            <option value="0">Tutup Sementara (Unavailable)</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="edit_description" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Deskripsi Layanan</label>
                        <textarea name="description" id="edit_description" rows="3" required x-text="activeTreatment ? activeTreatment.description : ''" class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs bg-white text-slate-800 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold rounded-xl transition-all duration-200 shadow-sm text-center">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
