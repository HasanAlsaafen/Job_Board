<div class="lg:ml-64 flex flex-col min-h-screen bg-brand-surface">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.admin-sidebar', ['active' => 'dashboard'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">Admin Dashboard</h1>
            <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">Platform overview</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8 space-y-6">

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
            @php
                $stats = [
                    [
                        'label' => 'Total Users',
                        'value' => $userCount,
                        'icon' =>
                            'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    ],
                    [
                        'label' => 'Employers',
                        'value' => $employerCount,
                        'icon' =>
                            'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    ],
                    [
                        'label' => 'Job Seekers',
                        'value' => $seekerCount,
                        'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    ],
                    [
                        'label' => 'Job Listings',
                        'value' => $jobCount,
                        'icon' =>
                            'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                    ],
                    [
                        'label' => 'Applications',
                        'value' => $applicationCount,
                        'icon' =>
                            'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    ],
                    [
                        'label' => 'Tags',
                        'value' => $tagCount,
                        'icon' =>
                            'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
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

        <div class="grid lg:grid-cols-2 gap-6">

            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                <div class="px-5 py-3.5 border-b border-brand-border flex items-center justify-between">
                    <h2 class="font-display text-sm font-semibold text-brand-ink">Recent Job Listings</h2>
                    <a href="{{ route('admin.jobs') }}"
                        class="font-mono text-xs text-brand-primary hover:text-brand-primary-dark transition">View
                        all</a>
                </div>
                <div class="divide-y divide-brand-border">
                    @forelse ($recentJobs as $job)
                        <div class="px-5 py-3 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-brand-ink truncate">{{ $job->title }}</p>
                                <p class="font-mono text-xs text-brand-muted">{{ $job->company_name }}</p>
                            </div>
                            <span
                                class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-0.5 rounded border shrink-0
                                {{ $job->type === 'Full-time' ? 'bg-brand-primary-light text-brand-primary border-brand-primary/20' : ($job->type === 'Part-time' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                                {{ $job->type }}
                            </span>
                        </div>
                    @empty
                        <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">No jobs yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent  --}}
            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                <div class="px-5 py-3.5 border-b border-brand-border flex items-center justify-between">
                    <h2 class="font-display text-sm font-semibold text-brand-ink">Recent Applications</h2>
                    <a href="{{ route('admin.applications') }}"
                        class="font-mono text-xs text-brand-primary hover:text-brand-primary-dark transition">View
                        all</a>
                </div>
                <div class="divide-y divide-brand-border">
                    @forelse ($recentApps as $app)
                        <div class="px-5 py-3 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-brand-ink truncate">{{ $app->user->name ?? '—' }}</p>
                                <p class="font-mono text-xs text-brand-muted truncate">
                                    {{ $app->jobListing->title ?? '—' }}</p>
                            </div>
                            @php
                                $statusColor = match ($app->status) {
                                    'Pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Offer' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Rejected', 'Not proceeding' => 'bg-red-50 text-red-700 border-red-200',
                                    'Withdrawn' => 'bg-gray-100 text-gray-500 border-gray-200',
                                    default => 'bg-brand-primary-light text-brand-primary border-brand-primary/20',
                                };
                            @endphp
                            <span
                                class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-0.5 rounded border shrink-0 {{ $statusColor }}">
                                {{ $app->status }}
                            </span>
                        </div>
                    @empty
                        <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">No applications yet.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
