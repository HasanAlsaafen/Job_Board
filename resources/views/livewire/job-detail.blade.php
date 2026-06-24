@assets
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endassets

<div class="flex flex-col min-h-screen bg-gray-50" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
    @auth
        @include('livewire.partials.seeker-sidebar', ['active' => 'openings'])
    @endauth

    @php
        $marginExpanded  = auth()->check() ? (app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64') : '';
        $marginCollapsed = auth()->check() ? (app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16') : '';
    @endphp
    <div
        x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
        @sidebar-toggle.window="collapsed = $event.detail.collapsed"
        :class="collapsed ? '{{ $marginCollapsed }}' : '{{ $marginExpanded }}'"
        class="max-w-3xl mx-auto w-full px-4 lg:px-8 py-6 pt-16 lg:pt-8"
    >

        <a href="{{ route('openings') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition mb-6 group">
            <svg class="h-4 w-4 transition group-hover:-translate-x-0.5 {{ app()->isLocale('ar') ? 'rotate-180' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('messages.jobs.back') }}
        </a>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm mb-4">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg select-none">
                        {{ mb_strtoupper(mb_substr($job->company_name, 0, 1)) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div>
                                <h1 class="text-xl font-bold text-gray-900 leading-snug">{{ $job->title }}</h1>
                                <p class="text-blue-600 font-medium text-sm mt-0.5">{{ $job->company_name }}</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $job->type }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 mt-5 pt-4 border-t border-gray-100">
                    @if ($job->location)
                        <span class="inline-flex items-center gap-1.5 text-xs text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-2.5 py-1.5">
                            <svg class="h-3.5 w-3.5 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $job->location }}
                        </span>
                    @endif

                    @if ($job->salary_range)
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-lg px-2.5 py-1.5">
                            <svg class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $job->salary_range }}
                        </span>
                    @endif

                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                        <svg class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('messages.jobs.posted_at', ['date' => $job->created_at->diffForHumans()]) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm mb-4">
            <div class="p-6">
                <h2 class="text-base font-semibold text-gray-900 mb-3">{{ __('messages.jobs.description') }}</h2>
                <p class="text-gray-600 text-sm leading-7 whitespace-pre-line">{{ $job->description }}</p>
            </div>

            @if ($job->requirements)
                <div class="border-t border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-3">{{ __('messages.jobs.requirements') }}</h2>
                    <p class="text-gray-600 text-sm leading-7 whitespace-pre-line">{{ $job->requirements }}</p>
                </div>
            @endif
        </div>

        @if($job->latitude && $job->longitude)
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm mb-4 overflow-hidden">
                <div class="px-6 pt-5 pb-3">
                    <h2 class="text-base font-semibold text-gray-900">{{ __('messages.jobs.location') }}</h2>
                </div>
                <div
                    wire:ignore
                    x-data="{
                        initMap() {
                            const map = L.map('job-map').setView([{{ $job->latitude }}, {{ $job->longitude }}], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap'
                            }).addTo(map);
                            L.marker([{{ $job->latitude }}, {{ $job->longitude }}])
                                .addTo(map)
                                .bindPopup('<strong>{{ addslashes($job->title) }}</strong><br>{{ addslashes($job->company_name) }}')
                                .openPopup();
                        }
                    }"
                    x-init="initMap()"
                >
                    <div id="job-map" style="height: 280px; width: 100%;"></div>
                </div>
            </div>
        @endif

        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
            @auth
                @if ($alreadyApplied)
                    <div class="flex items-center gap-3 text-green-700 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                        <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold">{{ __('messages.jobs.applied') }}</span>
                    </div>
                @else
                    @livewire('apply-modal', ['jobId' => $job->id], key($job->id))

                @endif
            @else
                <p class="text-sm text-gray-500 mb-4 text-center">{{ __('messages.apply_modal.login_to_apply') }}</p>
                <a href="{{ route('login') }}"
                   class="block w-full text-center text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 px-4 py-2.5 rounded-xl transition shadow-sm">
                    {{ __('messages.jobs.login_to_apply') }}
                </a>
            @endauth
        </div>

    </div>
</div>
