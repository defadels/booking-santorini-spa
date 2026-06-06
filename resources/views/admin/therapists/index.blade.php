<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Terapis Santorini Spa') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ activeTherapist: null }">
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

            <!-- Therapist Table and Overview Card -->
            <div class="bg-white rounded-3xl border border-sky-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-sky-50">
                    <h3 class="font-bold text-slate-800 text-base leading-snug">Daftar Terapis Santorini Spa</h3>
                    <p class="text-xs text-slate-400 mt-1">Kelola data terapis profesional, spesialisasi, rating kepuasan, dan status operasional hari ini</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 uppercase tracking-wider font-semibold border-b border-sky-50 text-[10px]">
                                <th class="p-4 pl-6">Foto</th>
                                <th class="p-4">Nama Terapis</th>
                                <th class="p-4">Spesialisasi</th>
                                <th class="p-4 text-center">Rating</th>
                                <th class="p-4 text-center">Sesi Hari Ini</th>
                                <th class="p-4 text-center">Status Operasional</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-50">
                            @forelse($therapists as $therapist)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 pl-6">
                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100">
                                            <img src="{{ $therapist->image }}" alt="{{ $therapist->name }}" class="w-full h-full object-cover">
                                        </div>
                                    </td>
                                    <td class="p-4 font-bold text-slate-800 text-sm">{{ $therapist->name }}</td>
                                    <td class="p-4 text-slate-600 font-medium">{{ $therapist->specialization }}</td>
                                    <td class="p-4 text-center">
                                        <div class="inline-flex items-center text-amber-500 font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-slate-700 ml-1">{{ number_format($therapist->rating, 1) }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center font-semibold text-slate-700">
                                        <span class="px-2 py-1 bg-sky-50 text-[#0D5C75] rounded-md border border-sky-100">
                                            {{ $therapist->sessions_today }} Sesi
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($therapist->status === 'active')
                                            <span class="px-3 py-1 text-[9px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200">Aktif</span>
                                        @elseif($therapist->status === 'holiday')
                                            <span class="px-3 py-1 text-[9px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 rounded-full border border-amber-200">Libur</span>
                                        @else
                                            <span class="px-3 py-1 text-[9px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 rounded-full border border-slate-200">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="p-4 pr-6 text-center">
                                        <button 
                                            @click="activeTherapist = {
                                                id: {{ $therapist->id }},
                                                name: '{{ $therapist->name }}',
                                                specialization: '{{ $therapist->specialization }}',
                                                rating: '{{ $therapist->rating }}',
                                                status: '{{ $therapist->status }}',
                                                update_url: '{{ route('admin.therapists.update', $therapist->id) }}'
                                            }"
                                            type="button" 
                                            class="px-3.5 py-1.5 bg-slate-50 text-slate-600 border border-slate-200 font-bold rounded-lg hover:bg-slate-100 transition-colors"
                                        >
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400 font-medium">Data terapis belum ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit Therapist Modal overlay -->
        <div 
            x-show="activeTherapist !== null" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="activeTherapist = null"
        >
            <div class="bg-white rounded-3xl max-w-md w-full border border-sky-100 shadow-xl overflow-hidden" @click.away="activeTherapist = null">
                <!-- Modal Header -->
                <div class="bg-[#0D5C75] p-6 text-white flex items-center justify-between">
                    <div>
                        <span class="text-[9px] uppercase font-bold tracking-widest text-sky-200">Therapist management</span>
                        <h3 class="font-serif text-lg font-bold mt-0.5" x-text="'Edit Terapis: ' + (activeTherapist ? activeTherapist.name : '')"></h3>
                    </div>
                    <button @click="activeTherapist = null" class="text-sky-200 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body Form -->
                <form :action="activeTherapist ? activeTherapist.update_url : ''" method="POST" class="p-6 space-y-4 text-xs">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Terapis</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            required
                            :value="activeTherapist ? activeTherapist.name : ''"
                            class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs text-slate-700 bg-white"
                        >
                    </div>

                    <!-- Specialization -->
                    <div>
                        <label for="specialization" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Spesialisasi</label>
                        <input 
                            type="text" 
                            name="specialization" 
                            id="specialization" 
                            required
                            :value="activeTherapist ? activeTherapist.specialization : ''"
                            class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs text-slate-700 bg-white"
                        >
                    </div>

                    <!-- Rating -->
                    <div>
                        <label for="rating" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Rating (1.0 - 5.0)</label>
                        <input 
                            type="number" 
                            name="rating" 
                            id="rating" 
                            step="0.1" 
                            min="1" 
                            max="5"
                            required
                            :value="activeTherapist ? activeTherapist.rating : ''"
                            class="w-full px-3 py-2 border border-slate-200 focus:border-[#0D5C75] focus:ring-1 focus:ring-[#0D5C75] rounded-xl text-xs text-slate-700 bg-white"
                        >
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Operasional</label>
                        <select 
                            name="status" 
                            id="status" 
                            :value="activeTherapist ? activeTherapist.status : ''"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#0D5C75] text-xs text-slate-700 bg-white"
                        >
                            <option value="active">Aktif (Bekerja)</option>
                            <option value="holiday">Libur (Holiday)</option>
                            <option value="inactive">Tidak Aktif (Inactive)</option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full py-3 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold rounded-xl transition-all duration-200 shadow-sm text-center">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
