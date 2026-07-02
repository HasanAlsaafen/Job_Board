<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'applicants'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.applicants.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.applicants.subtitle') }}</p>
        </header>
    </div>

    <div class="space-y-4 px-4 lg:px-8 pb-8">
        @if ($myJobs->isEmpty())
            <div class="bg-white border border-dashed border-brand-border rounded-lg p-10 text-center">
                <p class="font-sans text-sm font-medium text-brand-ink">{{ __('messages.applicants.empty') }}</p>
            </div>
        @endif

        @foreach ($myJobs as $job)
            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">

                <div class="flex justify-between items-center px-5 py-4 border-b border-brand-border">
                    <div>
                        <h3 class="font-display font-semibold text-brand-ink">{{ $job->title }}</h3>
                        <span
                            class="font-sans text-xs font-medium px-2 py-0.5 rounded bg-brand-surface-low border border-brand-border text-brand-muted mt-1 inline-block">
                            {{ $job->type }}
                        </span>
                    </div>
                    <span
                        class="font-sans text-xs font-medium text-brand-primary bg-brand-primary-light border border-brand-primary/20 px-3 py-1.5 rounded">
                        {{ trans_choice('messages.applicants.submissions', $job->applications->count(), ['count' => $job->applications->count()]) }}
                    </span>
                </div>

                @php
                    $statusStyles = [
                        'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'Assessment in Progress' =>
                            'bg-brand-primary-light text-brand-primary border border-brand-primary/20',
                        'Interview' => 'bg-purple-50 text-purple-700 border-purple-200',
                        'Offer' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'Not proceeding' => 'bg-brand-surface text-brand-muted border border-brand-border',
                        'Rejected' => 'bg-red-50 text-red-700 border-red-200',
                    ];
                @endphp

                <div class="divide-y divide-brand-border">
                    @foreach ($job->applications as $application)
                        <div
                            class="px-5 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-brand-ink text-sm">
                                    {{ $application->user->name }}
                                    <span
                                        class="font-mono text-xs font-normal text-brand-muted">({{ $application->user->email }})</span>
                                </p>
                                <p
                                    class="font-mono text-xs text-brand-muted mt-1.5 bg-brand-surface border border-brand-border rounded-md px-3 py-2 italic leading-relaxed">
                                    {{ $application->cover_letter ?? __('messages.applicants.no_cover_letter') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <select wire:change="updateStatus({{ $application->id }}, $event.target.value)"
                                    class="font-sans text-xs font-medium border px-2.5 py-1.5 rounded cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-primary/60 transition {{ $statusStyles[$application->status] ?? 'bg-brand-surface text-brand-muted border-brand-border' }}"
                                    x-data x-on:change="$el.className = $el.className">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ $application->status === $status ? 'selected' : '' }}>
                                            {{ \App\Models\Applications::statusLabel($status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <a href="{{ asset("storage/{$application->resume_path}") }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded hover:bg-emerald-100 transition">
                                    {{ __('messages.applicants.resume') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach
    </div>

</div>
