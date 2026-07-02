<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    @if (auth()->user()->role === 'employer')
        @include('livewire.partials.employer-sidebar', ['active' => 'messages'])
    @else
        @include('livewire.partials.seeker-sidebar', ['active' => 'messages'])
    @endif

    @php
        $avatarColors = [
            'bg-indigo-500',
            'bg-violet-500',
            'bg-blue-500',
            'bg-emerald-500',
            'bg-amber-500',
            'bg-rose-500',
        ];
    @endphp

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        <header
            class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6 flex items-center justify-between gap-3">
            <div>
                <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.conversations.title') }}
                </h1>
                <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.conversations.subtitle') }}</p>
            </div>
            <div
                class="shrink-0 w-9 h-9 rounded-lg bg-brand-primary-light border border-brand-primary/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-brand-primary" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">

        @forelse ($conversations as $conversation)
            @php
                $other = $conversation->otherParticipant();
                $initials = $other->initials();
                $avatarColor = $avatarColors[crc32($other->name) % count($avatarColors)];
                $latest = $conversation->latestMessage;
                $isUnread = $latest && $latest->user_id !== auth()->id() && is_null($latest->read_at);
            @endphp

            <a href="{{ route('conversations.show', $conversation) }}" wire:key="conv-{{ $conversation->id }}"
                class="flex items-center gap-4 px-5 py-4 bg-white border border-brand-border rounded-lg mb-2 hover:border-brand-primary transition duration-150 group">

                <div class="relative shrink-0">
                    <div
                        class="w-11 h-11 rounded-full {{ $avatarColor }} flex items-center justify-center text-white font-display font-semibold text-sm">
                        @if (!$other->profile || !$other->profile->img_url)
                            {{ $initials }}
                        @else
                            <img src="{{ Storage::url($other->profile->img_url) }}" alt="{{ $other->name }}"
                                class="w-full h-full object-cover rounded-full">
                        @endif
                    </div>
                    @if ($isUnread)
                        <span
                            class="absolute -top-0.5 -right-0.5 block w-3 h-3 rounded-full bg-brand-primary border-2 border-white"></span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-baseline justify-between gap-2">
                        <p
                            class="font-display font-semibold text-brand-ink text-sm truncate {{ $isUnread ? 'font-bold' : '' }}">
                            {{ $other->name }}
                        </p>
                        <span class="font-mono text-[10px] text-brand-muted shrink-0">
                            {{ $conversation->last_message_at?->isToday()
                                ? $conversation->last_message_at->format('H:i')
                                : ($conversation->last_message_at?->isYesterday()
                                    ? __('messages.conversations.yesterday')
                                    : $conversation->last_message_at?->format('M j')) }}
                        </span>
                    </div>

                    @if ($conversation->jobListing)
                        <span
                            class="inline-flex items-center gap-1 text-[10px] font-mono text-brand-primary bg-brand-primary-light px-1.5 py-0.5 rounded mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ Str::limit($conversation->jobListing->title, 30) }}
                        </span>
                    @endif

                    @if ($latest)
                        <p
                            class="text-xs text-brand-muted mt-1 truncate {{ $isUnread ? 'text-brand-ink font-medium' : '' }}">
                            @if ($latest->user_id === auth()->id())
                                <span
                                    class="text-brand-primary text-[10px] font-mono mr-1">{{ __('messages.conversations.you') }}</span>
                            @endif
                            {{ Str::limit($latest->body, 55) }}
                        </p>
                    @else
                        <p class="text-xs text-brand-muted mt-1 italic">{{ __('messages.conversations.no_messages') }}
                        </p>
                    @endif
                </div>

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-brand-border group-hover:text-brand-primary transition-colors shrink-0 {{ app()->isLocale('ar') ? 'rotate-180' : '' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @empty
            <div class="bg-white border border-dashed border-brand-border rounded-lg p-12 text-center">
                <svg aria-hidden="true" class="mx-auto h-10 w-10 text-brand-muted/50 mb-4"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <p class="font-sans text-sm font-medium text-brand-ink">{{ __('messages.conversations.empty') }}</p>
                <p class="font-sans text-sm text-brand-muted mt-1 max-w-xs mx-auto leading-relaxed">
                    {{ __('messages.conversations.empty_hint') }}
                </p>
            </div>
        @endforelse
    </div>
</div>
