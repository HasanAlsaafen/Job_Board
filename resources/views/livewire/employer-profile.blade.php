<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen bg-brand-surface"
     dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'profile'])

        <header class="bg-white border border-brand-border rounded-lg py-4 px-5 mt-4 lg:mt-8 mb-6">
            <h1 class="font-display text-lg font-semibold text-brand-ink">Company Profile</h1>
            <p class="font-mono text-xs text-brand-muted mt-0.5 tracking-wide">Visible to job seekers who view your listings</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        <form wire:submit.prevent="submitProfile" class="max-w-2xl space-y-4">

            @if (!empty($successMessage))
                <div class="font-mono text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md px-4 py-3">
                    {{ $successMessage }}
                </div>
            @endif

            {{-- Identity --}}
            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                <div class="px-5 py-3 border-b border-brand-border bg-brand-surface">
                    <span class="font-sans text-xs font-medium tracking-wider uppercase text-brand-muted">Identity</span>
                </div>
                <div class="p-5 space-y-5">

                    {{-- Logo preview + URL --}}
                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Company Logo URL</label>
                        <div class="flex items-center gap-4">
                            <div class="shrink-0 w-14 h-14 rounded-md border border-brand-border bg-brand-surface-low flex items-center justify-center overflow-hidden">
                                @if ($img_url)
                                    <img src="{{ $img_url }}" alt="Company logo" class="w-full h-full object-cover" />
                                @else
                                    <span class="font-display font-bold text-xl text-brand-muted">
                                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <input type="url" wire:model.live.debounce.500ms="img_url"
                                placeholder="https://example.com/logo.png"
                                class="flex-1 border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        </div>
                        @error('img_url')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Your role --}}
                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Your Role</label>
                        <input type="text" wire:model="title" placeholder="e.g. HR Manager, CEO, Recruiter"
                            class="w-full border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        @error('title')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- About --}}
            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                <div class="px-5 py-3 border-b border-brand-border bg-brand-surface">
                    <span class="font-sans text-xs font-medium tracking-wider uppercase text-brand-muted">About</span>
                </div>
                <div class="p-5 space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Company Description</label>
                        <textarea wire:model="bio" rows="5"
                            placeholder="Tell job seekers about your company — culture, mission, what makes you a great place to work..."
                            class="w-full border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition resize-none leading-relaxed"></textarea>
                        <div class="flex justify-between mt-1">
                            @error('bio')
                                <p class="font-mono text-xs text-red-600">{{ $message }}</p>
                            @else
                                <span></span>
                            @enderror
                            <span class="font-sans text-xs text-brand-muted {{ strlen($bio) > 900 ? 'text-amber-600' : '' }}">
                                {{ strlen($bio) }}/1000
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Location</label>
                        <div class="relative">
                            <svg class="absolute {{ app()->isLocale('ar') ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 h-4 w-4 text-brand-muted pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <input type="text" wire:model="location" placeholder="e.g. San Francisco, CA"
                                class="w-full border border-brand-border rounded-md {{ app()->isLocale('ar') ? 'pr-9 pl-3' : 'pl-9 pr-3' }} py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        </div>
                        @error('location')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Contact & Links --}}
            <div class="bg-white border border-brand-border rounded-lg overflow-hidden">
                <div class="px-5 py-3 border-b border-brand-border bg-brand-surface">
                    <span class="font-sans text-xs font-medium tracking-wider uppercase text-brand-muted">Contact & Links</span>
                </div>
                <div class="p-5 space-y-5">

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Phone Number</label>
                        <div class="flex gap-2">
                            <select wire:model="phone_prefix"
                                class="border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink bg-white focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition">
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
                            <input type="tel" wire:model="phone_number" placeholder="123 456 7890"
                                class="flex-1 border border-brand-border rounded-md px-3 py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        </div>
                        @error('phone_number')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        @error('phone_prefix')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- LinkedIn --}}
                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">LinkedIn Page</label>
                        <div class="relative">
                            <svg class="absolute {{ app()->isLocale('ar') ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 h-4 w-4 text-brand-muted pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            <input type="url" wire:model="linkedin" placeholder="https://linkedin.com/company/your-company"
                                class="w-full border border-brand-border rounded-md {{ app()->isLocale('ar') ? 'pr-9 pl-3' : 'pl-9 pr-3' }} py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        </div>
                        @error('linkedin')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div>
                        <label class="block text-sm font-medium text-brand-ink mb-1.5">Company Website</label>
                        <div class="relative">
                            <svg class="absolute {{ app()->isLocale('ar') ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 h-4 w-4 text-brand-muted pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <input type="url" wire:model="website" placeholder="https://yourcompany.com"
                                class="w-full border border-brand-border rounded-md {{ app()->isLocale('ar') ? 'pr-9 pl-3' : 'pl-9 pr-3' }} py-2 text-sm text-brand-ink placeholder-brand-muted focus:outline-none focus:border-brand-primary focus:ring-2 focus:ring-brand-primary/10 transition" />
                        </div>
                        @error('website')
                            <p class="mt-1 font-mono text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Save --}}
            <div class="flex justify-end">
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2.5 bg-brand-primary hover:bg-brand-primary-dark disabled:opacity-60 text-white font-medium text-sm rounded-md transition flex items-center gap-2">
                    <svg wire:loading wire:target="submitProfile" class="size-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="submitProfile">Save Profile</span>
                    <span wire:loading wire:target="submitProfile">Saving…</span>
                </button>
            </div>

        </form>
    </div>

</div>
