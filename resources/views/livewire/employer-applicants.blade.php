<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'applicants'])

        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">{{ __('messages.applicants.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ __('messages.applicants.subtitle') }}</p>
        </header>
    </div>

    <div class="space-y-6 px-4 lg:px-8 pb-8">
        @if($myJobs->isEmpty())
            <div class="bg-white p-8 text-center rounded-2xl text-gray-500 shadow-sm border">
                {{ __('messages.applicants.empty') }}
            </div>
        @endif

        @foreach($myJobs as $job)
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                        <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md">{{ $job->type }}</span>
                    </div>
                    <span class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-xl">
                        {{ trans_choice('messages.applicants.submissions', $job->applications->count(), ['count' => $job->applications->count()]) }}
                    </span>
                </div>

                <div class="divide-y divide-gray-100">
                    @php
                        $statusStyles = [
                            'Pending'               => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'Assesment in Progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Interview'             => 'bg-purple-50 text-purple-700 border-purple-200',
                            'Offer'                 => 'bg-green-50 text-green-700 border-green-200',
                            'Not proceding'         => 'bg-gray-50 text-gray-600 border-gray-200',
                            'Rejected'              => 'bg-red-50 text-red-700 border-red-200',
                        ];
                    @endphp

                    @foreach($job->applications as $application)
                        <div class="py-3 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 text-sm">
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-800">
                                    {{ $application->user->name }}
                                    <span class="text-xs font-normal text-gray-500">({{ $application->user->email }})</span>
                                </p>
                                <p class="text-xs text-gray-600 mt-1 bg-gray-50 p-2 rounded-lg italic">
                                    {{ $application->cover_letter ?? __('messages.applicants.no_cover_letter') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <select
                                    wire:change="updateStatus({{ $application->id }}, $event.target.value)"
                                    class="text-xs font-semibold border px-2.5 py-1.5 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400 transition {{ $statusStyles[$application->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}"
                                    x-data
                                    x-on:change="$el.className = $el.className"
                                >
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>
                                            {{ \App\Models\Applications::statusLabel($status) }}
                                        </option>
                                    @endforeach
                                </select>

                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                                   class="text-xs bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition">
                                    {{ __('messages.applicants.resume') }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
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
