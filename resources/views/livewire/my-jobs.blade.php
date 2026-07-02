<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'jobs'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.my_jobs.title') }}</h1>
                <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.my_jobs.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('dashboard') }}"
                   class="font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark px-3 py-2 rounded-md transition">
                    {{ __('messages.my_jobs.post_a_job') }}
                </a>
                <a href="{{ route('logout') }}"
                   class="font-sans text-sm font-medium text-brand-muted border border-brand-border hover:text-red-600 hover:border-red-200 hover:bg-red-50 px-3 py-2 rounded-md transition">
                    {{ __('messages.auth.logout') }}
                </a>
            </div>
        </header>
    </div>

    <div class="space-y-3 px-4 lg:px-8 pb-8">
        @if($myJobs->isEmpty())
            <div class="bg-white border border-dashed border-brand-border rounded-lg p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 size-10 text-brand-muted opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.073a2.25 2.25 0 0 1-2.25 2.25h-12a2.25 2.25 0 0 1-2.25-2.25V6a2.25 2.25 0 0 1 2.25-2.25h4.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 3h4.5m0 0v4.5m0-4.5-6 6" />
                </svg>
                <p class="font-sans text-sm text-brand-muted">{{ __('messages.my_jobs.empty') }}</p>
                <p class="font-mono text-xs text-brand-muted mt-1">{{ __('messages.my_jobs.empty_hint') }}
                    <a href="{{ route('dashboard') }}" class="text-brand-primary hover:text-brand-primary-dark font-medium">{{ __('messages.my_jobs.post_one_now') }}</a>
                </p>
            </div>
        @endif

        @foreach($myJobs as $job)
            <div class="bg-white border border-brand-border rounded-lg hover:border-brand-primary transition duration-150" wire:key="job-{{$job->id}}">
                <div class="p-5">
                    <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                        <div class="min-w-0">
                            <h3 class="font-display text-base font-semibold text-brand-ink leading-snug">{{ $job->title }}</h3>
                            <p class="text-sm text-brand-muted mt-0.5">{{ $job->company_name }}</p>
                        </div>

                        <span class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-brand-primary bg-brand-primary-light border border-brand-primary/20 px-2.5 py-1.5 rounded shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            {{ trans_choice('messages.my_jobs.applicants', $job->applications_count, ['count' => $job->applications_count]) }}
                        </span>
                    </div>

                    {{-- Meta chips --}}
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="font-sans text-xs font-medium tracking-wider uppercase px-2 py-1 rounded border
                            {{ $job->type === 'Full-time' ? 'bg-brand-primary-light text-brand-primary border-brand-primary/20' : ($job->type === 'Part-time' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-amber-50 text-amber-700 border-amber-200') }}">
                            {{ $job->type }}
                        </span>

                        @if($job->salary_range)
                            <span class="inline-flex items-center gap-1 font-mono text-xs text-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ $job->salary_range }}
                            </span>
                        @endif

                        @if($job->created_at)
                            <span class="font-mono text-xs text-brand-muted">{{ $job->created_at->diffForHumans() }}</span>
                        @endif
                    </div>

                    @if($job->description)
                        <p class="text-sm text-brand-muted line-clamp-2 leading-relaxed mb-3">{{ $job->description }}</p>
                    @endif

                    {{-- Actions --}}
                    <div class="pt-3 border-t border-brand-border flex items-center gap-1 flex-wrap">
                        <a href="{{ route('employer.job.applicants', $job->id) }}"
                            class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-brand-primary hover:bg-brand-primary-light px-3 py-1.5 rounded border border-brand-primary/20 hover:border-brand-primary/40 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            {{ __('messages.my_jobs.view_applications') }}
                        </a>
                        <button
                            wire:click="deleteJob({{ $job->id }})"
                            wire:confirm="{{ __('messages.my_jobs.delete_confirm') }}"
                            class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-brand-muted hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded border border-transparent hover:border-red-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            {{ __('messages.my_jobs.delete') }}
                        </button>
                        <button
                            wire:click="editJob({{ $job->id }})"
                            class="inline-flex items-center gap-1.5 font-mono text-xs font-medium text-brand-muted hover:text-brand-primary hover:bg-brand-primary-light px-3 py-1.5 rounded border border-transparent hover:border-brand-primary/20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            {{ __('messages.my_jobs.edit') }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Edit Modal --}}
    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="bg-white border border-brand-border rounded-lg w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto" @click.stop>

            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display text-base font-semibold text-brand-ink">{{ __('messages.my_jobs.edit_modal_title') }}</h2>
                <button wire:click="cancelEdit" class="text-brand-muted hover:text-brand-ink transition p-1 rounded hover:bg-brand-surface-low">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if($successMessage)
                <div class="p-3 mb-4 font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="updateJob" class="space-y-4 text-sm">
                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.job_title') }}</label>
                    <input type="text" wire:model="title"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                    @error('title') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.company_name') }}</label>
                    <input type="text" wire:model="company_name"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                    @error('company_name') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.location') }}</label>
                    <input type="text" wire:model="location"
                        placeholder="{{ __('messages.job_form.location_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                    @error('location') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.employment_type') }}</label>
                    <select wire:model="type"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                        <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                        <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                        <option value="Contract">{{ __('messages.job_form.contract') }}</option>
                    </select>
                    @error('type') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-brand-ink">{{ __('messages.job_form.tags') }}</label>
                    <div class="flex flex-wrap gap-2 p-3 bg-brand-surface border border-brand-border rounded-md min-h-[44px]">
                        @php $availableTags = $tags->filter(fn($t) => !in_array((string)$t->id, $selectedTagIds)); @endphp
                        @forelse ($availableTags as $tag)
                            <label class="cursor-pointer select-none">
                                <input type="checkbox" wire:model.live="selectedTagIds" value="{{ $tag->id }}" class="hidden">
                                <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                    class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold opacity-60 hover:opacity-100 transition-all duration-150">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @empty
                            <span class="font-mono text-xs text-brand-muted self-center italic">All tags selected</span>
                        @endforelse
                    </div>
                    @if (count($selectedTagIds) > 0)
                        <div class="p-3 border border-brand-primary/20 bg-brand-primary-light rounded-md">
                            <p class="font-mono text-xs text-brand-primary mb-2 tracking-wide">{{ count($selectedTagIds) }} {{ count($selectedTagIds) === 1 ? 'tag' : 'tags' }} selected</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($tags->whereIn('id', $selectedTagIds) as $tag)
                                    <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-semibold">
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

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.salary_range') }}</label>
                    <input type="text" wire:model="salary_range"
                        placeholder="{{ __('messages.job_form.salary_placeholder') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
                </div>

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.description') }}</label>
                    <textarea wire:model="description" rows="4"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition resize-none"></textarea>
                    @error('description') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-brand-ink mb-1.5">{{ __('messages.job_form.requirements') }}</label>
                    <textarea wire:model="requirements" rows="3"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition resize-none"></textarea>
                    @error('requirements') <span class="font-mono text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-2 pt-2 border-t border-brand-border">
                    <button type="submit"
                        class="flex-1 bg-brand-primary hover:bg-brand-primary-dark text-white font-medium py-2.5 rounded-md transition">
                        {{ __('messages.my_jobs.save_changes') }}
                    </button>
                    <button type="button" wire:click="cancelEdit"
                        class="flex-1 border border-brand-border text-brand-muted hover:bg-brand-surface-low font-medium py-2.5 rounded-md transition">
                        {{ __('messages.my_jobs.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
