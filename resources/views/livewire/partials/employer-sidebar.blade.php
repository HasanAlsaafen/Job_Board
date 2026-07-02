@php $isRtl = app()->isLocale('ar'); @endphp

<div x-data="{ sidebarOpen: false }">
    <button @click="sidebarOpen = true"
        class="lg:hidden fixed top-4 z-50 p-2 bg-white border border-brand-border rounded-md hover:bg-brand-surface-low transition {{ $isRtl ? 'right-4' : 'left-4' }}"
        aria-label="{{ __('messages.sidebar.open_navigation') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}'"
        class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} h-full w-64 bg-white {{ $isRtl ? 'border-l' : 'border-r' }} border-brand-border z-40 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0">

        <div class="px-5 h-14 flex items-center justify-between border-b border-brand-border shrink-0">
            <span
                class="font-display font-semibold text-sm tracking-tight text-brand-ink">{{ __('messages.sidebar.title') }}</span>
            <div class="flex items-center gap-2">
                <livewire:notification-bell />
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-md hover:bg-brand-surface-low text-brand-muted hover:text-brand-ink transition"
                    aria-label="{{ __('messages.sidebar.close_menu') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div
            class="mx-3 mt-3 mb-2 flex items-center gap-3 px-3 py-2.5 rounded-md bg-brand-surface-low border border-brand-border">
            <div
                class="w-8 h-8 shrink-0 rounded-md bg-brand-primary flex items-center justify-center text-white text-xs font-semibold">
                {{ auth()->user()->initials() }}
            </div>
            <p class="text-sm font-medium text-brand-ink truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-1">
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'dashboard' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('messages.sidebar.dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.jobs') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'jobs' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('messages.sidebar.my_jobs') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.applicants') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'applicants' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('messages.sidebar.applications') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('conversations.index') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'messages' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        {{ __('messages.sidebar.messages') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.profile') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'profile' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                </li>
                <li>
                    <button type="button"
                        @click="window.dispatchEvent(new CustomEvent('chatbot-toggle')); sidebarOpen = false"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        {{ __('messages.sidebar.job_assistant') }}
                    </button>
                </li>
            </ul>
        </nav>

        {{-- Footer --}}
        <div class="p-3 space-y-1 border-t border-brand-border">
            <div class="flex items-center gap-1 p-1 bg-brand-surface rounded-md border border-brand-border">
                <a href="{{ route('lang.switch', 'en') }}"
                    class="flex-1 text-center font-mono text-xs font-medium py-1.5 rounded transition
                       {{ app()->getLocale() === 'en' ? 'bg-white text-brand-ink shadow-sm' : 'text-brand-muted hover:text-brand-ink' }}">
                    EN
                </a>
                <a href="{{ route('lang.switch', 'ar') }}"
                    class="flex-1 text-center font-mono text-xs font-medium py-1.5 rounded transition
                       {{ app()->getLocale() === 'ar' ? 'bg-white text-brand-ink shadow-sm' : 'text-brand-muted hover:text-brand-ink' }}">
                    AR
                </a>
            </div>

            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                {{ __('messages.auth.logout') }}
            </a>
        </div>
    </aside>
</div>

<livewire:chatbot />
