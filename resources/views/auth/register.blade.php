<x-guest-layout>
    <div class="space-y-6" x-data="{ 
        password: '', 
        password_confirmation: '', 
        showPassword: false, 
        showConfirmPassword: false,
        get isMatch() {
            return this.password.length > 0 && this.password_confirmation.length > 0 && this.password === this.password_confirmation;
        },
        get isMismatch() {
            return this.password_confirmation.length > 0 && this.password !== this.password_confirmation;
        }
    }">
        <!-- Header -->
        <div>
            <h3 class="font-serif text-2xl font-bold text-slate-800">Daftar Akun Pelanggan</h3>
            <p class="text-xs text-slate-400 mt-1">Buat akun baru untuk menikmati kemudahan booking spa premium</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="Nama lengkap Anda..."
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</label>
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="username" 
                        placeholder="email@pelanggan.com"
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Password</label>
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input 
                        id="password" 
                        :type="showPassword ? 'text' : 'password'" 
                        name="password" 
                        x-model="password"
                        required 
                        autocomplete="new-password" 
                        placeholder="Minimal 8 karakter..."
                        :class="{
                            'border-emerald-400 focus:border-emerald-500 focus:ring-emerald-500/10': isMatch,
                            'border-rose-400 focus:border-rose-500 focus:ring-rose-500/10': isMismatch
                        }"
                        class="w-full pl-11 pr-11 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword" 
                        class="absolute right-3 p-1.5 text-slate-400 hover:text-[#0D5C75] focus:outline-none transition-colors rounded-lg"
                        :title="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                        tabindex="-1"
                    >
                        <!-- Show Password Icon (Eye) -->
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Hide Password Icon (Eye Slash) -->
                        <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Ulangi Password</label>
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z" />
                    </svg>
                    <input 
                        id="password_confirmation" 
                        :type="showConfirmPassword ? 'text' : 'password'" 
                        name="password_confirmation" 
                        x-model="password_confirmation"
                        required 
                        placeholder="••••••••"
                        :class="{
                            'border-emerald-400 focus:border-emerald-500 focus:ring-emerald-500/10': isMatch,
                            'border-rose-400 focus:border-rose-500 focus:ring-rose-500/10': isMismatch
                        }"
                        class="w-full pl-11 pr-11 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                    <button 
                        type="button" 
                        @click="showConfirmPassword = !showConfirmPassword" 
                        class="absolute right-3 p-1.5 text-slate-400 hover:text-[#0D5C75] focus:outline-none transition-colors rounded-lg"
                        :title="showConfirmPassword ? 'Sembunyikan konfirmasi password' : 'Tampilkan konfirmasi password'"
                        tabindex="-1"
                    >
                        <!-- Show Password Icon (Eye) -->
                        <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Hide Password Icon (Eye Slash) -->
                        <svg x-show="showConfirmPassword" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Real-time Alerts: Success & Danger -->
            <div>
                <!-- Alert Success (Password Cocok) -->
                <div 
                    x-show="isMatch" 
                    x-cloak 
                    x-transition:enter="transition ease-out duration-300 transform" 
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                    class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center space-x-3 text-emerald-800 text-xs shadow-sm"
                >
                    <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="font-bold text-emerald-900">Password Cocok</p>
                        <p class="text-[11px] text-emerald-700">Password dan konfirmasi password keduanya cocok.</p>
                    </div>
                </div>

                <!-- Alert Danger (Password Tidak Cocok) -->
                <div 
                    x-show="isMismatch" 
                    x-cloak 
                    x-transition:enter="transition ease-out duration-300 transform" 
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-95" 
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                    class="p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center space-x-3 text-rose-800 text-xs shadow-sm"
                >
                    <div class="w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center flex-shrink-0 text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="font-bold text-rose-900">Password Tidak Cocok</p>
                        <p class="text-[11px] text-rose-700">Konfirmasi password tidak sama dengan password.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full py-4 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md shadow-[#0D5C75]/15 flex items-center justify-center">
                    Daftar Akun Pelanggan
                </button>
            </div>

            <div class="text-center text-xs text-slate-500 pt-2">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-[#0D5C75] hover:underline">Masuk di sini</a>
            </div>
        </form>
    </div>
</x-guest-layout>
