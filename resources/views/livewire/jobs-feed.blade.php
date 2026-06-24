
@assets
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endassets

<div class="flex flex-col min-h-screen bg-white text-black" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    {{-- Sidebar --}}
    @auth
        @include('livewire.partials.seeker-sidebar', ['active' => 'openings'])
    @endauth

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto w-full px-4 lg:px-8 py-6 pt-16 lg:pt-6">

        {{-- Search & Filter Bar --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-blue-100 mb-6 flex flex-col md:flex-row gap-3 items-center">

            {{-- Search Input --}}
            <div class="relative w-full md:w-1/2">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('messages.jobs_feed.search_placeholder') }}"
                    class="w-full pl-9 pr-4 py-2 border border-blue-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            {{-- Type Filter --}}
            <select
                wire:model.live="selectedType"
                class="w-full md:w-1/3 border border-blue-200 rounded-lg px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">{{ __('messages.jobs_feed.all_types') }}</option>
                <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                <option value="Contract">{{ __('messages.job_form.contract') }}</option>
            </select>

            {{-- View Toggle --}}
            <div class="flex gap-2 shrink-0">
                <button
                    wire:click="$set('view', 'list')"
                    class="px-3 py-2 rounded-lg text-sm font-medium border transition {{ $view === 'list' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-blue-200 hover:border-blue-300' }}"
                >
                    {{ __('List') }}
                </button>
                <button
                    wire:click="$set('view', 'map')"
                    class="px-3 py-2 rounded-lg text-sm font-medium border transition {{ $view === 'map' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-blue-200 hover:border-blue-300' }}"
                >
                    {{ __('Map') }}
                </button>
            </div>

        </div>

        {{-- Empty State --}}
        @if($jobs->isEmpty())
            <div class="text-center py-12 text-gray-400 bg-white rounded-xl shadow-sm border border-blue-100">
                {{ __('messages.jobs_feed.no_results') }}
            </div>
        @endif

        {{-- List View --}}
        @if($view === 'list')

            <div class="space-y-3">
                @foreach($jobs as $job)
                    <div class="bg-white px-6 py-5 rounded-xl shadow-sm border border-blue-100 hover:border-blue-300 hover:shadow-md transition duration-200">

                        {{-- Job Header: Title, Company & Type Badge --}}
                        <div class="flex justify-between items-start gap-3 mb-1">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-blue-600 text-sm font-medium mt-0.5">{{ $job->company_name }}</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $job->type }}
                            </span>
                        </div>

                        <p class="text-gray-500 text-sm my-3 line-clamp-2">{{ $job->description }}</p>

                        <div class="flex flex-wrap items-center justify-between pt-3 border-t border-blue-100 text-xs text-gray-400 gap-2">

                            <div class="flex items-center gap-3">
                                @if($job->location)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif
                                @if($job->salary_range)
                                    <span class="text-green-600 font-semibold">{{ $job->salary_range }}</span>
                                @endif
                            </div>

                            {{-- Save Button --}}
                            @auth
                                @if($job->saved_by_users_exists)
                                    <button wire:click="unsaveJob({{ $job->id }})"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition duration-150">
                                        <svg class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        {{ __('Saved') }}
                                    </button>
                                @else
                                    <button wire:click="saveJob({{ $job->id }})"
                                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-500 bg-white border border-blue-100 rounded-lg hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition duration-150">
                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        {{ __('Save') }}
                                    </button>
                                @endif
                            @endauth

                            {{-- Date & View Details --}}
                            <div class="flex items-center gap-3">
                                <span>{{ $job->created_at->diffForHumans() }}</span>
                                <a href="{{ route('jobs.show', $job) }}" class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-150">
                                    {{ __('View Details') }}
                                </a>
                            </div>

                        </div>

                        {{-- Inline Map (shown when coordinates are available) --}}
                        @if($job->latitude && $job->longitude)
                            <div
                                wire:ignore
                                x-data="{
                                    initMap() {
                                        const map = L.map('card-map-{{ $job->id }}', { zoomControl: true, dragging: true, scrollWheelZoom: true }).setView([{{ $job->latitude }}, {{ $job->longitude }}], 13);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {

                                        }).addTo(map);
                                        L.marker([{{ $job->latitude }}, {{ $job->longitude }}]).addTo(map);
                                    }
                                }"
                                x-init="initMap()"
                                class="mt-4 rounded-lg overflow-hidden border border-blue-100"
                            >
                                <div id="card-map-{{ $job->id }}" style="height: 160px; width: 100%;"></div>
                            </div>
                        @endif

                        {{-- Apply Modal --}}
                        @livewire('apply-modal', ['jobId' => $job->id], key($job->id))

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($jobs->hasPages())
                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            @endif

        {{-- Map View --}}
        @else

            <div
                wire:ignore
                x-data="{
                    map: null,
                    initMap() {
                        this.map = L.map('jobs-map').setView([31.9038, 35.2034], 8);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap'
                        }).addTo(this.map);

                        const jobs = {{ Js::from($jobs->whereNotNull('latitude')->values()) }};
                        jobs.forEach(job => {
                            L.marker([job.latitude, job.longitude])
                                .addTo(this.map)
                                .bindPopup(`
                                    <strong>${job.title}</strong><br>
                                    ${job.company_name}<br>
                                    ${job.location}<br>
                                    <a href='/jobs/${job.id}'>{{ __('View Details') }}</a>
                                `);
                        });
                    }
                }"
                x-init="initMap()"
                class="rounded-xl overflow-hidden shadow-sm border border-blue-100"
            >
                <div id="jobs-map" style="height: 500px; width: 100%;"></div>
            </div>

        @endif

    </div>
</div>
