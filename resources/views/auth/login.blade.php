<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Address</label>
            <div class="relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                </svg>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="admin@santorinispa.com"
                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex justify-between items-center">
                <label for="password" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-semibold text-[#0D5C75] hover:underline" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-slate-400 absolute left-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" 
                    placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 focus:border-[#0D5C75] focus:ring-2 focus:ring-[#0D5C75]/10 rounded-xl text-slate-800 text-xs focus:outline-none transition-all duration-300"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Actions -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center select-none cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#0D5C75] focus:ring-[#0D5C75] shadow-sm" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-500">Ingat Sesi Saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-4 bg-[#0D5C75] hover:bg-[#0A475B] text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 shadow-md shadow-[#0D5C75]/15 flex items-center justify-center">
                Masuk Dashboard
            </button>
        </div>
    </form>
</x-guest-layout>
