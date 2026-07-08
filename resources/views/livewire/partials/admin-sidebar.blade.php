<div x-data="{ sidebarOpen: false }">
    <button @click="sidebarOpen = true"
        class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white border border-brand-border rounded-md hover:bg-brand-surface-low transition"
        aria-label="Open navigation">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 h-full w-64 bg-white border-r border-brand-border z-40 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0">

        {{-- Header --}}
        <div class="px-5 h-14 flex items-center justify-between border-b border-brand-border shrink-0">
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded bg-brand-primary flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <span class="font-display font-semibold text-sm tracking-tight text-brand-ink">Admin Panel</span>
            </div>
            <div class="flex items-center gap-2">
                <livewire:notification-bell />
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-md hover:bg-brand-surface-low text-brand-muted hover:text-brand-ink transition"
                    aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- User card --}}
        <div class="mx-3 mt-3 mb-2 flex items-center gap-3 px-3 py-2.5 rounded-md bg-brand-surface-low border border-brand-border">
            <div class="w-8 h-8 shrink-0 rounded-md bg-brand-primary flex items-center justify-center text-white text-xs font-semibold">
                {{ auth()->user()->initials() }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-brand-ink truncate">{{ auth()->user()->name }}</p>
                <p class="font-sans text-xs text-brand-muted tracking-wider uppercase">Administrator</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-1 overflow-y-auto">
            <p class="font-mono text-[9px] font-semibold text-brand-muted tracking-widest uppercase px-3 pt-3 pb-1.5">Management</p>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'dashboard' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'users' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.jobs') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'jobs' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Job Listings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.applications') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'applications' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.tags') }}" @click="sidebarOpen = false"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition
                           {{ $active === 'tags' ? 'bg-brand-primary-light text-brand-primary' : 'text-brand-muted hover:bg-brand-surface-low hover:text-brand-ink' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Tags
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer --}}
        <div class="p-3 border-t border-brand-border">
            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                Logout
            </a>
        </div>
    </aside>
</div>
