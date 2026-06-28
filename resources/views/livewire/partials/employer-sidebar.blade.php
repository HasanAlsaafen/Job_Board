@php $isRtl = app()->isLocale('ar'); @endphp

<div x-data="{ sidebarOpen: false }">
    <button
        @click="sidebarOpen = true"
        class="lg:hidden fixed top-4 z-50 p-2 bg-white rounded-lg shadow-sm border border-gray-200 hover:bg-gray-50 transition {{ $isRtl ? 'right-4' : 'left-4' }}"
        aria-label="{{ __('messages.sidebar.open_navigation') }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div
        x-show="sidebarOpen"
        x-cloak
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }}'"
        class="fixed top-0 {{ $isRtl ? 'right-0' : 'left-0' }} h-full w-64 bg-white {{ $isRtl ? 'border-l' : 'border-r' }} border-gray-100 z-40 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0"
    >
        {{-- Brand --}}
        <div class="px-5 pt-5 pb-4 flex items-center justify-between">
            <span class="text-sm font-bold tracking-tight text-gray-900">{{ __('messages.sidebar.title') }}</span>
            <button
                @click="sidebarOpen = false"
                class="lg:hidden p-1 rounded hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition"
                aria-label="{{ __('messages.sidebar.close_menu') }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- User --}}
        <div class="mx-3 mb-4 flex items-center gap-3 px-3 py-3 rounded-xl bg-gray-50 border border-gray-100">
            <div class="w-8 h-8 shrink-0 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                {{ auth()->user()->initials() }}
            </div>
            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3">
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'dashboard' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('messages.sidebar.dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.jobs') }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'jobs' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ __('messages.sidebar.my_jobs') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.applicants') }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'applicants' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('messages.sidebar.applications') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.profile') }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'profile' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('employer.tags') }}" @click="sidebarOpen = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                           {{ $active === 'tags' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 10V5a2 2 0 012-2z" />
                        </svg>
                        Tags
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer --}}
        <div class="p-3 space-y-1">
            <div class="flex items-center gap-1 p-1 bg-gray-100 rounded-lg">
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

            <a href="{{ route('logout') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                {{ __('messages.auth.logout') }}
            </a>
        </div>
    </aside>
</div>
