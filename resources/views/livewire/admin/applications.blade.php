<div class="lg:ml-64 flex flex-col min-h-screen bg-brand-surface">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.admin-sidebar', ['active' => 'applications'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6 flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="font-display text-lg font-semibold text-brand-ink">Applications</h1>
                <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">All job applications across the platform</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search applicant or job…"
                    class="border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition w-56">
                <select wire:model.live="statusFilter"
                    class="border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                    <option value="">All statuses</option>
                    @foreach (\App\Livewire\Admin\AdminApplications::STATUSES as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-brand-border bg-brand-surface-low">
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Applicant</th>
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Job</th>
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Status</th>
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Applied</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-border">
                        @forelse ($applications as $app)
                            @php
                                $statusColor = match($app->status) {
                                    'Pending'               => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Offer'                 => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Rejected','Not proceeding' => 'bg-red-50 text-red-700 border-red-200',
                                    'Withdrawn'             => 'bg-gray-100 text-gray-500 border-gray-200',
                                    'Interview'             => 'bg-blue-50 text-blue-700 border-blue-200',
                                    default                 => 'bg-brand-primary-light text-brand-primary border-brand-primary/20',
                                };
                            @endphp
                            <tr class="hover:bg-brand-surface-low transition" wire:key="app-{{ $app->id }}">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-brand-ink">{{ $app->user->name ?? '—' }}</p>
                                    <p class="font-mono text-xs text-brand-muted">{{ $app->user->email ?? '' }}</p>
                                </td>
                                <td class="px-4 py-3 text-brand-muted max-w-[200px] truncate">{{ $app->jobListing->title ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-sans text-xs font-semibold tracking-wider uppercase px-2 py-0.5 rounded border {{ $statusColor }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-mono text-xs text-brand-muted">{{ $app->created_at->diffForHumans() }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="editApplication({{ $app->id }})"
                                        class="inline-flex items-center gap-1 font-mono text-xs font-medium text-brand-muted hover:text-brand-primary hover:bg-brand-primary-light px-2.5 py-1.5 rounded border border-transparent hover:border-brand-primary/20 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                        Status
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center font-mono text-xs text-brand-muted italic">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($applications->hasPages())
                <div class="px-4 py-3 border-t border-brand-border">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Edit Status Modal --}}
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div class="bg-white border border-brand-border rounded-lg w-full max-w-sm p-6" @click.stop>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-display text-base font-semibold text-brand-ink">Update Status</h2>
                    <button wire:click="cancelEdit" class="text-brand-muted hover:text-brand-ink transition p-1 rounded hover:bg-brand-surface-low">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @if ($successMessage)
                    <div class="p-3 mb-4 font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md">
                        {{ $successMessage }}
                    </div>
                @endif

                <form wire:submit.prevent="updateApplication" class="space-y-4 text-sm">
                    <div>
                        <label class="block font-medium text-brand-ink mb-1.5">Status</label>
                        <select wire:model="editStatus"
                            class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                            @foreach (\App\Livewire\Admin\AdminApplications::STATUSES as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('editStatus') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-2 pt-2 border-t border-brand-border">
                        <button type="submit"
                            class="flex-1 bg-brand-primary hover:bg-brand-primary-dark text-white font-medium py-2.5 rounded-md transition">
                            Save
                        </button>
                        <button type="button" wire:click="cancelEdit"
                            class="flex-1 border border-brand-border text-brand-muted hover:bg-brand-surface-low font-medium py-2.5 rounded-md transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
