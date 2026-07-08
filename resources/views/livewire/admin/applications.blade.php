<div class="lg:ml-64 flex flex-col min-h-screen bg-brand-surface">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.admin-sidebar', ['active' => 'applications'])

        <header
            class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6 flex items-center justify-between gap-4 flex-wrap">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 shrink-0 rounded-md bg-brand-primary-light flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-brand-primary" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-display text-lg font-semibold text-brand-ink">Applications</h1>
                    <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">All job applications across the
                        platform</p>
                </div>
            </div>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
            {{ $this->table }}
        </div>
    </div>
</div>
