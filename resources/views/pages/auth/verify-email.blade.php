<x-layouts.auth :title="__('Verify Email')">
    <div class="flex flex-col gap-6 bg-white text-black">
        <x-auth-header :title="__('Check your inbox')" :description="__('Please verify your email address by clicking the link we sent you.')" />

        <div
            class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 p-5 flex flex-col items-center gap-3 text-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/40">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0-9.75 6.75L2.25 6.75" />
                </svg>
            </div>
            <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __("Didn't receive it? Check your spam folder or resend below.") }}
            </flux:text>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div
                class="flex items-center gap-2 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-green-600 dark:text-green-400"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <flux:text class="text-sm font-medium text-green-700 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </flux:text>
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </flux:button>
            </form>

            <div class="relative flex items-center gap-3">
                <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>
                <span class="text-xs text-zinc-400">{{ __('or') }}</span>
                <div class="h-px flex-1 bg-zinc-200 dark:bg-zinc-700"></div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="w-full text-sm" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts.auth>
