<div class="lg:ml-64 flex flex-col min-h-screen bg-brand-surface">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.admin-sidebar', ['active' => 'dashboard'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">Admin Dashboard</h1>
            <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">Platform overview</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8 space-y-6">

        <livewire:stats-overview />

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
                                <p class="text-sm font-medium text-brand-ink truncate">{{ $app->user->name ?? '—' }}
                                </p>
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
                        <p class="px-5 py-6 font-mono text-xs text-brand-muted italic text-center">No applications
                            yet.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
