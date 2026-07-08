<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    @include('livewire.partials.seeker-sidebar', ['active' => 'dashboard'])

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">
                {{ __('messages.seeker_dashboard.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.seeker_dashboard.subtitle') }}</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8 space-y-6">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                @php
                    $stats = [
                        [
                            'label' => __('messages.seeker_dashboard.stat_applications'),
                            'value' => $applicationsCount,
                            'icon' =>
                                'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                        ],
                        [
                            'label' => __('messages.seeker_dashboard.stat_saved_jobs'),
                            'value' => $savedJobsCount,
                            'icon' => 'M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z',
                        ],
                        [
                            'label' => __('messages.seeker_dashboard.stat_interviews'),
                            'value' => $interviewCount,
                            'icon' =>
                                'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                        ],
                        [
                            'label' => __('messages.seeker_dashboard.stat_offers'),
                            'value' => $offerCount,
                            'icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
                        ],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="bg-white border border-brand-border rounded-lg p-4 flex items-center gap-4">
                        <div
                            class="w-9 h-9 shrink-0 rounded-md bg-brand-primary-light flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-brand-primary"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

            <div class="grid lg:grid-cols-2 gap-6">

                {{-- Recent applications --}}
                <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-brand-border flex items-center justify-between">
                        <h2 class="font-display text-sm font-semibold text-brand-ink">
                            {{ __('messages.seeker_dashboard.recent_applications_title') }}</h2>
                        <a href="{{ route('seeker.applications') }}"
                            class="font-mono text-xs text-brand-primary hover:text-brand-primary-dark transition">{{ __('messages.seeker_dashboard.view_all') }}</a>
                    </div>
                    <div class="divide-y divide-brand-border">
                        @php
                            $statusStyles = [
                                'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                'Assessment in Progress' =>
                                    'bg-brand-primary-light text-brand-primary border-brand-primary/20',
                                'Interview' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'Offer' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Not proceeding' => 'bg-brand-surface text-brand-muted border-brand-border',
                                'Rejected' => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp
                        @forelse ($recentApplications as $application)
                            <div class="px-5 py-3 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-brand-ink truncate">
                                        {{ $application->jobListing->title ?? '—' }}</p>
                                    <p class="font-mono text-xs text-brand-muted truncate">
                                        {{ $application->jobListing->company_name ?? '—' }}</p>
                                </div>
                                <span
                                    class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-0.5 rounded border shrink-0 {{ $statusStyles[$application->status] ?? 'bg-brand-surface text-brand-muted border-brand-border' }}">
                                    {{ $application->translated_status }}
                                </span>
                            </div>
                        @empty
                            <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">
                                {{ __('messages.seeker_dashboard.no_applications') }}</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recommended openings --}}
                <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-brand-border flex items-center justify-between">
                        <h2 class="font-display text-sm font-semibold text-brand-ink">
                            {{ __('messages.seeker_dashboard.recommended_jobs_title') }}</h2>
                        <a href="{{ route('openings') }}"
                            class="font-mono text-xs text-brand-primary hover:text-brand-primary-dark transition">{{ __('messages.seeker_dashboard.view_all') }}</a>
                    </div>
                    <div class="divide-y divide-brand-border">
                        @forelse ($recommendedJobs as $job)
                            <a href="{{ route('jobs.show', $job) }}"
                                class="px-5 py-3 flex items-center justify-between gap-4 hover:bg-brand-surface-low transition">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-brand-ink truncate">{{ $job->title }}</p>
                                    <p class="font-mono text-xs text-brand-muted truncate">{{ $job->company_name }}</p>
                                </div>
                                <span
                                    class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-0.5 rounded border shrink-0
                                {{ $job->type === 'Full-time' ? 'bg-brand-primary-light text-brand-primary border-brand-primary/20' : ($job->type === 'Part-time' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                                    {{ $job->type }}
                                </span>
                            </a>
                        @empty
                            <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">
                                {{ __('messages.seeker_dashboard.no_recommendations') }}</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
