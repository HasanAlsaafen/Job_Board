<div class="w-full max-w-sm mx-auto py-10" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="text-center mb-8">

        <h1 class="text-2xl font-black text-gray-900">{{ __('messages.auth.create_account_title') }}</h1>
        <p class="text-sm text-gray-400 mt-1">{{ __('messages.auth.register_subtitle') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-7">

        @if ($successMessage)
            <div class="flex items-center gap-2 p-3 mb-5 text-xs font-medium text-green-700 bg-green-50 rounded-xl border border-green-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="registerUser" class="space-y-4 text-sm">
            <div>
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.full_name') }}</label>
                <input type="text" wire:model="name" autocomplete="name"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.email') }}</label>
                <input type="email" wire:model="email" autocomplete="email"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.i_am_a') }}</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="role" value="seeker" class="sr-only peer">
                        <div class="flex items-center gap-2 px-3 py-2.5 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition text-gray-600 peer-checked:text-blue-700 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            {{ __('messages.auth.job_seeker') }}
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model="role" value="employer" class="sr-only peer">
                        <div class="flex items-center gap-2 px-3 py-2.5 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition text-gray-600 peer-checked:text-blue-700 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                            </svg>
                            {{ __('messages.auth.employer_role') }}
                        </div>
                    </label>
                </div>
                @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ show: false }">
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.password') }}</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" wire:model="password" autocomplete="new-password"
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

            <div x-data="{ show: false }">
                <label class="block font-medium text-gray-700 mb-1.5">{{ __('messages.auth.confirm_password') }}</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" wire:model="password_confirmation" autocomplete="new-password"
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
                @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-70 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                <svg wire:loading wire:target="registerUser" class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                {{ __('messages.auth.create_account_button') }}
            </button>
        </form>
    </div>

    <p class="text-center text-gray-500 text-xs mt-5">
        {{ __('messages.auth.already_have_account') }}
        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 hover:underline font-semibold">{{ __('messages.auth.log_in') }}</a>
    </p>

</div>
