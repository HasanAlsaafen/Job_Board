@php
    $isRtl = app()->isLocale('ar');
@endphp

<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ $isRtl ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ $isRtl ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col h-screen bg-brand-surface" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

    @if (auth()->user()->role === 'employer')
        @include('livewire.partials.employer-sidebar', ['active' => 'messages'])
    @else
        @include('livewire.partials.seeker-sidebar', ['active' => 'messages'])
    @endif

    <div
        class="bg-white border-b border-brand-border py-3 {{ $isRtl ? 'pr-16 pl-4 lg:pr-4' : 'pl-16 pr-4 lg:pl-4' }} flex items-center gap-3 shrink-0 shadow-sm">
        <a href="{{ route('conversations.index') }}"
            class="w-8 h-8 flex items-center justify-center rounded-md text-brand-muted hover:text-brand-primary hover:bg-brand-surface-low transition-colors shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isRtl ? 'rotate-180' : '' }}" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        @php
            $initials = collect(explode(' ', $otherParticipant->name))
                ->take(1)
                ->join('');
            $avatarColors = [
                'bg-indigo-500',
                'bg-violet-500',
                'bg-blue-500',
                'bg-emerald-500',
                'bg-amber-500',
                'bg-rose-500',
            ];
            $avatarColor = $avatarColors[crc32($otherParticipant->name) % count($avatarColors)];
        @endphp
        <div class="relative shrink-0">
            <div
                class="w-9 h-9 rounded-full {{ $avatarColor }} flex items-center justify-center text-white font-display font-semibold text-sm">
                @if (!$otherParticipant->profile || !$otherParticipant->profile->img_url)
                    {{ $initials }}
                @else
                    <img src="{{ Storage::url($otherParticipant->profile->img_url) }}"
                        alt="{{ $otherParticipant->name }}" class="w-full h-full object-cover rounded-full">
                @endif
            </div>

        </div>

        <div class="flex-1 min-w-0">
            <p class="font-display font-semibold text-brand-ink text-sm leading-tight">{{ $otherParticipant->name }}
            </p>
            @if ($conversation->jobListing)
                <p class="text-xs text-brand-muted truncate flex items-center gap-1 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $conversation->jobListing->title }}
                </p>
            @endif
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5" id="messages-container" x-data
        x-on:message-received.window="$el.scrollTop = $el.scrollHeight" x-init="$el.scrollTop = $el.scrollHeight"
        style="background-color: #F6F7FB; background-image: radial-gradient(rgba(79,70,229,0.06) 1px, transparent 1px); background-size: 22px 22px;">

        @if ($messages->isEmpty())
            <div class="flex flex-col items-center justify-center h-full text-center pb-8">
                <div
                    class="w-14 h-14 rounded-full {{ $avatarColor }} flex items-center justify-center text-white font-display font-semibold text-lg mb-3">
                    @if (!$otherParticipant->profile || !$otherParticipant->profile->img_url)
                        {{ $initials }}
                    @else
                        <img src="{{ Storage::url($otherParticipant->profile->img_url) }}"
                            alt="{{ $otherParticipant->name }}" class="w-full h-full object-cover rounded-full">
                    @endif
                </div>

                <p class="font-display font-semibold text-brand-ink text-sm">{{ $otherParticipant->name }}</p>
                @if ($conversation->jobListing)
                    <span
                        class="inline-flex items-center gap-1 mt-2 px-2.5 py-1 bg-brand-primary-light text-brand-primary text-xs font-mono rounded-md border border-brand-primary/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $conversation->jobListing->title }}
                    </span>
                @endif
                <p class="text-brand-muted text-xs mt-3 leading-relaxed max-w-xs">
                    {{ __('messages.chat.empty_hint') }}
                </p>
            </div>
        @else
            @php
                $prevDate = null;
            @endphp

            @foreach ($messages as $message)
                @php
                    $msgDate = $message->created_at->toDateString();
                    $isOwn = $message->user_id === auth()->id();
                @endphp

                @if ($msgDate !== $prevDate)
                    @php $prevDate = $msgDate; @endphp
                    <div class="flex justify-center py-3 sticky top-0 z-10">
                        <span
                            class="font-mono text-[10px] text-brand-muted uppercase tracking-wider px-3 py-1 rounded-full bg-white/90 backdrop-blur-sm shadow-sm border border-brand-border/60">
                            {{ $message->created_at->isToday() ? __('messages.conversations.today') : ($message->created_at->isYesterday() ? __('messages.conversations.yesterday') : $message->created_at->format('M j, Y')) }}
                        </span>
                    </div>
                @endif

                <div wire:key="msg-{{ $message->id }}"
                    class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }} items-end gap-2">

                    @unless ($isOwn)
                        @php
                            $senderInitials = collect(explode(' ', $message->user->name))
                                ->take(1)
                                ->join('');
                            $senderColor = $avatarColors[crc32($message->user->name) % count($avatarColors)];
                        @endphp

                        <div
                            class="w-8 h-8 shrink-0 rounded-full {{ $senderColor }} flex items-center justify-center text-white font-display font-semibold text-xs mb-0.5">
                            @if (!$otherParticipant->profile || !$otherParticipant->profile->img_url)
                                {{ $senderInitials }}
                            @else
                                <img src="{{ Storage::url($otherParticipant->profile->img_url) }}"
                                    alt="{{ $otherParticipant->name }}" class="w-full h-full object-cover rounded-full">
                            @endif
                        </div>
                    @endunless

                    <div class="max-w-[75%] sm:max-w-xs lg:max-w-md">
                        <div
                            class="px-3 py-2 rounded-2xl text-sm leading-relaxed shadow-sm
                            {{ $isOwn
                                ? 'bg-brand-primary text-white rounded-br-md'
                                : 'bg-white text-brand-ink border border-brand-border/70 rounded-bl-md' }}">
                            <span class="whitespace-pre-wrap break-words align-bottom">{{ $message->body }}</span>

                            <span
                                class="{{ $isRtl ? 'float-left' : 'float-right' }} inline-flex items-center gap-1 select-none ms-2 mt-1 translate-y-0.5 {{ $isOwn ? 'text-white/70' : 'text-brand-muted' }}">
                                <span class="font-mono text-[10px]">
                                    {{ $message->created_at->format('H:i') }}
                                </span>

                                @if ($isOwn)
                                    <span
                                        class="inline-flex items-center {{ $message->read_at ? 'text-sky-300' : 'text-white/70' }}">
                                        @if ($message->read_at)
                                            <div class="flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-3 relative -left-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 12.75 6 6 9-13" />
                                                </svg>
                                            </div>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75 9 17.25 19.5 6" />
                                            </svg>
                                        @endif
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="bg-brand-surface border-t border-brand-border px-3 py-2.5 shrink-0">
        <div class="flex items-end gap-2">
            <div
                class="flex-1 flex items-center gap-2 bg-white border border-brand-border rounded-full px-4 py-2.5 shadow-sm
                focus-within:border-brand-primary focus-within:ring-2 focus-within:ring-brand-primary/10 transition">
                <input type="text" wire:model="newMessage" wire:keydown.enter="send"
                    placeholder="{{ __('messages.chat.placeholder') }}"
                    class="flex-1 bg-transparent text-sm text-brand-ink border-0 rounded-xl placeholder-brand-muted focus:outline-none min-w-0 font-sans">
            </div>

            <button wire:click="send" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                class="shrink-0 w-11 h-11 bg-brand-primary hover:bg-brand-primary-dark disabled:opacity-50 text-white rounded-full flex items-center justify-center transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isRtl ? '-rotate-90' : 'rotate-90' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </div>
    </div>
</div>
