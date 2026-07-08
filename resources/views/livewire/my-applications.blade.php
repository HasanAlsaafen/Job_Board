<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}"
>

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.seeker-sidebar', ['active' => 'myApplications'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.my_applications.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">
                {{ trans_choice('messages.my_applications.submitted', $applications->count(), ['count' => $applications->count()]) }}
            </p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        @php
            $statusStyles = [
                'Pending'               => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                'Assessment in Progress' => 'bg-brand-primary-light text-brand-primary border border-brand-primary/20',
                'Interview'             => 'bg-purple-50 text-purple-700 border border-purple-200',
                'Offer'                 => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'Not proceeding'        => 'bg-brand-surface text-brand-muted border border-brand-border',
                'Rejected'              => 'bg-red-50 text-red-700 border border-red-200',
                'Withdrawn'             => 'bg-orange-50 text-orange-700 border border-orange-200',
            ];
        @endphp

        @if($applications->isEmpty())
            <div class="bg-white border border-dashed border-brand-border rounded-lg p-12 text-center">
                <svg aria-hidden="true" class="mx-auto h-10 w-10 text-brand-muted/50 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="font-sans text-sm font-medium text-brand-ink">{{ __('messages.my_applications.empty') }}</p>
                <p class="font-sans text-sm text-brand-muted mt-1 mb-4">{{ __('messages.my_applications.empty_hint') }}</p>
                <a href="{{ route('openings') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark rounded-md transition">
                    {{ __('messages.my_applications.browse_openings') }}
                </a>
            </div>
        @else
            <div class="space-y-2">
                @foreach($applications as $application)
                    <div class="bg-white border border-brand-border rounded-lg p-5">

                        {{-- Header row --}}
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="min-w-0">
                                <h3 class="font-display font-semibold text-brand-ink leading-snug truncate">
                                    {{ $application->jobListing->title }}
                                </h3>
                                <p class="text-sm text-brand-primary mt-0.5">{{ $application->jobListing->company_name }}</p>
                            </div>
                            <span class="shrink-0 font-sans text-xs font-medium px-2.5 py-1 rounded bg-brand-surface-low border border-brand-border text-brand-muted">
                                {{ $application->jobListing->type }}
                            </span>
                        </div>

                        {{-- Cover letter --}}
                        @if($application->cover_letter)
                            <p class="text-sm text-brand-muted bg-brand-surface border border-brand-border rounded-md px-3 py-2 italic line-clamp-2 mb-3">
                                {{ $application->cover_letter }}
                            </p>
                        @endif

                        {{-- Withdraw notice / button --}}
                        @if ($application->status === 'Withdrawn')
                            <p class="font-mono text-xs text-orange-700 bg-orange-50 border border-orange-200 rounded-md px-3 py-2 mb-3">
                                {{ __('messages.my_applications.withdrawn') }}
                            </p>
                        @elseif (!in_array($application->status, ['Rejected', 'Not proceeding']))
                            <div class="mb-3">
                                <button
                                    wire:click="withdraw({{ $application->id }})"
                                    wire:confirm="{{ __('messages.my_applications.withdraw_confirm') }}"
                                    class="font-mono text-xs font-medium text-red-700 bg-red-50 border border-red-200 px-3 py-1.5 rounded hover:bg-red-100 transition">
                                    {{ __('messages.my_applications.withdraw') }}
                                </button>
                            </div>
                        @endif

                        {{-- Footer row --}}
                        <div class="flex items-center justify-between pt-3 border-t border-brand-border gap-3 flex-wrap">
                            <div class="flex items-center gap-2">
                                <span class="font-sans text-xs font-medium px-2.5 py-1 rounded {{ $statusStyles[$application->status] ?? 'bg-brand-surface text-brand-muted border border-brand-border' }}">
                                    {{ $application->translated_status }}
                                </span>
                                <span class="font-mono text-xs text-brand-muted">
                                    {{ __('messages.my_applications.applied') }} {{ $application->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded hover:bg-emerald-100 transition">
                                {{ __('messages.my_applications.resume') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
