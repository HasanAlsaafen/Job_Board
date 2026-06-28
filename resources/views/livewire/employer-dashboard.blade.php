@assets
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endassets

<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen text-black bg-white"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'dashboard'])

        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">{{ __('messages.employer_dashboard.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('messages.employer_dashboard.subtitle') }}</p>
        </header>
    </div>

    <div class="flex flex-col px-4 lg:px-8 pb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                {{ __('messages.employer_dashboard.section_title') }}
            </h2>

            @if ($successMessage)
                <div class="p-3 mb-4 text-xs font-bold text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="createJob" class="space-y-4 text-sm">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.job_title') }}</label>
                    <input type="text" wire:model="title"
                        placeholder="{{ __('messages.job_form.job_title_placeholder') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label
                        class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.company_name') }}</label>
                    <input type="text" wire:model="company_name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    @error('company_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.location') }}</label>
                    <input type="text" wire:model="location"
                        placeholder="{{ __('messages.job_form.location_placeholder') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                    @error('location')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.tags') }}</label>

                    <div class="flex flex-wrap gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg min-h-[48px]">
                        @php $availableTags = $tags->filter(fn($t) => !in_array($t->id, $selectedTagIds)); @endphp
                        @forelse ($availableTags as $tag)
                            <label class="cursor-pointer select-none">
                                <input type="checkbox" wire:model.live="selectedTagIds" value="{{ $tag->id }}" class="hidden">
                                <span
                                    style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold opacity-65 hover:opacity-100 hover:shadow-sm transition-all duration-150">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @empty
                            <span class="text-xs text-gray-400 self-center italic">All tags selected</span>
                        @endforelse
                    </div>

                    @if (count($selectedTagIds) > 0)
                        <div class="p-3 border border-blue-100 bg-blue-50 rounded-lg">
                            <p class="text-xs font-medium text-blue-400 mb-2">{{ count($selectedTagIds) }} {{ count($selectedTagIds) === 1 ? 'tag' : 'tags' }} chosen</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tags->whereIn('id', $selectedTagIds) as $tag)
                                    <span
                                        style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                        {{ $tag->name }}
                                        <button type="button" wire:click="removeTag({{ $tag->id }})"
                                            class="opacity-60 hover:opacity-100 transition-opacity leading-none">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div wire:ignore x-data="{
                    map: null,
                    marker: null,

                    initMap() {
                        const initLat = $wire.get('latitude') || 33.5138;
                        const initLng = $wire.get('longitude') || 36.2765;

                        this.map = L.map('map-picker').setView([initLat, initLng], 8);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(this.map);

                        if ($wire.get('latitude') && $wire.get('longitude')) {
                            this.marker = L.marker([initLat, initLng]).addTo(this.map);
                        }

                        this.map.on('click', (e) => {
                            const { lat, lng } = e.latlng;

                            if (this.marker) {
                                this.marker.setLatLng([lat, lng]);
                            } else {
                                this.marker = L.marker([lat, lng]).addTo(this.map);
                            }

                            $wire.set('latitude', lat);
                            $wire.set('longitude', lng);
                        });
                    }
                }" x-init="initMap()">
                    <div id="map-picker" style="height: 300px; width: 100%;"></div>
                </div>

                @if ($latitude && $longitude)
                    <p class="text-sm text-gray-500">
                        تم تحديد الموقع: {{ round($latitude, 4) }}, {{ round($longitude, 4) }}
                    </p>
                @else
                    <p class="text-sm text-gray-400">{{ __('messages.map.click') }}</p>
                @endif
                <div>
                    <label
                        class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.employment_type') }}</label>
                    <select wire:model="type"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                        <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                        <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                        <option value="Contract">{{ __('messages.job_form.contract') }}</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.salary_range') }}</label>
                    <input type="text" wire:model="salary_range"
                        placeholder="{{ __('messages.job_form.salary_placeholder') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900">
                </div>

                <div>
                    <label
                        class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.description') }}</label>
                    <textarea wire:model="description" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label
                        class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.requirements') }}</label>
                    <textarea wire:model="requirements" rows="3" placeholder="{{ __('messages.job_form.requirements_placeholder') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900"></textarea>
                    @error('requirements')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition">
                    {{ __('messages.employer_dashboard.publish_button') }}
                </button>
            </form>
        </div>
    </div>

</div>
