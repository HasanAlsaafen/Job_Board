@php
$isRtl = app()->isLocale('ar');
use App\Models\Profile;
$img = Profile::where('user_id', auth()->id())->value('img_url');
@endphp

<div
    x-data="{
        open: false,
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebarCollapsed', this.collapsed);
            window.dispatchEvent(new CustomEvent('sidebar-toggle', { detail: { collapsed: this.collapsed } }));
        }
    }"
    class="z-40"
>

    <button
        x-show="!open"
        @click="open = true"
        class="lg:hidden fixed top-4 z-50 p-2 bg-white rounded-lg shadow-sm  hover:bg-gray-50 transition {{ $isRtl ? 'right-4' : 'left-4' }}"
        aria-label="{{ __('messages.sidebar.open_navigation') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div
        x-show="open"
        x-cloak
        @click="open = false"
        class="fixed inset-0 bg-black/50 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <aside
        :class="{
            'translate-x-0': open,
            '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}': !open,
            'w-16': collapsed,
            'w-64': !collapsed
        }"
        class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} h-full bg-white {{ $isRtl ? 'border-l' : 'border-r' }} border-blue-100 shadow-sm z-40 flex flex-col overflow-hidden transition-all duration-300 ease-in-out lg:translate-x-0"
    >

        {{-- Header --}}
        <div class="h-14 flex items-center shrink-0 px-3 gap-2">
            <span
                x-show="!collapsed"
                class="flex-1 text-sm font-bold tracking-tight text-gray-900 truncate"
            >
                {{ __('messages.seeker_sidebar.title') }}
            </span>

            {{-- Desktop: collapse / expand toggle --}}
            <button
                @click="toggle()"
                :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                class="hidden lg:flex items-center justify-center p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition shrink-0 {{ $isRtl ? '' : 'ml-auto' }}"
                :class="collapsed ? 'mx-auto' : ''"
            >
                {{-- Shows chevrons-left when expanded, chevrons-right when collapsed (flipped for RTL) --}}
                <svg x-show="!collapsed" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7M18 19l-7-7 7-7" />
                </svg>
                <svg x-show="collapsed" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $isRtl ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M6 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Mobile: close button --}}
            <button
                @click="open = false"
                class="lg:hidden flex items-center justify-center p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition shrink-0 ml-auto"
                aria-label="{{ __('messages.sidebar.close_menu') }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @auth
            <div
                :class="collapsed ? 'mx-2 px-2 justify-center' : 'mx-3 px-3 gap-3'"
                class="mb-3 flex items-center py-2.5 rounded-xl bg-gray-50 shrink-0"
            >
                <div class="w-8 h-8 shrink-0 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold overflow-hidden">
                    @if ($img)
                        <img src="{{ $img }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 object-cover" />
                    @else
                        {{ auth()->user()->initials() }}
                    @endif
                </div>
                <p x-show="!collapsed" class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
            </div>
        @endauth

        {{-- Navigation --}}
        <nav class="flex-1 px-2 overflow-y-auto">
            <ul class="space-y-0.5">

                <li>
                    <a href="{{ route('openings') }}"
                       @click="open = false"
                       :title="collapsed ? '{{ __('messages.seeker_sidebar.openings') }}' : ''"
                       :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                       class="flex items-center py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'openings' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.openings') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.applications') }}"
                       @click="open = false"
                       :title="collapsed ? '{{ __('messages.seeker_sidebar.my_applications') }}' : ''"
                       :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                       class="flex items-center py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'myApplications' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.my_applications') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.saved-jobs') }}"
                       @click="open = false"
                       :title="collapsed ? '{{ __('messages.seeker_sidebar.saved_jobs') }}' : ''"
                       :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                       class="flex items-center py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'savedJobs' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z"/>
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.saved_jobs') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('seeker.profile') }}"
                       @click="open = false"
                       :title="collapsed ? '{{ __('messages.seeker_sidebar.profile') }}' : ''"
                       :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
                       class="flex items-center py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'profile' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span x-show="!collapsed">{{ __('messages.seeker_sidebar.profile') }}</span>
                    </a>
                </li>

            </ul>
        </nav>

        {{-- Footer: language switcher + logout --}}
        <div :class="collapsed ? 'px-2 py-3' : 'p-3'" class="space-y-1 shrink-0">

            {{-- Language switcher: hidden when collapsed --}}
            <div x-show="!collapsed" class="flex items-center gap-1 p-1 bg-gray-100 rounded-lg">
                <a href="{{ route('lang.switch', 'en') }}"
                   class="flex-1 text-center text-xs font-semibold py-1.5 rounded-md transition
                       {{ app()->getLocale() === 'en' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    EN
                </a>
                <a href="{{ route('lang.switch', 'ar') }}"
                   class="flex-1 text-center text-xs font-semibold py-1.5 rounded-md transition
                       {{ app()->getLocale() === 'ar' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    AR
                </a>
            </div>

            {{-- Logout --}}
            <a href="{{ route('logout') }}"
               :title="collapsed ? '{{ __('messages.auth.logout') }}' : ''"
               :class="collapsed ? 'justify-center px-2' : 'gap-3 px-3'"
               class="flex items-center py-2.5 rounded-lg text-sm font-medium text-gray-500 hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                <span x-show="!collapsed">{{ __('messages.auth.logout') }}</span>
            </a>

        </div>

    </aside>
</div>
