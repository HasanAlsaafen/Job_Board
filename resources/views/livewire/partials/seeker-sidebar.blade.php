@php
    $isRtl = app()->isLocale('ar');
    use App\Models\Profile;
    $img = Profile::where('user_id', auth()->id())->value('img_url');
@endphp

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
                {{ __('messages.seeker_sidebar.title') }}
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
        @auth
            <div :class="collapsed ? 'mx-2 px-2 justify-center' : 'mx-3 px-3 gap-3'"
                class="mt-3 mb-2 flex items-center py-2.5 rounded-md bg-brand-surface-low border border-brand-border shrink-0">
                <div
                    class="w-8 h-8 shrink-0 rounded-md bg-brand-primary flex items-center justify-center text-white text-xs font-semibold overflow-hidden">
                    @if ($img)
                        <img src="{{ Storage::url($img) }}" alt="{{ auth()->user()->name }}"
                            class="w-8 h-8 object-cover" />
                    @else
                        {{ auth()->user()->initials() }}
                    @endif
                </div>
                <p x-show="!collapsed" class="text-sm font-medium text-brand-ink truncate">{{ auth()->user()->name }}</p>
            </div>
        @endauth

        {{-- Nav --}}
        <nav class="flex-1 px-2 overflow-y-auto py-1">
            <ul class="space-y-0.5">

                <li>
                    <a href="{{ route('seeker.dashboard') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.dashboard') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'dashboard' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.dashboard') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('openings') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.openings') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'openings' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.openings') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.applications') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.my_applications') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'myApplications' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.my_applications') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.saved-jobs') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.saved_jobs') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'savedJobs' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.saved_jobs') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.profile') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.profile') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'profile' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.profile') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('conversations.index') }}" @click="open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.messages') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="flex items-center py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'messages' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.messages') }}</span>
                    </a>
                </li>

                <li>
                    <button type="button"
                        @click="window.dispatchEvent(new CustomEvent('chatbot-toggle')); open = false"
                        :title="collapsed ? '{{ __('messages.seeker_sidebar.job_assistant') }}' : ''"
                        :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                        class="w-full flex items-center py-2.5 rounded-md text-sm font-medium transition text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="currentColor"
                            viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path
                                d="M352 64C352 46.3 337.7 32 320 32C302.3 32 288 46.3 288 64L288 128L192 128C139 128 96 171 96 224L96 448C96 501 139 544 192 544L448 544C501 544 544 501 544 448L544 224C544 171 501 128 448 128L352 128L352 64zM160 432C160 418.7 170.7 408 184 408L216 408C229.3 408 240 418.7 240 432C240 445.3 229.3 456 216 456L184 456C170.7 456 160 445.3 160 432zM280 432C280 418.7 290.7 408 304 408L336 408C349.3 408 360 418.7 360 432C360 445.3 349.3 456 336 456L304 456C290.7 456 280 445.3 280 432zM400 432C400 418.7 410.7 408 424 408L456 408C469.3 408 480 418.7 480 432C480 445.3 469.3 456 456 456L424 456C410.7 456 400 445.3 400 432zM224 240C250.5 240 272 261.5 272 288C272 314.5 250.5 336 224 336C197.5 336 176 314.5 176 288C176 261.5 197.5 240 224 240zM368 288C368 261.5 389.5 240 416 240C442.5 240 464 261.5 464 288C464 314.5 442.5 336 416 336C389.5 336 368 314.5 368 288zM64 288C64 270.3 49.7 256 32 256C14.3 256 0 270.3 0 288L0 384C0 401.7 14.3 416 32 416C49.7 416 64 401.7 64 384L64 288zM608 256C590.3 256 576 270.3 576 288L576 384C576 401.7 590.3 416 608 416C625.7 416 640 401.7 640 384L640 288C640 270.3 625.7 256 608 256z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.job_assistant') }}</span>
                    </button>
                </li>

            </ul>
        </nav>

        {{-- Footer --}}
        <div :class="collapsed ? 'px-2 py-3' : 'p-3'" class="space-y-1 shrink-0 border-t border-brand-border">

            <div x-show="!collapsed">
                <livewire:push-subscription />
            </div>

            <div x-show="!collapsed"
                class="flex items-center gap-1 p-1 bg-brand-surface rounded-md border border-brand-border"
                role="group" aria-label="{{ __('messages.sidebar.language_switcher') }}">
                <a href="{{ route('lang.switch', 'en') }}" aria-label="{{ __('messages.sidebar.switch_to_en') }}"
                    aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}"
                    class="flex-1 text-center font-sans text-xs font-medium py-1.5 rounded transition
                       {{ app()->getLocale() === 'en' ? 'bg-white text-brand-ink shadow-sm' : 'text-brand-muted hover:text-brand-ink' }}">
                    EN
                </a>
                <a href="{{ route('lang.switch', 'ar') }}" aria-label="{{ __('messages.sidebar.switch_to_ar') }}"
                    aria-current="{{ app()->getLocale() === 'ar' ? 'true' : 'false' }}"
                    class="flex-1 text-center font-sans text-xs font-medium py-1.5 rounded transition
                       {{ app()->getLocale() === 'ar' ? 'bg-white text-brand-ink shadow-sm' : 'text-brand-muted hover:text-brand-ink' }}">
                    AR
                </a>
            </div>

            <a href="{{ route('logout') }}" :title="collapsed ? '{{ __('messages.auth.logout') }}' : ''"
                :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                class="flex items-center py-2.5 rounded-md text-sm font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                <span x-show="!collapsed">{{ __('messages.auth.logout') }}</span>
            </a>

        </div>

    </aside>
</div>

<livewire:chatbot />
