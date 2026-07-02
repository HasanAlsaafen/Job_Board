<div class="lg:ml-64 flex flex-col min-h-screen bg-brand-surface">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.admin-sidebar', ['active' => 'tags'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">Tags</h1>
            <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">Create and manage job tags</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8 space-y-6">

        {{-- Create form --}}
        <div class="bg-white border border-brand-border rounded-lg p-6">
            <h2 class="font-display text-sm font-semibold text-brand-ink mb-4">New Tag</h2>

            @if ($successMessage)
                <div class="p-3 mb-4 font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="createTag" class="space-y-4 text-sm">
                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">Tag Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Python"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                    @error('name') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block font-medium text-brand-ink mb-1.5">Text Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" wire:model.live="color"
                                class="h-9 w-14 rounded border border-brand-border cursor-pointer p-0.5">
                            <span class="font-mono text-xs text-brand-muted">{{ $color }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block font-medium text-brand-ink mb-1.5">Background</label>
                        <div class="flex items-center gap-2">
                            <input type="color" wire:model.live="bg"
                                class="h-9 w-14 rounded border border-brand-border cursor-pointer p-0.5">
                            <span class="font-mono text-xs text-brand-muted">{{ $bg }}</span>
                        </div>
                    </div>
                </div>

                @if ($name)
                    <div>
                        <label class="block font-medium text-brand-ink mb-1.5">Preview</label>
                        <span style="color: {{ $color }}; background-color: {{ $bg }}"
                            class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold">
                            {{ $name }}
                        </span>
                    </div>
                @endif

                <button type="submit"
                    class="bg-brand-primary hover:bg-brand-primary-dark text-white font-medium px-5 py-2 rounded-md transition text-sm">
                    Create Tag
                </button>
            </form>
        </div>

        {{-- Tags table --}}
        <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
            <div class="px-5 py-3.5 border-b border-brand-border">
                <h2 class="font-display text-sm font-semibold text-brand-ink">All Tags</h2>
            </div>
            @if ($tags->isEmpty())
                <p class="px-5 py-8 font-mono text-xs text-brand-muted italic text-center">No tags yet.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-brand-border bg-brand-surface-low">
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Tag</th>
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Colors</th>
                            <th class="text-left px-4 py-3 font-mono text-xs font-semibold text-brand-muted tracking-wider uppercase">Jobs</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-border">
                        @foreach ($tags as $tag)
                            <tr class="hover:bg-brand-surface-low transition" wire:key="tag-{{ $tag->id }}">
                                <td class="px-4 py-3">
                                    <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                        class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold">
                                        {{ $tag->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 font-mono text-xs text-brand-muted">
                                            <span class="w-3.5 h-3.5 rounded-sm border border-brand-border shrink-0" style="background-color: {{ $tag->color }}"></span>
                                            {{ $tag->color }}
                                        </span>
                                        <span class="text-brand-muted/40">/</span>
                                        <span class="inline-flex items-center gap-1.5 font-mono text-xs text-brand-muted">
                                            <span class="w-3.5 h-3.5 rounded-sm border border-brand-border shrink-0" style="background-color: {{ $tag->bg }}"></span>
                                            {{ $tag->bg }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-mono text-xs text-brand-muted">{{ $tag->job_listings_count }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="editTag({{ $tag->id }})"
                                            class="inline-flex items-center gap-1 font-mono text-xs font-medium text-brand-muted hover:text-brand-primary hover:bg-brand-primary-light px-2.5 py-1.5 rounded border border-transparent hover:border-brand-primary/20 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="deleteTag({{ $tag->id }})"
                                            wire:confirm="Delete '{{ $tag->name }}'? It will be removed from all jobs."
                                            class="inline-flex items-center gap-1 font-mono text-xs font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 px-2.5 py-1.5 rounded border border-transparent hover:border-red-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Edit Modal --}}
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div class="bg-white border border-brand-border rounded-lg w-full max-w-sm p-6" @click.stop>
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-display text-base font-semibold text-brand-ink">Edit Tag</h2>
                    <button wire:click="cancelEdit" class="text-brand-muted hover:text-brand-ink transition p-1 rounded hover:bg-brand-surface-low">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="updateTag" class="space-y-4 text-sm">
                    <div>
                        <label class="block font-medium text-brand-ink mb-1.5">Tag Name</label>
                        <input type="text" wire:model="editName"
                            class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                        @error('editName') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block font-medium text-brand-ink mb-1.5">Text Color</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="editColor"
                                    class="h-9 w-14 rounded border border-brand-border cursor-pointer p-0.5">
                                <span class="font-mono text-xs text-brand-muted">{{ $editColor }}</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block font-medium text-brand-ink mb-1.5">Background</label>
                            <div class="flex items-center gap-2">
                                <input type="color" wire:model.live="editBg"
                                    class="h-9 w-14 rounded border border-brand-border cursor-pointer p-0.5">
                                <span class="font-mono text-xs text-brand-muted">{{ $editBg }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block font-medium text-brand-ink mb-1.5">Preview</label>
                        <span style="color: {{ $editColor }}; background-color: {{ $editBg }}"
                            class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold">
                            {{ $editName ?: 'Tag' }}
                        </span>
                    </div>
                    <div class="flex gap-2 pt-2 border-t border-brand-border">
                        <button type="submit"
                            class="flex-1 bg-brand-primary hover:bg-brand-primary-dark text-white font-medium py-2.5 rounded-md transition">
                            Save Changes
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
