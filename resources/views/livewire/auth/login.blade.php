<div class="w-full max-w-sm mx-auto py-10 " dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="text-center mb-8">

        <h1 class="text-2xl font-black text-gray-900">{{ __('messages.auth.welcome_back') }}</h1>
        <p class="text-sm text-gray-400 mt-1">{{ __('messages.auth.login_subtitle') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7">

        @if ($errorMessage)
            <div class="flex items-center gap-2 p-3 mb-5 text-xs font-medium text-red-700 bg-red-50 rounded-xl border border-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
                {{ $errorMessage }}
            </div>
        @endif

        <form wire:submit.prevent="loginUser" class="space-y-4 text-sm">
            <div>
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.email') }}</label>
                <input type="email" wire:model="email" autocomplete="email"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ show: false }">
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.password') }}</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" wire:model="password" autocomplete="current-password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 {{ app()->isLocale('ar') ? 'pl-10' : 'pr-10' }} text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 {{ app()->isLocale('ar') ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-gray-400 hover:text-gray-600 transition">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-70 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                <svg wire:loading wire:target="loginUser" class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                {{ __('messages.auth.log_in') }}
            </button>
        </form>
    </div>

    <p class="text-center text-gray-500 text-xs mt-5">
        {{ __('messages.auth.no_account') }}
        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 hover:underline font-semibold">{{ __('messages.auth.sign_up') }}</a>
    </p>

</div>
