<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen text-black bg-blue-50"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}"
>

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.seeker-sidebar', ['active' => 'profile'])

        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">My Profile</h1>
            <p class="text-sm text-gray-400 mt-0.5">Update your contact information and photo</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm max-w-lg">

            @if (!empty($successMessage))
                <div class="mb-5 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="submitProfile">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo URL</label>
                    @if ($img_url)
                        <img src="{{ $img_url }}" alt="Profile photo" class="w-20 h-20 rounded-full object-cover mb-3 border border-gray-200" />
                    @endif
                    <input
                        type="url"
                        wire:model="img_url"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    />
                    @error('img_url')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <div class="flex gap-2">
                        <select
                            wire:model='phone_prefix'
                            class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        >
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
                        <input
                            type="tel"
                            wire:model="phone_number"
                            placeholder="123 456 7890"
                            class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        />
                    </div>
                    @error('phone_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    @error('phone_prefix')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-lg transition"
                >
                    Save Profile
                </button>
            </form>
        </div>
    </div>

</div>
