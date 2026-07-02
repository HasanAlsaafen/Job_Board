@php
    $isRtl = app()->isLocale('ar');
@endphp

<div>
    @once
        <style>
            .chatbot-md {
                font-size: 0.875rem;
                line-height: 1.6;
            }

            .chatbot-md p {
                margin-bottom: 0.5rem;
            }

            .chatbot-md p:last-child {
                margin-bottom: 0;
            }

            .chatbot-md h1,
            .chatbot-md h2,
            .chatbot-md h3,
            .chatbot-md h4 {
                font-family: 'Hanken Grotesk', sans-serif;
                font-weight: 600;
                margin: 0.6rem 0 0.3rem;
                line-height: 1.3;
            }

            .chatbot-md h1 {
                font-size: 1.1rem;
            }

            .chatbot-md h2 {
                font-size: 1rem;
            }

            .chatbot-md h3,
            .chatbot-md h4 {
                font-size: 0.875rem;
            }

            .chatbot-md ul,
            .chatbot-md ol {
                padding-inline-start: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .chatbot-md ul {
                list-style-type: disc;
            }

            .chatbot-md ol {
                list-style-type: decimal;
            }

            .chatbot-md li {
                margin-bottom: 0.2rem;
            }

            .chatbot-md strong {
                font-weight: 600;
            }

            .chatbot-md em {
                font-style: italic;
            }

            .chatbot-md code {
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.78rem;
                background: rgba(79, 70, 229, 0.08);
                color: #3525cd;
                padding: 0.1em 0.35em;
                border-radius: 3px;
            }

            .chatbot-md pre {
                background: #1e1b4b;
                color: #e0e7ff;
                border-radius: 6px;
                padding: 0.75rem 1rem;
                margin: 0.5rem 0;
                overflow-x: auto;
            }

            .chatbot-md pre code {
                background: none;
                padding: 0;
                color: inherit;
                font-size: 0.78rem;
            }

            .chatbot-md blockquote {
                border-inline-start: 3px solid #4F46E5;
                padding-inline-start: 0.75rem;
                color: #464555;
                margin: 0.5rem 0;
                font-style: italic;
            }

            .chatbot-md a {
                color: #4F46E5;
                text-decoration: underline;
            }

            .chatbot-md hr {
                border: none;
                border-top: 1px solid #E5E7EB;
                margin: 0.5rem 0;
            }

            .chatbot-md table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.8rem;
                margin: 0.5rem 0;
                font-family: 'JetBrains Mono', monospace;
            }

            .chatbot-md th {
                background: #EEF2FF;
                font-weight: 600;
                padding: 0.35rem 0.6rem;
                border: 1px solid #E5E7EB;
                color: #141B2B;
            }

            .chatbot-md td {
                padding: 0.3rem 0.6rem;
                border: 1px solid #E5E7EB;
            }

            .chatbot-md-user code {
                background: rgba(255, 255, 255, 0.2);
                color: #e0e7ff;
            }

            .chatbot-md-user pre {
                background: rgba(0, 0, 0, 0.25);
            }

            .chatbot-md-user blockquote {
                border-inline-start-color: rgba(255, 255, 255, 0.5);
                color: rgba(255, 255, 255, 0.8);
            }

            .chatbot-md-user a {
                color: #c7d2fe;
            }
        </style>
    @endonce

    <div x-data="{
        open: false,
        expanded: false,
        collapsed: localStorage.getItem('sidebarCollapsed') === 'true'
    }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
        @chatbot-toggle.window="open = !open; if (!open) expanded = false">

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            :class="[expanded ? 'w-[680px]' : 'w-[360px]', collapsed ? '{{ $isRtl ? 'lg:right-20' : 'lg:left-20' }}' :
                '{{ $isRtl ? 'lg:right-72' : 'lg:left-72' }}'
            ]"
            :style="expanded ? 'height: min(82vh, 780px)' : 'height: 520px'"
            class="fixed bottom-6 {{ $isRtl ? 'left-6 lg:left-auto' : 'right-6 lg:right-auto' }} z-[9999] bg-white border border-brand-border rounded-lg shadow-lg flex flex-col overflow-hidden transition-all duration-300">

            <div class="bg-brand-primary px-4 py-3 flex items-center gap-3 shrink-0">
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-md bg-white/15 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <span
                        class="absolute -bottom-0.5 -right-0.5 block h-2.5 w-2.5 rounded-full bg-emerald-400 ring-2 ring-brand-primary"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-display font-semibold text-sm leading-tight">Job Assistant</p>
                </div>
                <button @click="expanded = !expanded" title="Toggle expand"
                    class="text-white/60 hover:text-white transition-colors p-1.5 rounded hover:bg-white/10">
                    <svg x-show="!expanded" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                    </svg>
                    <svg x-show="expanded" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                    </svg>
                </button>
                <button wire:click="clearHistory" title="Clear conversation"
                    class="text-white/60 hover:text-white transition-colors p-1.5 rounded hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <button @click="open = false; expanded = false" title="Close"
                    class="text-white/60 hover:text-white transition-colors p-1.5 rounded hover:bg-white/10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-brand-surface" x-ref="messages"
                x-effect="$el.scrollTop = $el.scrollHeight">

                @if (empty($history))
                    <div class="flex flex-col items-center justify-center h-full text-center px-4 pb-4">
                        <div
                            class="w-14 h-14 rounded-lg bg-brand-primary-light border border-brand-primary/20 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-brand-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-display font-semibold text-brand-ink text-sm">Hi there</h3>
                        <p class="text-brand-muted text-xs mt-1 leading-relaxed">I'm your personal job assistant. Ask me
                            anything about finding your dream job.</p>
                        <div class="mt-4 flex flex-col gap-1.5 w-full">
                            <p class="font-mono text-brand-muted text-[10px] font-medium uppercase tracking-wider mb-1">
                                Quick questions</p>
                            <button wire:click="$set('message', 'What jobs are available for me?')"
                                @click="$wire.sendMessage()"
                                class="text-left font-mono text-xs text-brand-primary bg-brand-primary-light hover:bg-brand-primary/20 border border-brand-primary/20 rounded-md px-3 py-2.5 transition">
                                What jobs are available for me?
                            </button>
                            <button wire:click="$set('message', 'How do I improve my profile?')"
                                @click="$wire.sendMessage()"
                                class="text-left font-mono text-xs text-brand-primary bg-brand-primary-light hover:bg-brand-primary/20 border border-brand-primary/20 rounded-md px-3 py-2.5 transition">
                                How do I improve my profile?
                            </button>
                            <button wire:click="$set('message', 'Tips for writing a great resume')"
                                @click="$wire.sendMessage()"
                                class="text-left font-mono text-xs text-brand-primary bg-brand-primary-light hover:bg-brand-primary/20 border border-brand-primary/20 rounded-md px-3 py-2.5 transition">
                                Tips for writing a great resume
                            </button>
                        </div>
                    </div>
                @endif

                @foreach ($history as $index => $msg)
                    @php
                        $isUser = $msg['role'] === 'user';
                        $content = $msg['content'];

                        $jsonData = null;
                        $isJson = false;
                        $trimmed = trim($content);
                        if (str_starts_with($trimmed, '{') || str_starts_with($trimmed, '[')) {
                            $decoded = json_decode($trimmed, true);
                            if (json_last_error() === JSON_ERROR_NONE) {
                                $isJson = true;
                                $jsonData = $decoded;
                            }
                        }

                        $isArabic = (bool) preg_match('/[\x{0600}-\x{06FF}]/u', $content);
                        $dir = $isArabic ? 'rtl' : 'ltr';
                        $textAlign = $isArabic ? 'text-right' : 'text-left';

                        $markdownHtml = '';
                        if (!$isJson) {
                            $converter = new \League\CommonMark\CommonMarkConverter([
                                'html_input' => 'strip',
                                'allow_unsafe_links' => false,
                            ]);
                            $markdownHtml = $converter->convert($content)->getContent();
                        }
                    @endphp

                    <div class="flex items-end gap-2 {{ $isUser ? 'flex-row-reverse' : 'flex-row' }}">
                        @unless ($isUser)
                            <div
                                class="w-7 h-7 rounded-full bg-brand-primary flex items-center justify-center shrink-0 mb-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-white">
                                    <path
                                        d="M260.4 249.8L260.4 201.2C260.4 197.1 261.9 194 265.5 192L363.3 135.7C376.6 128 392.5 124.4 408.9 124.4C470.3 124.4 509.3 172 509.3 222.7C509.3 226.3 509.3 230.4 508.8 234.5L407.3 175.1C401.2 171.5 395 171.5 388.9 175.1L260.4 249.8zM488.7 439.2L488.7 323C488.7 315.8 485.6 310.7 479.5 307.1L351 232.4L393 208.3C396.6 206.3 399.7 206.3 403.2 208.3L501 264.7C529.2 281.1 548.1 315.9 548.1 349.7C548.1 388.6 525.1 424.5 488.7 439.3L488.7 439.3zM230.2 336.8L188.2 312.2C184.6 310.2 183.1 307.1 183.1 303L183.1 190.4C183.1 135.6 225.1 94.1 281.9 94.1C303.4 94.1 323.4 101.3 340.3 114.1L239.4 172.5C233.3 176.1 230.2 181.2 230.2 188.4L230.2 336.9L230.2 336.9zM320.6 389L260.4 355.2L260.4 283.5L320.6 249.7L380.8 283.5L380.8 355.2L320.6 389zM359.3 544.7C337.8 544.7 317.8 537.5 300.9 524.7L401.8 466.3C407.9 462.7 411 457.6 411 450.4L411 301.9L453.5 326.5C457.1 328.5 458.6 331.6 458.6 335.7L458.6 448.3C458.6 503.1 416.1 544.6 359.3 544.6L359.3 544.6zM237.8 430.5L140.1 374.2C111.9 357.8 93 323 93 289.2C93 249.8 116.6 214.4 152.9 199.6L152.9 316.3C152.9 323.5 156 328.6 162.1 332.2L290.1 406.4L248.1 430.5C244.5 432.5 241.4 432.5 237.9 430.5zM232.2 514.5C174.3 514.5 131.8 471 131.8 417.2C131.8 413.1 132.3 409 132.8 404.9L233.7 463.3C239.8 466.9 246 466.9 252.1 463.3L380.6 389.1L380.6 437.7C380.6 441.8 379.1 444.9 375.5 446.9L277.7 503.2C264.4 510.9 248.5 514.5 232.1 514.5L232.1 514.5zM359.2 575.4C421.2 575.4 472.9 531.4 484.6 473C541.9 458.1 578.8 404.4 578.8 349.6C578.8 313.8 563.4 278.9 535.8 253.9C538.4 243.1 539.9 232.4 539.9 221.6C539.9 148.4 480.5 93.6 411.9 93.6C398.1 93.6 384.8 95.6 371.5 100.3C348.5 77.8 316.7 63.4 281.9 63.4C219.9 63.4 168.2 107.4 156.5 165.8C99.2 180.6 62.3 234.4 62.3 289.2C62.3 325 77.7 359.9 105.3 384.9C102.7 395.7 101.2 406.4 101.2 417.2C101.2 490.4 160.6 545.2 229.2 545.2C243 545.2 256.3 543.2 269.6 538.5C292.6 561 324.4 575.4 359.2 575.4z" />
                                </svg>
                            </div>
                        @endunless

                        <div class="max-w-[75%] flex flex-col {{ $isUser ? 'items-end' : 'items-start' }}">
                            @if ($isJson && !$isUser)
                                <div dir="{{ $dir }}"
                                    class="rounded-lg rounded-bl-sm bg-white border border-brand-border overflow-hidden text-xs text-brand-ink w-full">
                                    @if (is_array($jsonData) && array_is_list($jsonData) && count($jsonData) > 0 && is_array($jsonData[0]))
                                        <div class="divide-y divide-brand-border">
                                            @foreach ($jsonData as $item)
                                                <div class="px-3.5 py-2.5 space-y-1 {{ $textAlign }}">
                                                    @foreach ($item as $key => $value)
                                                        <div
                                                            class="flex gap-1.5 flex-wrap {{ $isArabic ? 'flex-row-reverse' : '' }}">
                                                            <span
                                                                class="font-mono font-medium text-brand-primary capitalize shrink-0">{{ str_replace('_', ' ', $key) }}:</span>
                                                            <span
                                                                class="text-brand-muted break-words">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif (is_array($jsonData) && !array_is_list($jsonData))
                                        <div class="px-3.5 py-2.5 space-y-1 {{ $textAlign }}">
                                            @foreach ($jsonData as $key => $value)
                                                <div
                                                    class="flex gap-1.5 flex-wrap {{ $isArabic ? 'flex-row-reverse' : '' }}">
                                                    <span
                                                        class="font-mono font-medium text-brand-primary capitalize shrink-0">{{ str_replace('_', ' ', $key) }}:</span>
                                                    <span
                                                        class="text-brand-muted break-words">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <pre class="px-3.5 py-2.5 text-xs text-brand-muted whitespace-pre-wrap break-words font-mono {{ $textAlign }}">{{ json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @endif
                                    <div class="px-3.5 py-1 bg-brand-surface border-t border-brand-border">
                                        <span
                                            class="font-mono text-[10px] text-brand-muted tracking-wider uppercase">JSON</span>
                                    </div>
                                </div>
                            @else
                                <div dir="{{ $dir }}"
                                    class="px-3.5 py-2.5 rounded-lg leading-relaxed {{ $textAlign }} chatbot-md
                                    {{ $isUser ? 'bg-brand-primary text-white rounded-br-sm chatbot-md-user' : 'bg-white border border-brand-border text-brand-ink rounded-bl-sm' }}">
                                    {!! $markdownHtml !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Typing indicator --}}
                <div wire:loading wire:target="sendMessage" class="flex items-end gap-2">
                    <div class="w-7 h-7 rounded-full bg-brand-primary flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2" />
                        </svg>
                    </div>
                    <div
                        class="bg-white border border-brand-border rounded-lg rounded-bl-sm px-4 py-3 flex items-center gap-1.5">
                        <span class="block w-2 h-2 rounded-full bg-brand-primary animate-bounce"
                            style="animation-delay: 0ms"></span>
                        <span class="block w-2 h-2 rounded-full bg-brand-primary animate-bounce"
                            style="animation-delay: 150ms"></span>
                        <span class="block w-2 h-2 rounded-full bg-brand-primary animate-bounce"
                            style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>

            {{-- Input --}}
            <div class="px-3 py-3 bg-white border-t border-brand-border shrink-0">
                <div
                    class="flex items-center gap-2 bg-brand-surface border border-brand-border rounded-md px-3 py-1.5 focus-within:border-brand-primary focus-within:ring-2 focus-within:ring-brand-primary/10 transition">
                    <input type="text" wire:model="message" wire:keydown.enter="sendMessage"
                        placeholder="Ask me anything..."
                        class="flex-1 bg-transparent text-sm text-brand-ink placeholder-brand-muted focus:outline-none py-1.5 min-w-0 font-sans">
                    <button wire:click="sendMessage" wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="shrink-0 w-8 h-8 bg-brand-primary hover:bg-brand-primary-dark disabled:opacity-50 text-white rounded-md flex items-center justify-center transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-90" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
                <p class="text-center font-mono text-[10px] text-brand-muted mt-2 tracking-wide">Powered by AI · Job
                    Board Assistant</p>
            </div>
        </div>
    </div>
</div>
