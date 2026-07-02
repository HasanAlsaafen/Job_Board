@assets
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endassets

<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'dashboard'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.employer_dashboard.title') }}
            </h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.employer_dashboard.subtitle') }}</p>
        </header>
    </div>

    <div class="flex  flex-col px-4 lg:px-8 pb-8 space-y-6">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @php
                $stats = [
                    [
                        'label' => __('messages.employer_dashboard.stat_active_jobs'),
                        'value' => $activeJobsCount,
                        'icon' =>
                            'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    ],
                    [
                        'label' => __('messages.employer_dashboard.stat_total_jobs'),
                        'value' => $totalJobsCount,
                        'icon' =>
                            'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    ],
                    [
                        'label' => __('messages.employer_dashboard.stat_total_applicants'),
                        'value' => $totalApplicantsCount,
                        'icon' =>
                            'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                    ],
                    [
                        'label' => __('messages.employer_dashboard.stat_pending'),
                        'value' => $pendingApplicantsCount,
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    ],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-white border border-brand-border rounded-lg p-4 flex items-center gap-4">
                    <div class="w-9 h-9 shrink-0 rounded-md bg-brand-primary-light flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-brand-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-mono text-xs text-brand-muted tracking-wide">{{ $stat['label'] }}</p>
                        <p class="font-display text-xl font-semibold text-brand-ink">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white border border-brand-border rounded-lg overflow-hidden max-w-2xl">
            <div class="px-5 py-3.5 border-b border-brand-border flex items-center justify-between">
                <h2 class="font-display text-sm font-semibold text-brand-ink">
                    {{ __('messages.employer_dashboard.recent_applicants_title') }}</h2>
                <a href="{{ route('employer.applicants') }}"
                    class="font-mono text-xs text-brand-primary hover:text-brand-primary-dark transition">{{ __('messages.employer_dashboard.view_all') }}</a>
            </div>
            <div class="divide-y divide-brand-border">
                @php
                    $statusStyles = [
                        'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'Assessment in Progress' => 'bg-brand-primary-light text-brand-primary border-brand-primary/20',
                        'Interview' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'Offer' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Not proceeding' => 'bg-brand-surface text-brand-muted border-brand-border',
                        'Rejected' => 'bg-red-50 text-red-700 border-red-200',
                    ];
                @endphp
                @forelse ($recentApplicants as $applicant)
                    <div class="px-5 py-3 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-brand-ink truncate">{{ $applicant->user->name ?? '—' }}
                            </p>
                            <p class="font-mono text-xs text-brand-muted truncate">
                                {{ $applicant->jobListing->title ?? '—' }}</p>
                        </div>
                        <span
                            class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-0.5 rounded border shrink-0 {{ $statusStyles[$applicant->status] ?? 'bg-brand-surface text-brand-muted border-brand-border' }}">
                            {{ $applicant->translated_status }}
                        </span>
                    </div>
                @empty
                    <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">
                        {{ __('messages.employer_dashboard.no_applicants') }}</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-brand-border rounded-lg p-6 max-w-2xl">
            <h2 class="font-display text-base font-semibold text-brand-ink mb-5">
                {{ __('messages.employer_dashboard.section_title') }}
            </h2>

            @if ($successMessage)
                <div
                    class="flex items-center justify-between gap-3 p-3 mb-5 font-sans text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md">
                    <div class="flex items-center gap-2">
                        <svg aria-hidden="true" class="h-4 w-4 shrink-0 text-emerald-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ $successMessage }}
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="createJob" class="space-y-5 text-sm">

                <div>
                    <label for="job-title"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.job_title') }}</label>
                    <input id="job-title" type="text" wire:model="title"
                        placeholder="{{ __('messages.job_form.job_title_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    @error('title')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="job-company"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.company_name') }}</label>
                    <input id="job-company" type="text" wire:model="company_name"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    @error('company_name')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="job-location"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.location') }}</label>
                    <input id="job-location" type="text" wire:model="location"
                        placeholder="{{ __('messages.job_form.location_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    @error('location')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tags --}}
                <div class="space-y-2">
                    <label class="block font-medium text-brand-ink">{{ __('messages.job_form.tags') }}</label>

                    <div
                        class="flex flex-wrap gap-2 p-3 bg-brand-surface border border-brand-border rounded-md min-h-[48px]">
                        @php $availableTags = $tags->filter(fn($t) => !in_array($t->id, $selectedTagIds)); @endphp
                        @forelse ($availableTags as $tag)
                            <label class="cursor-pointer select-none">
                                <input type="checkbox" wire:model.live="selectedTagIds" value="{{ $tag->id }}"
                                    class="sr-only">
                                <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                    class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold opacity-60 hover:opacity-100 transition-all duration-150">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @empty
                            <span
                                class="font-sans text-xs text-brand-muted self-center italic">{{ __('messages.job_form.all_tags_selected') }}</span>
                        @endforelse
                    </div>

                    @if (count($selectedTagIds) > 0)
                        <div class="p-3 border border-brand-primary/20 bg-brand-primary-light rounded-md">
                            <p class="font-sans text-xs text-brand-primary mb-2">
                                {{ trans_choice('messages.job_form.tags_selected', count($selectedTagIds), ['count' => count($selectedTagIds)]) }}
                            </p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($tags->whereIn('id', $selectedTagIds) as $tag)
                                    <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-semibold">
                                        {{ $tag->name }}
                                        <button type="button" wire:click="removeTag({{ $tag->id }})"
                                            :aria-label="'{{ __('messages.job_form.remove_tag') }} ' + '{{ $tag->name }}'"
                                            class="opacity-60 hover:opacity-100 transition-opacity leading-none">
                                            <svg aria-hidden="true" class="w-3 h-3 shrink-0" fill="none"
                                                stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <label for="job-type"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.employment_type') }}</label>
                    <select id="job-type" wire:model="type"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                        <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                        <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                        <option value="Contract">{{ __('messages.job_form.contract') }}</option>
                    </select>
                </div>

                <div>
                    <label for="job-salary"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.salary_range') }}</label>
                    <input id="job-salary" type="text" wire:model="salary_range"
                        placeholder="{{ __('messages.job_form.salary_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                </div>

                <div>
                    <label for="job-expires"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.expires_at') }}</label>
                    <input id="job-expires" type="date" wire:model="expires_at"
                        min="{{ now()->addDay()->toDateString() }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    @error('expires_at')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="job-description"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.description') }}</label>
                    <textarea id="job-description" wire:model="description" rows="4"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition resize-none"></textarea>
                    @error('description')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="job-requirements"
                        class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.requirements') }}</label>
                    <textarea id="job-requirements" wire:model="requirements" rows="3"
                        placeholder="{{ __('messages.job_form.requirements_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition resize-none"></textarea>
                    @error('requirements')
                        <span class="font-sans text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Map picker — separated to avoid disrupting form flow --}}
                <div class="border-t border-brand-border pt-5">
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.map.click') }}</label>
                    <p class="font-sans text-xs text-brand-muted mb-2">{{ __('messages.map.optional_hint') }}</p>
                    <div wire:ignore x-data="{
                        map: null,
                        marker: null,
                        initMap() {
                            const initLat = $wire.get('latitude') || 33.5138;
                            const initLng = $wire.get('longitude') || 36.2765;
                            this.map = L.map('map-picker').setView([initLat, initLng], 8);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(this.map);
                            if ($wire.get('latitude') && $wire.get('longitude')) {
                                this.marker = L.marker([initLat, initLng]).addTo(this.map);
                            }
                            this.map.on('click', (e) => {
                                const { lat, lng } = e.latlng;
                                if (this.marker) {
                                    this.marker.setLatLng([lat, lng]);
                                } else {
                                    this.marker = L.marker([lat, lng]).addTo(this.map);
                                }
                                $wire.set('latitude', lat);
                                $wire.set('longitude', lng);
                            });
                        }
                    }" x-init="initMap()"
                        class="rounded-md overflow-hidden border border-brand-border">
                        <div id="map-picker" class="h-64 w-full"></div>
                    </div>
                    @if ($latitude && $longitude)
                        <p class="font-sans text-xs text-brand-muted mt-1.5">
                            {{ __('messages.map.location_set', ['lat' => round($latitude, 4), 'lng' => round($longitude, 4)]) }}
                        </p>
                    @endif
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-brand-primary hover:bg-brand-primary-dark disabled:opacity-60 text-white font-medium py-2.5 rounded-md transition flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="createJob" aria-hidden="true" class="size-4 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                        </path>
                    </svg>
                    {{ __('messages.employer_dashboard.publish_button') }}
                </button>
            </form>
        </div>
    </div>

</div>
