@php
    $marginExpanded  = auth()->check() ? (app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64') : '';
    $marginCollapsed = auth()->check() ? (app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16') : '';
@endphp
<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ $marginCollapsed }}' : '{{ $marginExpanded }}'"
    class="flex flex-col min-h-screen bg-brand-surface text-brand-ink" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    @auth
        @include('livewire.partials.seeker-sidebar', ['active' => 'openings'])
    @endauth

    <div class="max-w-4xl mx-auto w-full px-4 lg:px-8 py-6 pt-16 lg:pt-8">

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.jobs_feed.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.jobs_feed.subtitle') }}</p>
        </header>

        <div class="bg-white border border-brand-border rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <svg aria-hidden="true" class="absolute {{ app()->isLocale('ar') ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 h-4 w-4 text-brand-muted pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('messages.jobs_feed.search_placeholder') }}"
                        class="w-full {{ app()->isLocale('ar') ? 'pr-9 pl-4' : 'pl-9 pr-4' }} py-2.5 border border-brand-border rounded-md text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                </div>

                <select wire:model.live="selectedTag"
                    class="w-full md:w-44 border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    <option value="">{{ __('messages.jobs_feed.all_tags') }}</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="selectedType"
                    class="w-full md:w-40 border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                    <option value="">{{ __('messages.jobs_feed.all_types') }}</option>
                    <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                    <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                    <option value="Contract">{{ __('messages.job_form.contract') }}</option>
                </select>
            </div>
        </div>

        @if ($jobs->isEmpty())
            <div class="text-center py-16 bg-white border border-brand-border rounded-lg">
                <svg aria-hidden="true" class="mx-auto h-10 w-10 text-brand-muted/50 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="font-sans text-sm font-medium text-brand-ink">{{ __('messages.jobs_feed.no_results') }}</p>
                <p class="font-sans text-sm text-brand-muted mt-1">{{ __('messages.jobs_feed.no_results_hint') }}</p>
            </div>
        @endif

        <div class="space-y-2">
            @foreach ($jobs as $job)
                <div class="bg-white border border-brand-border rounded-lg hover:border-brand-primary transition duration-150 group">
                    <div class="px-5 py-4">
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

                        @if ($job->tags?->isNotEmpty())
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                @foreach ($job->tags as $tag)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold"
                                        style="color: {{ $tag->color }}; background-color: {{ $tag->bg }};">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center justify-between pt-3 border-t border-brand-border gap-2">
                            <div class="flex items-center gap-3">
                                @if ($job->location)
                                    <span class="inline-flex items-center gap-1 font-sans text-xs text-brand-muted">
                                        <svg aria-hidden="true" class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif
                                @if ($job->salary_range)
                                    <span class="font-sans text-xs font-semibold text-emerald-700">{{ $job->salary_range }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                @auth
                                    @if ($job->saved_by_users_exists)
                                        <button wire:click="unsaveJob({{ $job->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 font-sans text-xs font-medium text-brand-primary bg-brand-primary-light border border-brand-primary/20 rounded hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition min-h-[36px]">
                                            <svg aria-hidden="true" class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z" />
                                            </svg>
                                            {{ __('messages.jobs_feed.saved') }}
                                        </button>
                                    @else
                                        <button wire:click="saveJob({{ $job->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 font-sans text-xs font-medium text-brand-muted bg-white border border-brand-border rounded hover:text-brand-primary hover:border-brand-primary hover:bg-brand-primary-light transition min-h-[36px]">
                                            <svg aria-hidden="true" class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z" />
                                            </svg>
                                            {{ __('messages.jobs_feed.save') }}
                                        </button>
                                    @endif
                                @endauth

                                <span class="font-sans text-xs text-brand-muted">{{ $job->created_at->diffForHumans() }}</span>

                                <a href="{{ route('jobs.show', $job) }}"
                                    class="px-4 py-2 font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark rounded transition min-h-[36px] inline-flex items-center">
                                    {{ __('messages.jobs_feed.view_details') }}
                                </a>

                                <span class="inline-flex items-center gap-1 font-sans text-xs text-brand-muted">
                                    <svg aria-hidden="true" class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $job->count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($jobs->hasPages())
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @endif

    </div>

</div>
