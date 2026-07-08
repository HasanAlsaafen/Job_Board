<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}"
>

    @include('livewire.partials.seeker-sidebar', ['active' => 'savedJobs'])

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.saved_jobs.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">
                {{ trans_choice('messages.saved_jobs.count', $jobs->count(), ['count' => $jobs->count()]) }}
            </p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">

        @if($jobs->isEmpty())
            <div class="bg-white border border-dashed border-brand-border rounded-lg p-12 text-center">
                <svg aria-hidden="true" class="mx-auto h-10 w-10 text-brand-muted/50 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z" />
                </svg>
                <p class="font-sans text-sm font-medium text-brand-ink">{{ __('messages.saved_jobs.empty') }}</p>
                <p class="font-sans text-sm text-brand-muted mt-1 mb-4">{{ __('messages.saved_jobs.empty_hint') }}</p>
                <a href="{{ route('openings') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark rounded-md transition">
                    {{ __('messages.saved_jobs.browse_openings') }}
                </a>
            </div>
        @else
            <div class="space-y-2">
                @foreach($jobs as $job)
                    <div class="bg-white border border-brand-border rounded-lg hover:border-brand-primary transition duration-150">
                        <div class="px-5 py-4">

                            {{-- Header row --}}
                            <div class="flex justify-between items-start gap-3 mb-2">
                                <div class="min-w-0">
                                    <h3 class="font-display text-base font-semibold text-brand-ink leading-snug truncate">{{ $job->title }}</h3>
                                    <p class="text-brand-primary text-sm font-medium mt-0.5">{{ $job->company_name }}</p>
                                </div>
                                <span class="shrink-0 font-sans text-xs font-medium px-2.5 py-1 rounded bg-brand-surface-low border border-brand-border text-brand-muted">
                                    {{ $job->type }}
                                </span>
                            </div>

                            <p class="text-brand-muted text-sm leading-relaxed line-clamp-2 mb-3">{{ $job->description }}</p>

                            {{-- Tags --}}
                            @if($job->tags?->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    @foreach($job->tags as $tag)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold"
                                            style="color: {{ $tag->color }}; background-color: {{ $tag->bg }};">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Footer row --}}
                            <div class="flex flex-wrap items-center justify-between pt-3 border-t border-brand-border gap-2">

                                <div class="flex items-center gap-3">
                                    @if($job->location)
                                        <span class="inline-flex items-center gap-1 font-sans text-xs text-brand-muted">
                                            <svg aria-hidden="true" class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $job->location }}
                                        </span>
                                    @endif
                                    @if($job->salary_range)
                                        <span class="font-sans text-xs font-semibold text-emerald-700">{{ $job->salary_range }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <button wire:click="unsaveJob({{ $job->id }})"
                                        class="inline-flex items-center gap-1.5 font-sans text-sm font-medium text-brand-primary bg-brand-primary-light border border-brand-primary/20 px-3 py-2 rounded hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition min-h-[36px]">
                                        <svg aria-hidden="true" class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        {{ __('messages.saved_jobs.unsave') }}
                                    </button>
                                    <a href="{{ route('jobs.show', $job) }}"
                                       class="font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark px-4 py-2 rounded transition min-h-[36px] inline-flex items-center">
                                        {{ __('messages.jobs_feed.view_details') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

</div>
