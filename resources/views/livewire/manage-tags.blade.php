<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen text-black bg-white"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'tags'])

        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">Manage Tags</h1>
            <p class="text-sm text-gray-400 mt-0.5">Create and remove job tags</p>
        </header>
    </div>

    <div class="flex flex-col gap-6 px-4 lg:px-8 pb-8">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-base font-bold text-gray-900 mb-4">New Tag</h2>

            @if ($successMessage)
                <div class="p-3 mb-4 text-xs font-bold text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="createTag" class="space-y-4 text-sm">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Tag Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Python"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block font-medium text-gray-700 mb-1">Text Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" wire:model.live="color"
                                class="h-9 w-14 rounded border border-gray-300 cursor-pointer p-0.5">
                            <span class="text-xs text-gray-400 font-mono">{{ $color }}</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block font-medium text-gray-700 mb-1">Background Color</label>
                        <div class="flex items-center gap-2">
                            <input type="color" wire:model.live="bg"
                                class="h-9 w-14 rounded border border-gray-300 cursor-pointer p-0.5">
                            <span class="text-xs text-gray-400 font-mono">{{ $bg }}</span>
                        </div>
                    </div>
                </div>

                @if ($name)
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Preview</label>
                        <span style="color: {{ $color }}; background-color: {{ $bg }}"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                            {{ $name }}
                        </span>
                    </div>
                @endif

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2 rounded-xl transition text-sm">
                    Create Tag
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-base font-bold text-gray-900 mb-4">All Tags</h2>

            @if ($tags->isEmpty())
                <p class="text-sm text-gray-400 italic">No tags yet.</p>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach ($tags as $tag)
                        <div class="flex items-center gap-1.5">
                            <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $tag->name }}
                            </span>
                            <button type="button" wire:click="deleteTag({{ $tag->id }})"
                                wire:confirm="Delete the '{{ $tag->name }}' tag? It will be removed from all jobs."
                                class="text-gray-300 hover:text-red-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
