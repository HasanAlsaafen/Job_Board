<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-brand-surface" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
    <flux:toast position="bottom right" />

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.seeker-sidebar', ['active' => 'profile'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">{{ __('messages.profile.title') }}</h1>
            <p class="font-sans text-sm text-brand-muted mt-0.5">{{ __('messages.profile.subtitle') }}</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        <div class="bg-white border border-brand-border rounded-lg mx-auto p-6 max-w-2xl">

            <form wire:submit.prevent="submitProfile">

                {{-- Profile Photo --}}
                <div class="mb-5">
                    <label for="profile-avatar" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.photo_label') }}</label>
                    <div class="flex items-center gap-4 mb-3">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" alt="{{ __('messages.profile.photo_label') }}"
                                class="w-20 h-20 rounded-full object-cover border border-brand-border" />
                        @elseif ($currentAvatarPath)
                            <img src="{{ Storage::url($currentAvatarPath) }}" alt="{{ __('messages.profile.photo_label') }}"
                                class="w-20 h-20 rounded-full object-cover border border-brand-border" />
                        @else
                            <div class="w-20 h-20 rounded-full bg-brand-surface-low border border-brand-border flex items-center justify-center text-brand-muted text-2xl font-display font-bold" aria-hidden="true">
                                {{ auth()->user()->initials() }}
                            </div>
                        @endif
                    </div>
                    <input id="profile-avatar" type="file" wire:model="avatar" accept="image/*"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-brand-primary-light file:text-brand-primary hover:file:bg-brand-primary/20 focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    <p class="mt-1 font-sans text-xs text-brand-muted">{{ __('messages.profile.photo_hint') }}</p>
                    @error('avatar')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Professional Title --}}
                <div class="mb-5">
                    <label for="profile-title" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.professional_title') }}</label>
                    <input id="profile-title" type="text" wire:model="title" placeholder="{{ __('messages.profile.professional_title_ph') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    @error('title')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="mb-5">
                    <label for="profile-bio" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.bio') }}</label>
                    <textarea id="profile-bio" wire:model="bio" rows="4" placeholder="{{ __('messages.profile.bio_ph') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition resize-none"></textarea>
                    @error('bio')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div class="mb-5">
                    <label for="profile-location" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.location') }}</label>
                    <input id="profile-location" type="text" wire:model="location" placeholder="{{ __('messages.profile.location_ph') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    @error('location')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-5">
                    <label for="profile-phone" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.phone') }}</label>
                    <div class="flex gap-2">
                        <select wire:model='phone_prefix'
                            class="border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition">
                            <option value="+1">+1 (US)</option>
                            <option value="+44">+44 (UK)</option>
                            <option value="+33">+33 (FR)</option>
                            <option value="+49">+49 (DE)</option>
                            <option value="+34">+34 (ES)</option>
                            <option value="+39">+39 (IT)</option>
                            <option value="+31">+31 (NL)</option>
                            <option value="+32">+32 (BE)</option>
                            <option value="+41">+41 (CH)</option>
                            <option value="+43">+43 (AT)</option>
                            <option value="+351">+351 (PT)</option>
                            <option value="+48">+48 (PL)</option>
                            <option value="+46">+46 (SE)</option>
                            <option value="+47">+47 (NO)</option>
                            <option value="+45">+45 (DK)</option>
                            <option value="+358">+358 (FI)</option>
                            <option value="+7">+7 (RU)</option>
                            <option value="+90">+90 (TR)</option>
                            <option value="+20">+20 (EG)</option>
                            <option value="+966">+966 (SA)</option>
                            <option value="+971">+971 (AE)</option>
                            <option value="+962">+962 (JO)</option>
                            <option value="+961">+961 (LB)</option>
                            <option value="+965">+965 (KW)</option>
                            <option value="+974">+974 (QA)</option>
                            <option value="+973">+973 (BH)</option>
                            <option value="+212">+212 (MA)</option>
                            <option value="+213">+213 (DZ)</option>
                            <option value="+216">+216 (TN)</option>
                            <option value="+91">+91 (IN)</option>
                            <option value="+86">+86 (CN)</option>
                            <option value="+81">+81 (JP)</option>
                            <option value="+82">+82 (KR)</option>
                            <option value="+55">+55 (BR)</option>
                            <option value="+52">+52 (MX)</option>
                            <option value="+27">+27 (ZA)</option>
                            <option value="+234">+234 (NG)</option>
                            <option value="+254">+254 (KE)</option>
                            <option value="+61">+61 (AU)</option>
                            <option value="+64">+64 (NZ)</option>
                        </select>
                        <input id="profile-phone" type="tel" wire:model="phone_number" placeholder="123 456 7890"
                            class="flex-1 border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    </div>
                    @error('phone_number')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    @error('phone_prefix')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- LinkedIn --}}
                <div class="mb-5">
                    <label for="profile-linkedin" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.linkedin') }}</label>
                    <input id="profile-linkedin" type="url" wire:model="linkedin" placeholder="{{ __('messages.profile.linkedin_ph') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    @error('linkedin')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- GitHub --}}
                <div class="mb-5">
                    <label for="profile-github" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.github') }}</label>
                    <input id="profile-github" type="url" wire:model="github" placeholder="{{ __('messages.profile.github_ph') }}"
                        class="w-full border border-brand-border rounded-md px-3 py-2.5 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    @error('github')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Resume --}}
                <div class="mb-6">
                    <label for="profile-resume" class="block text-sm font-medium text-brand-ink mb-1.5">{{ __('messages.profile.resume') }}</label>
                    @if (auth()->user()->profile?->resume_path)
                        <div class="mb-3">
                            <a href="{{ Storage::url(auth()->user()->profile->resume_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-3 py-2 font-sans text-xs font-medium text-brand-primary bg-brand-primary-light border border-brand-primary/20 rounded-md hover:bg-brand-primary/20 transition">
                                <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ __('messages.profile.view_resume') }}
                            </a>
                        </div>
                    @endif
                    <input id="profile-resume" type="file" wire:model="resume" accept=".pdf,.doc,.docx"
                        class="w-full border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-brand-primary-light file:text-brand-primary hover:file:bg-brand-primary/20 focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/60 transition" />
                    <p class="mt-1 font-sans text-xs text-brand-muted">{{ __('messages.profile.resume_hint') }}</p>
                    @error('resume')
                        <p class="mt-1 font-sans text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 border-t border-brand-border">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full px-6 py-2.5 bg-brand-primary hover:bg-brand-primary-dark text-white font-medium rounded-md disabled:opacity-50 transition flex items-center justify-center gap-2">
                        <svg wire:loading wire:target="submitProfile" aria-hidden="true" class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="submitProfile">{{ __('messages.profile.save') }}</span>
                        <span wire:loading wire:target="submitProfile">{{ __('messages.profile.saving') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
