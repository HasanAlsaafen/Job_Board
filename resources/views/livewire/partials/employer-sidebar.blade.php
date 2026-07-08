@php $isRtl = app()->isLocale('ar'); @endphp

<div x-data="{
    open: false,
    collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
    toggle() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('sidebarCollapsed', this.collapsed);
        window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: { collapsed: this.collapsed } }));
    }
}" class="z-40">

    <button x-show="!open" @click="open = true"
        class="lg:hidden fixed top-4 z-50 p-2 bg-white border border-brand-border rounded-md hover:bg-brand-surface-low transition {{ $isRtl ? 'right-4' : 'left-4' }}"
        aria-label="{{ __('messages.sidebar.open_navigation') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <aside
        :class="{
            'translate-x-0': open,
            '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}': !open,
            'w-16': collapsed,
            'w-64': !collapsed
        }"
        class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} h-full bg-white {{ $isRtl ? 'border-l' : 'border-r' }} border-brand-border z-50 flex flex-col overflow-hidden transition-all duration-300 ease-in-out lg:translate-x-0">

        {{-- Header --}}
        <div class="h-14 flex items-center shrink-0 px-3 gap-2 border-b border-brand-border">
            <span x-show="!collapsed"
                class="flex-1 font-display font-semibold text-sm tracking-tight text-brand-ink truncate">
                {{ __('messages.sidebar.title') }}
            </span>

            <div x-show="!collapsed" class="flex items-center shrink-0">
                <livewire:notification-bell />
            </div>

            <button @click="toggle()" :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                class="hidden lg:flex items-center justify-center p-1.5 rounded-md hover:bg-brand-surface-low text-brand-muted hover:text-brand-ink transition shrink-0 {{ $isRtl ? '' : 'ml-auto' }}"
                :class="collapsed ? 'mx-auto' : ''">
                <svg x-show="!collapsed" xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 19l-7-7 7-7M18 19l-7-7 7-7" />
                </svg>
                <svg x-show="collapsed" xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 5l7 7-7 7M6 5l7 7-7 7" />
                </svg>
            </button>

            <button @click="open = false"
                class="lg:hidden flex items-center justify-center p-1.5 rounded-md hover:bg-brand-surface-low text-brand-muted transition shrink-0 ml-auto"
                aria-label="{{ __('messages.sidebar.close_menu') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- User card --}}
        <div :class="collapsed ? 'mx-2 px-2 justify-center' : 'mx-3 px-3 gap-3'"
            class="mt-3 mb-2 flex items-center py-2.5 rounded-md bg-brand-surface-low border border-brand-border shrink-0">
            <div
                class="w-8 h-8 shrink-0 rounded-md bg-brand-primary flex items-center justify-center text-white text-xs font-semibold">
                {{ auth()->user()->initials() }}
            </div>
            <p x-show="!collapsed" class="text-sm font-medium text-brand-ink truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 overflow-y-auto py-1">
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('dashboard') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.sidebar.dashboard') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'dashboard' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.sidebar.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.jobs') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.sidebar.my_jobs') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'jobs' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.sidebar.my_jobs') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.applicants') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.sidebar.applications') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'applicants' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.sidebar.applications') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('conversations.index') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.sidebar.messages') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'messages' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.sidebar.messages') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.profile') }}" @click="open = false"
                        :title="collapsed ? 'Profile' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'profile' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span x-show="!collapsed">Profile</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer --}}
        <div :class="collapsed ? 'px-2 py-3' : 'p-3'" class="space-y-1 shrink-0 border-t border-brand-border">
            <div x-show="!collapsed"
                class="flex items-center gap-1 p-1 bg-brand-surface rounded-md border border-brand-border">
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

            <a href="{{ route('logout') }}" :title="collapsed ? '{{ __('messages.auth.logout') }}' : ''"
                :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                class="flex items-center py-2.5 rounded-md text-sm font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4 shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                <span x-show="!collapsed">{{ __('messages.auth.logout') }}</span>
            </a>
        </div>
    </aside>
</div>

<livewire:chatbot />
