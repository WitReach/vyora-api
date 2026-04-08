<div class="section-settings-panel mt-12 bg-gray-50/80 backdrop-blur-xl rounded-3xl border border-gray-100/50 p-6 shadow-sm overflow-hidden group/settings transition-all duration-500">
    <button type="button"
        class="flex items-center gap-4 w-full text-left group"
        onclick="toggleSectionSettings(this)">
        <div class="w-10 h-10 rounded-2xl bg-white shadow-sm flex items-center justify-center text-gray-700 group-hover:bg-gray-900 group-hover:text-white transition-all duration-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="text-sm font-black uppercase tracking-widest text-gray-900 group-hover:translate-x-1 transition-transform duration-500">Section Settings</h4>
            <p class="text-xs font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Visual configuration and visibility</p>
        </div>
        <div class="w-8 h-8 rounded-full border border-gray-100 flex items-center justify-center text-gray-400">
            <svg class="section-settings-chevron w-3 h-3 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>

    <div class="section-settings-body hidden pt-8 grid grid-cols-1 md:grid-cols-4 gap-8">
        {{-- Background Color --}}
        <div class="space-y-3">
            <label class="text-sm font-black uppercase tracking-widest text-gray-700">Background Color</label>
            <div class="flex items-center gap-3">
                <label class="relative flex items-center gap-2 px-3 py-2 bg-white rounded-xl border border-gray-100 cursor-pointer hover:border-black/5 transition-all text-xs font-bold text-gray-700">
                    <input type="checkbox" class="section-has-bg rounded-md border-gray-200 text-gray-900 focus:ring-0" onchange="toggleBgPicker(this)">
                    Custom
                </label>
                <div class="section-bg-picker-wrapper hidden">
                    <input type="color" class="section-bg-color h-10 w-16 bg-white border border-gray-100 rounded-xl cursor-pointer p-1.5" value="#f5f5f5 shadow-sm">
                </div>
            </div>
        </div>

        {{-- Padding --}}
        <div class="space-y-3">
            <label class="text-sm font-black uppercase tracking-widest text-gray-700">Extra Padding</label>
            <div class="relative group/select">
                <select class="section-padding w-full h-10 bg-white border border-gray-100 rounded-xl px-4 text-xs font-black uppercase tracking-widest text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all appearance-none cursor-pointer">
                    <option value="">Default</option>
                    <option value="none">None</option>
                    <option value="sm">Small</option>
                    <option value="md">Medium</option>
                    <option value="lg">Large</option>
                    <option value="xl">Extra Large</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </div>

        {{-- Visibility --}}
        <div class="md:col-span-2 space-y-3">
            <label class="text-sm font-black uppercase tracking-widest text-gray-700">Visibility</label>
            <div class="flex gap-4">
                <label class="flex-1 relative flex items-center justify-center p-4 bg-white rounded-2xl border-2 border-gray-50 cursor-pointer transition-all hover:border-black/5 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-900 has-[:checked]:text-white">
                    <input type="checkbox" class="section-show-mobile hidden" checked>
                    <span class="text-xs font-black uppercase tracking-[0.2em] leading-none">Mobile</span>
                </label>
                <label class="flex-1 relative flex items-center justify-center p-4 bg-white rounded-2xl border-2 border-gray-50 cursor-pointer transition-all hover:border-black/5 has-[:checked]:border-gray-900 has-[:checked]:bg-gray-900 has-[:checked]:text-white">
                    <input type="checkbox" class="section-show-desktop hidden" checked>
                    <span class="text-xs font-black uppercase tracking-[0.2em] leading-none">Desktop</span>
                </label>
            </div>
        </div>
    </div>
</div>
