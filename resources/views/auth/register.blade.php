<x-guest-layout>
    <div class="space-y-6">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        placeholder="Minimal 8 karakter..."
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Ulangi Password</label>
                <div class="relative flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5 2a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z" />
                    </svg>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                    >
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
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
