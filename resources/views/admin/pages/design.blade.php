<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Design Page: {{ $mnpage->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <style>
        .builder-section {
            transition: all 0.2s;
        }

        .builder-section:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Top Bar -->
        <header
            class="h-24 bg-white/90 backdrop-blur-2xl border-b border-gray-100/50 flex items-center justify-between px-12 fixed w-full top-0 z-50 shadow-[0_4px_30px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.online-store.mnpages.index') }}"
                    class="w-12 h-12 flex items-center justify-center bg-gray-50 text-gray-700 hover:text-black hover:bg-gray-100 rounded-2xl transition-all group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-10 bg-black rounded-full"></div>
                    <div>
                        <h1 class="text-xl font-black text-gray-900 tracking-tighter uppercase">Design</h1>
                        <p class="text-xs font-bold text-gray-700 mt-0.5 uppercase tracking-[0.2em] italic">
                            {{ $mnpage->title }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-8">
                <div class="relative group">
                    <button type="button"
                        class="h-10 flex items-center gap-3 bg-gray-800 text-white px-6 rounded-xl text-xs font-black uppercase tracking-[0.2em] hover:bg-gray-900 transition-all shadow-xl shadow-black/5 overflow-hidden relative group/btn">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-violet-600/20 to-transparent translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-700">
                        </div>
                        <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span class="relative z-10">Add Section</span>
                    </button>
                    <div class="origin-top-right absolute right-0 w-64 hidden group-hover:block z-50 pt-3">
                        <div class="rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] bg-white border border-gray-100/50 p-3 overflow-hidden"
                            role="menu">
                            <div class="max-h-[70vh] overflow-y-auto px-2 space-y-1 custom-scrollbar">
                                <p class="px-4 pt-4 pb-2 text-sm font-black text-gray-400 uppercase tracking-widest">
                                    Base Components</p>
                                <button type="button" onclick="addSection('hero_slider')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Hero
                                    Slider</button>
                                <button type="button" onclick="addSection('product_carousel')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Product
                                    Carousel</button>
                                <button type="button" onclick="addSection('text_block')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Text
                                    Block</button>
                                <button type="button" onclick="addSection('image_grid')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Image
                                    Grid</button>
                                <button type="button" onclick="addSection('image_banner')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Image
                                    Banner</button>

                                <div class="h-px bg-gray-50 my-2"></div>
                                <p class="px-4 pt-2 pb-2 text-sm font-black text-gray-400 uppercase tracking-widest">
                                    Interactive</p>
                                <button type="button" onclick="addSection('horizontal_scroll_cards')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Horizontal
                                    Scroll Cards</button>
                                <button type="button" onclick="addSection('product_horizontal_scroll')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Product
                                    Horizontal Scroll</button>
                                <button type="button" onclick="addSection('image_product_carousel')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest">Image
                                    & Product Carousel</button>

                                <div class="h-px bg-gray-50 my-2"></div>
                                <p class="px-4 pt-2 pb-2 text-sm font-black text-gray-400 uppercase tracking-widest">
                                    Essentials</p>
                                <button type="button" onclick="addSection('announcement_marquee')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Announcement
                                    Marquee</button>
                                <button type="button" onclick="addSection('feature_highlights')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Feature
                                    Highlights</button>
                                <button type="button" onclick="addSection('category_grid')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Category
                                    Grid</button>
                                <button type="button" onclick="addSection('split_banner')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Split
                                    Banner</button>
                                <button type="button" onclick="addSection('newsletter_signup')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Newsletter
                                    Signup</button>
                                <button type="button" onclick="addSection('video_banner')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Video
                                    Banner</button>
                                <button type="button" onclick="addSection('testimonials_slider')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic">Testimonials
                                    Slider</button>
                                <button type="button" onclick="addSection('countdown_timer')"
                                    class="w-full text-left px-4 py-3 text-xs font-black text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all uppercase tracking-widest italic pb-6">Countdown
                                    Timer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div id="save-status"
                        class="text-sm font-black uppercase tracking-widest text-emerald-500 italic opacity-0 transition-opacity">
                        Saved</div>
                    <button type="button" onclick="publishChanges()"
                        class="h-10 bg-violet-600 text-white px-6 rounded-xl text-xs font-black uppercase tracking-[0.2em] hover:bg-violet-700 transition-all shadow-xl shadow-violet-500/20 active:scale-95">
                        Publish
                    </button>
                </div>
            </div>
        </header>

        <!-- Builder Workspace -->
        <main class="flex-1 mt-24 p-12 bg-gray-50/50 overflow-y-auto custom-scrollbar">
            <div class="max-w-5xl mx-auto w-full">
                <div id="builder-container" class="space-y-12 min-h-[70vh] pb-32">
                    <div id="empty-builder-msg"
                        class="group py-32 bg-white rounded-[3rem] border-2 border-dashed border-gray-100 flex flex-col items-center justify-center transition-all hover:border-violet-200 hover:bg-violet-50/10 cursor-pointer">
                        <div
                            class="w-20 h-20 rounded-[2.5rem] bg-gray-50 flex items-center justify-center text-gray-200 group-hover:scale-110 group-hover:bg-violet-100 group-hover:text-violet-500 transition-all duration-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3
                            class="mt-8 text-xs font-black uppercase tracking-[0.3em] text-gray-700 group-hover:text-violet-600 transition-colors">
                            Start Designing</h3>
                        <p class="mt-2 text-xs font-bold text-gray-400 italic uppercase">Add sections from the menu
                            above to begin</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Templates -->
    <template id="tpl-hero_slider">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="hero_slider">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Hero Slider</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Full width rotating
                        banner</p>
                </div>
            </div>
            <div class="space-y-6">
                <div class="slides-container space-y-8"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-sm font-black uppercase tracking-widest text-gray-700 hover:border-violet-500 hover:text-violet-600 hover:bg-violet-50 transition-all shadow-sm"
                    onclick="addSlide(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Slide</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-slide-item">
        <div
            class="slide-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/slide transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/slide:opacity-100 transition-all border border-gray-50 z-20"
                onclick="this.closest('.slide-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                            URL</label>
                        <div class="flex items-center gap-2">
                            <input type="text"
                                class="slide-image flex-1 bg-white border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all outline-none"
                                placeholder="https://...">
                            <label
                                class="cursor-pointer h-12 px-6 flex items-center justify-center bg-violet-600 text-white rounded-xl text-xs font-black uppercase tracking-[0.1em] hover:bg-gray-900 transition-all active:scale-95 shadow-lg shadow-violet-500/10">
                                Upload
                                <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Link
                            URL</label>
                        <input type="text"
                            class="slide-link w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="/collections/new-arrivals">
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Main
                            Heading</label>
                        <input type="text"
                            class="slide-title w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="New Season Collection">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Sub
                            Heading</label>
                        <input type="text"
                            class="slide-subtitle w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="Explore the latest trends">
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template id="tpl-product_carousel">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="product_carousel">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Product Carousel</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Automated scrolling
                        product grid</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                        Title</label>
                    <input type="text"
                        class="section-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        placeholder="e.g. Best Sellers">
                </div>
                <div class="space-y-2">
                    <label
                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Collection</label>
                    <div class="relative">
                        <select
                            class="section-collection w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all appearance-none">
                            <option value="new_arrivals">New Arrivals</option>
                            <option value="best_sellers">Best Sellers</option>
                            <option value="featured">Featured Products</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Display
                        Limit</label>
                    <input type="number"
                        class="section-limit w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        value="8">
                </div>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-text_block">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="text_block">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Text Block</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Rich editor for
                        storytelling</p>
                </div>
            </div>
            <div class="rounded-3xl border border-gray-100 overflow-hidden shadow-sm">
                <div class="quill-editor" style="height: 400px; border: none;"></div>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-image_grid">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="image_grid">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Image Grid</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Multi-column visual
                        gallery</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                        Title</label>
                    <input type="text"
                        class="grid-title w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                        placeholder="Optional Title">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Grid
                        Columns</label>
                    <select
                        class="grid-columns w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                        <option value="2">2 Columns</option>
                        <option value="3">3 Columns</option>
                        <option value="4">4 Columns</option>
                        <option value="5">5 Columns</option>
                        <option value="6">6 Columns</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                        Text</label>
                    <input type="text"
                        class="grid-cta-text w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                        placeholder="e.g. Shop Now">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                        Link</label>
                    <input type="text"
                        class="grid-cta-link w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                        placeholder="/collections/all">
                </div>
            </div>

            <div class="space-y-8">
                <div class="grid-items-container space-y-8"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm"
                    onclick="addGridItem(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Grid Image</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-image_grid_item">
        <div
            class="grid-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.grid-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                            URL</label>
                        <div class="flex items-center gap-2">
                            <input type="text"
                                class="item-image flex-1 bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                placeholder="https://...">
                            <label
                                class="cursor-pointer h-12 px-6 flex items-center justify-center bg-gray-800 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-black/5">
                                Upload
                                <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Link
                            URL</label>
                        <input type="text"
                            class="item-link w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="Target Link">
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Alt
                            Text</label>
                        <input type="text"
                            class="item-alt w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="SEO Description">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                                Text</label>
                            <input type="text"
                                class="item-cta-text w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                placeholder="Shop Now">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Target</label>
                            <select
                                class="item-target w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                                <option value="_self">Same Tab</option>
                                <option value="_blank">New Tab</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template id="tpl-image_banner">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="image_banner">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Image Banner</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Standalone
                        high-impact visual</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                            URL</label>
                        <div class="flex items-center gap-2">
                            <input type="text"
                                class="banner-image flex-1 bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                placeholder="https://...">
                            <label
                                class="cursor-pointer h-12 px-6 flex items-center justify-center bg-violet-600 text-white rounded-xl text-xs font-black uppercase tracking-[0.1em] hover:bg-gray-900 transition-all active:scale-95 shadow-lg shadow-violet-500/10">
                                Upload
                                <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                            </label>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Object
                            Fit</label>
                        <select
                            class="banner-fit w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                            <option value="cover">Cover (Fill space, crop if needed)</option>
                            <option value="contain">Contain (Fit within space)</option>
                            <option value="fill">Fill (Stretch to fit)</option>
                            <option value="auto">Auto (Original aspect)</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Banner Text
                            Overlay</label>
                        <textarea
                            class="banner-text w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-sm font-bold text-gray-900 outline-none h-[120px]"
                            placeholder="Optional text associated with banner"></textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Text
                            Position</label>
                        <select
                            class="banner-text-position w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                            <option value="center">Center</option>
                            <option value="bottom">Bottom</option>
                            <option value="top">Top</option>
                            <option value="below">Below Image</option>
                        </select>
                    </div>
                </div>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-horizontal_scroll_cards">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="horizontal_scroll_cards">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Horizontal Scroll Cards</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Swipeable custom
                        card gallery</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                        Title</label>
                    <input type="text"
                        class="vscroll-title w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                        placeholder="e.g. Featured Brands">
                </div>
            </div>
            <div class="space-y-8">
                <div class="vscroll-cards-container space-y-8"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 transition-all shadow-sm"
                    onclick="addScrollCard(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Card</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-horizontal_scroll_card_item">
        <div
            class="vscroll-card bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.vscroll-card').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                            URL</label>
                        <div class="flex items-center gap-2">
                            <input type="text"
                                class="card-image flex-1 bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                placeholder="https://...">
                            <label
                                class="cursor-pointer h-12 px-6 flex items-center justify-center bg-gray-800 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-black/5">
                                Upload
                                <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Headline</label>
                        <input type="text"
                            class="card-headline w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                                Text</label>
                            <input type="text"
                                class="card-cta-text w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                                Link</label>
                            <input type="text"
                                class="card-cta-link w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none">
                        </div>
                    </div>
                </div>
                <div class="col-span-1 md:col-span-2 space-y-2">
                    <label
                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Paragraph</label>
                    <textarea
                        class="card-paragraph w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all outline-none h-20"></textarea>
                </div>
            </div>
        </div>
    </template>

    <template id="tpl-product_horizontal_scroll">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="product_horizontal_scroll">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Product Scroll</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Selected product
                        showcase</p>
                </div>
            </div>
            <div class="mb-10">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                    Title</label>
                <input type="text"
                    class="section-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                    placeholder="e.g. Hand-picked products">
            </div>
            <div class="space-y-8">
                <div class="product-scroll-container space-y-4"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm"
                    onclick="addScrollProduct(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Product</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-image_product_carousel">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="image_product_carousel">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Image & Product Carousel</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Split layout visual
                        showcase</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Left Block
                            Image</label>
                        <div class="flex items-center gap-2">
                            <input type="text"
                                class="carousel-image flex-1 bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                placeholder="https://...">
                            <label
                                class="cursor-pointer h-12 px-6 flex items-center justify-center bg-violet-600 text-white rounded-xl text-xs font-black uppercase tracking-[0.1em] hover:bg-gray-900 transition-all active:scale-95 shadow-lg shadow-violet-500/10">
                                Upload
                                <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 border-l border-gray-50 pl-12">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Right Block
                        Products</label>
                    <div class="product-scroll-container space-y-4 mb-6"></div>
                    <button type="button"
                        class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-black hover:text-black hover:bg-gray-50 transition-all shadow-sm"
                        onclick="addScrollProduct(this)">
                        <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Add Product</span>
                    </button>
                </div>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-product_scroll_item">
        <div
            class="product-item bg-gray-50 p-6 rounded-2xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-lg hover:shadow-black/5 flex items-center gap-6">
            <button type="button"
                class="absolute -top-2 -right-2 w-8 h-8 bg-white shadow-lg shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20"
                onclick="this.closest('.product-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex-1 space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Select
                    Product</label>
                <div class="relative">
                    <select
                        class="item-product-slug w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                        <option value="">-- Choose a Product --</option>
                        @if(isset($products) && $products->count() > 0)
                            @foreach($products as $product)
                                <option value="{{ $product->slug }}">{{ $product->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- ===================== NEW SECTION TEMPLATES ===================== --}}

    <template id="tpl-announcement_marquee">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="announcement_marquee">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Announcement Marquee</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Scrolling text
                        ticker</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Scroll
                        Speed</label>
                    <div class="relative">
                        <select
                            class="marquee-speed w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none appearance-none">
                            <option value="slow">Slow</option>
                            <option value="medium" selected>Medium</option>
                            <option value="fast">Fast</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Background
                        Color</label>
                    <input type="color"
                        class="marquee-bg-color h-[46px] w-full rounded-xl border-none bg-gray-50 p-1 cursor-pointer"
                        value="#000000">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Text
                        Color</label>
                    <input type="color"
                        class="marquee-text-color h-[46px] w-full rounded-xl border-none bg-gray-50 p-1 cursor-pointer"
                        value="#ffffff">
                </div>
            </div>
            <div class="space-y-8">
                <div class="marquee-items-container space-y-6"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-amber-500 hover:text-amber-600 hover:bg-amber-50 transition-all shadow-sm"
                    onclick="addMarqueeItem(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Announcement</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-marquee-item">
        <div
            class="marquee-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5 flex items-center gap-8">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.marquee-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="flex-1 space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Scrolling
                    Text</label>
                <input type="text"
                    class="item-marquee-text w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="e.g. Free Shipping on orders over $50">
            </div>
            <div class="flex-1 space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Link
                    (Optional)</label>
                <input type="text"
                    class="item-marquee-link w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="/collections/all">
            </div>
        </div>
    </template>

    <template id="tpl-feature_highlights">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="feature_highlights">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Feature Highlights</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Trust signals & key
                        benefits</p>
                </div>
            </div>

            <div class="mb-10">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Text Color</label>
                <div class="flex items-center gap-4 mt-2">
                    <input type="color"
                        class="hl-text-color h-12 w-24 rounded-xl border-none bg-gray-50 p-1 cursor-pointer"
                        value="#000000">
                    <span class="text-sm font-bold text-gray-700 uppercase tracking-widest">Pick a theme
                        color</span>
                </div>
            </div>

            <div class="space-y-8">
                <div class="highlights-items-container space-y-6"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm"
                    onclick="addHighlightItem(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Highlight</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-highlight-item">
        <div
            class="highlight-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5 grid grid-cols-1 md:grid-cols-3 gap-8">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.highlight-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Icon
                    (Emoji/SVG)</label>
                <input type="text"
                    class="item-hl-icon w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="🚚">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Label</label>
                <input type="text"
                    class="item-hl-label w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="Free Shipping">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Description</label>
                <input type="text"
                    class="item-hl-desc w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="On orders over $50">
            </div>
        </div>
    </template>

    <template id="tpl-category_grid">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="category_grid">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Category Grid</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Visual category
                        navigation</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                        Title</label>
                    <input type="text"
                        class="catgrid-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="Shop by Category">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Columns</label>
                    <div class="relative">
                        <select
                            class="catgrid-columns w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none appearance-none">
                            <option value="2">2 Columns</option>
                            <option value="3">3 Columns</option>
                            <option value="4" selected>4 Columns</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="catgrid-items-container space-y-6"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-sm font-black uppercase tracking-widest text-gray-700 hover:border-violet-500 hover:text-violet-600 hover:bg-violet-50 transition-all shadow-sm"
                    onclick="addCategoryItem(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Category</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-category-item">
        <div
            class="category-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5 grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.category-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image URL</label>
                <div class="flex items-center gap-2">
                    <input type="text"
                        class="item-cat-image flex-1 bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                        placeholder="https://...">
                    <label
                        class="cursor-pointer h-12 px-6 flex items-center justify-center bg-gray-800 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-black/5">
                        Upload
                        <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                    </label>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Category
                    Name</label>
                <input type="text"
                    class="item-cat-name w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="Tops">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Link</label>
                <input type="text"
                    class="item-cat-link w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                    placeholder="/collections/tops">
            </div>
        </div>
    </template>

    <template id="tpl-split_banner">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="split_banner">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center text-pink-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Split Banner</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Dual column content
                        block</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Visual
                            Content</label>
                        <div class="grid grid-cols-1 gap-6 bg-gray-50 p-8 rounded-3xl">
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                                    URL</label>
                                <div class="flex items-center gap-2">
                                    <input type="text"
                                        class="split-image flex-1 bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                        placeholder="https://...">
                                    <label
                                        class="cursor-pointer h-12 px-6 flex items-center justify-center bg-gray-800 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-black/5">
                                        Upload
                                        <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                                    </label>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Image
                                        Side</label>
                                    <select
                                        class="split-image-side w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Object
                                        Fit</label>
                                    <select
                                        class="split-object-fit w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                                        <option value="cover">Cover</option>
                                        <option value="contain">Contain</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Editorial
                            Content</label>
                        <div class="grid grid-cols-1 gap-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Badge</label>
                                    <input type="text"
                                        class="split-badge w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                        placeholder="New Arrival">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">BG
                                        Color</label>
                                    <input type="color"
                                        class="split-text-bg h-[46px] w-full rounded-xl border-none bg-gray-50 p-1 cursor-pointer"
                                        value="#ffffff">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Headline</label>
                                <input type="text"
                                    class="split-title w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                    placeholder="Bold Headline">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Subtitle</label>
                                <textarea
                                    class="split-subtitle w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none h-20"
                                    placeholder="Subheading text..."></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                                        Text</label>
                                    <input type="text"
                                        class="split-cta-text w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                        placeholder="Shop Now">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                                        Link</label>
                                    <input type="text"
                                        class="split-cta-link w-full bg-gray-50 border-none rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                        placeholder="/collections/new">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-newsletter_signup">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="newsletter_signup">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Newsletter Signup</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Email collection &
                        growth</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Headline</label>
                        <input type="text"
                            class="nl-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                            placeholder="Join the List">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Background
                            Style</label>
                        <div class="relative">
                            <select
                                class="nl-bg-style w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none appearance-none">
                                <option value="light">Light Minimal</option>
                                <option value="dark">Dark Premium</option>
                                <option value="image">Custom Image</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Description</label>
                        <textarea
                            class="nl-description w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none h-[115px]"
                            placeholder="Get early access to drops and exclusive discounts."></textarea>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Input
                        Placeholder</label>
                    <input type="text"
                        class="nl-placeholder w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="Enter your email">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Button
                        Text</label>
                    <input type="text"
                        class="nl-button-text w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="Subscribe">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Background Image
                    (Optional)</label>
                <div class="flex items-center gap-2">
                    <input type="text"
                        class="nl-bg-image flex-1 bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="https://...">
                    <label
                        class="cursor-pointer h-14 px-8 flex items-center justify-center bg-gray-800 text-white rounded-xl text-sm font-black uppercase tracking-widest hover:bg-gray-800 transition-all shadow-lg shadow-black/5">
                        Upload Image
                        <input type="file" class="hidden" accept="image/*" onchange="uploadImage(this)">
                    </label>
                </div>
            </div>

            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-video_banner">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="video_banner">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Video Banner</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Cinematic
                        background experience</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="md:col-span-2 space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Video Source
                        (MP4 URL)</label>
                    <input type="text"
                        class="vid-url w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="https://...video.mp4">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                        Height</label>
                    <div class="relative">
                        <select
                            class="vid-height w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none appearance-none">
                            <option value="small">Small (40vh)</option>
                            <option value="medium" selected>Medium (60vh)</option>
                            <option value="large">Large (80vh)</option>
                            <option value="fullscreen">Fullscreen</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Overlay
                            Branding</label>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="space-y-2">
                                <label
                                    class="text-[8px] font-bold text-gray-700 uppercase tracking-tighter">Title</label>
                                <input type="text"
                                    class="vid-title w-full bg-gray-50 border-none rounded-xl px-5 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                    placeholder="Bold Headline">
                            </div>
                            <div class="space-y-2">
                                <label
                                    class="text-[8px] font-bold text-gray-700 uppercase tracking-tighter">Subtitle</label>
                                <input type="text"
                                    class="vid-subtitle w-full bg-gray-50 border-none rounded-xl px-5 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                    placeholder="Supporting text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Call to
                            Action</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[8px] font-bold text-gray-700 uppercase tracking-tighter">Button
                                    Text</label>
                                <input type="text"
                                    class="vid-cta-text w-full bg-gray-50 border-none rounded-xl px-5 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                    placeholder="Shop Now">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[8px] font-bold text-gray-700 uppercase tracking-tighter">URL
                                    Link</label>
                                <input type="text"
                                    class="vid-cta-link w-full bg-gray-50 border-none rounded-xl px-5 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                                    placeholder="/collections/all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Visual
                    Settings</label>
                <div class="bg-gray-50 p-6 rounded-2xl flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-widest">Dark Overlay
                        Opacity</span>
                    <div class="flex items-center gap-4 w-1/3">
                        <input type="number"
                            class="vid-overlay w-full bg-white border border-gray-100 rounded-xl px-4 py-2 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            value="40" min="0" max="100">
                        <span class="text-sm font-bold text-gray-700 uppercase">%</span>
                    </div>
                </div>
            </div>

            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-testimonials_slider">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="testimonials_slider">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Testimonials Slider</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Community trust &
                        reviews</p>
                </div>
            </div>

            <div class="mb-10">
                <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Section
                    Title</label>
                <input type="text"
                    class="testimonials-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                    placeholder="What Our Customers Say">
            </div>

            <div class="space-y-8">
                <div class="testimonials-items-container space-y-6"></div>
                <button type="button"
                    class="group h-14 w-full flex items-center justify-center gap-3 border-2 border-dashed border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-700 hover:border-orange-500 hover:text-orange-600 hover:bg-orange-50 transition-all shadow-sm"
                    onclick="addTestimonialItem(this)">
                    <svg class="w-4 h-4 transition-transform group-hover:scale-125" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Review</span>
                </button>
            </div>
            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <template id="tpl-testimonial-item">
        <div
            class="testimonial-item bg-gray-50/50 p-8 rounded-3xl border border-gray-100 relative group/item transition-all duration-300 hover:bg-white hover:shadow-xl hover:shadow-black/5">
            <button type="button"
                class="absolute -top-3 -right-3 w-10 h-10 bg-white shadow-xl shadow-black/5 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 opacity-0 group-hover/item:opacity-100 transition-all border border-gray-50 z-20 shadow-sm"
                onclick="this.closest('.testimonial-item').remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="grid grid-cols-1 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Quote</label>
                    <textarea
                        class="item-t-quote w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all outline-none h-24"
                        placeholder="Amazing product, love it!"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Name</label>
                        <input type="text"
                            class="item-t-name w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="Jane Doe">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Role /
                            Location</label>
                        <input type="text"
                            class="item-t-role w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="Verified Buyer">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Rating</label>
                        <div class="relative">
                            <select
                                class="item-t-rating w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none appearance-none">
                                <option value="5" selected>5 ★ Rating</option>
                                <option value="4">4 ★ Rating</option>
                                <option value="3">3 ★ Rating</option>
                                <option value="2">2 ★ Rating</option>
                                <option value="1">1 ★ Rating</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Avatar URL
                            (optional)</label>
                        <input type="text"
                            class="item-t-avatar w-full bg-white border border-gray-100 rounded-xl px-4 py-3 text-xs font-bold text-gray-900 focus:ring-2 focus:ring-violet-500/20 transition-all outline-none"
                            placeholder="Avatar URL">
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template id="tpl-countdown_timer">
        <div class="builder-section bg-white rounded-[2.5rem] border border-gray-100 p-12 relative group transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.04)]"
            data-type="countdown_timer">
            @include('admin.pages.partials.builder_controls')
            <div class="flex items-center gap-4 mb-10 border-b border-gray-50 pb-8">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Countdown Timer</h3>
                    <p class="text-sm font-bold text-gray-700 mt-0.5 uppercase tracking-tighter">Urgency & sale
                        highlights</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label
                            class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Headline</label>
                        <input type="text"
                            class="cd-title w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                            placeholder="Sale Ends In">
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">End Date &
                            Time</label>
                        <input type="datetime-local"
                            class="cd-end-date w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none">
                    </div>
                </div>
            </div>

            <div class="space-y-6 mb-10">
                <div class="space-y-2">
                    <label
                        class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Description</label>
                    <textarea
                        class="cd-description w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none h-20"
                        placeholder="Don't miss out on these limited prices"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                        Text</label>
                    <input type="text"
                        class="cd-cta-text w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="Shop the Sale">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">CTA
                        Link</label>
                    <input type="text"
                        class="cd-cta-link w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none"
                        placeholder="/collections/sale">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-black uppercase tracking-[0.15em] text-gray-700 ml-1">Style</label>
                    <div class="relative">
                        <select
                            class="cd-bg-style w-full bg-gray-50 border-none rounded-xl px-5 py-4 text-sm font-bold text-gray-900 outline-none appearance-none">
                            <option value="light">Light Minimal</option>
                            <option value="dark">Dark High Contrast</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.pages.partials.builder_section_settings')
        </div>
    </template>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Use existing Create/Edit page JS logic here, adapted for standalone
        const container = document.getElementById('builder-container');
        const emptyMsg = document.getElementById('empty-builder-msg');

        // Setup Builder logic helper functions first

        function addSection(type, data = null, settings = null) {
            emptyMsg.style.display = 'none';
            const tpl = document.getElementById('tpl-' + type);
            if (!tpl) return;

            const clone = tpl.content.cloneNode(true);
            container.appendChild(clone);
            const lastSection = container.lastElementChild;

            if (type === 'text_block') {
                const editorEl = lastSection.querySelector('.quill-editor');
                const quill = new Quill(editorEl, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'font': [] }, { 'size': [] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'sub' }, { 'script': 'super' }],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }, { 'align': [] }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });
                if (data && data.content) {
                    quill.root.innerHTML = data.content;
                }
                editorEl._quill = quill;
                quill.on('text-change', triggerAutoSave);
            }

            if (type === 'hero_slider') {
                if (data && data.slides) {
                    data.slides.forEach(slide => addSlide(lastSection.querySelector('button[onclick="addSlide(this)"]'), slide));
                } else {
                    addSlide(lastSection.querySelector('button[onclick="addSlide(this)"]'));
                }
            }

            if (type === 'product_carousel') {
                if (data) {
                    lastSection.querySelector('.section-title').value = data.title || '';
                    lastSection.querySelector('.section-collection').value = data.collection || 'new_arrivals';
                    lastSection.querySelector('.section-limit').value = data.limit || 8;
                }
            }

            if (type === 'product_horizontal_scroll') {
                if (data) {
                    lastSection.querySelector('.section-title').value = data.title || '';
                    if (data.product_slugs) {
                        data.product_slugs.forEach(slug => addScrollProduct(lastSection.querySelector('button[onclick="addScrollProduct(this)"]'), slug));
                    }
                } else {
                    addScrollProduct(lastSection.querySelector('button[onclick="addScrollProduct(this)"]'));
                }
            }

            if (type === 'image_product_carousel') {
                if (data) {
                    lastSection.querySelector('.carousel-image').value = data.image || '';
                    if (lastSection.querySelector('.carousel-image-fit')) {
                        lastSection.querySelector('.carousel-image-fit').value = data.object_fit || 'cover';
                    }
                    if (data.product_slugs) {
                        data.product_slugs.forEach(slug => addScrollProduct(lastSection.querySelector('button[onclick="addScrollProduct(this)"]'), slug));
                    }
                } else {
                    addScrollProduct(lastSection.querySelector('button[onclick="addScrollProduct(this)"]'));
                }
            }

            if (type === 'image_grid') {
                if (data) {
                    lastSection.querySelector('.grid-title').value = data.title || '';
                    lastSection.querySelector('.grid-columns').value = data.columns || '4';
                    lastSection.querySelector('.grid-text').value = data.text || '';
                    lastSection.querySelector('.grid-cta-text').value = data.cta_text || '';
                    lastSection.querySelector('.grid-cta-link').value = data.cta_link || '';
                    if (lastSection.querySelector('.grid-hover-animation')) lastSection.querySelector('.grid-hover-animation').value = data.hover_animation || 'zoom';
                    if (data.images) {
                        data.images.forEach(img => addGridItem(lastSection.querySelector('button[onclick="addGridItem(this)"]'), img));
                    }
                } else {
                    addGridItem(lastSection.querySelector('button[onclick="addGridItem(this)"]'));
                }
            }

            if (type === 'image_banner') {
                if (data) {
                    lastSection.querySelector('.banner-image').value = data.image || '';
                    lastSection.querySelector('.banner-fit').value = data.object_fit || 'cover';
                    lastSection.querySelector('.banner-text').value = data.text || '';
                    lastSection.querySelector('.banner-text-position').value = data.text_position || 'center';
                }
            }

            if (type === 'horizontal_scroll_cards') {
                if (data) {
                    lastSection.querySelector('.vscroll-title').value = data.title || '';
                    if (lastSection.querySelector('.hscroll-hover-animation')) {
                        lastSection.querySelector('.hscroll-hover-animation').value = data.hover_animation || 'zoom';
                    }
                    if (data.cards) {
                        data.cards.forEach(card => addScrollCard(lastSection.querySelector('button[onclick="addScrollCard(this)"]'), card));
                    }
                } else {
                    addScrollCard(lastSection.querySelector('button[onclick="addScrollCard(this)"]'));
                }
            }

            if (type === 'announcement_marquee') {
                if (data) {
                    lastSection.querySelector('.marquee-speed').value = data.speed || 'medium';
                    lastSection.querySelector('.marquee-bg-color').value = data.bg_color || '#000000';
                    lastSection.querySelector('.marquee-text-color').value = data.text_color || '#ffffff';
                    if (data.items) {
                        data.items.forEach(item => addMarqueeItem(lastSection.querySelector('button[onclick="addMarqueeItem(this)"]'), item));
                    }
                } else {
                    addMarqueeItem(lastSection.querySelector('button[onclick="addMarqueeItem(this)"]'));
                }
            }

            if (type === 'feature_highlights') {
                if (data) {
                    lastSection.querySelector('.hl-text-color').value = data.text_color || '#000000';
                }
                if (data && data.items) {
                    data.items.forEach(item => addHighlightItem(lastSection.querySelector('button[onclick="addHighlightItem(this)"]'), item));
                } else {
                    addHighlightItem(lastSection.querySelector('button[onclick="addHighlightItem(this)"]'));
                }
            }

            if (type === 'category_grid') {
                if (data) {
                    lastSection.querySelector('.catgrid-title').value = data.title || '';
                    lastSection.querySelector('.catgrid-columns').value = data.columns || '4';
                    if (data.categories) {
                        data.categories.forEach(item => addCategoryItem(lastSection.querySelector('button[onclick="addCategoryItem(this)"]'), item));
                    }
                } else {
                    addCategoryItem(lastSection.querySelector('button[onclick="addCategoryItem(this)"]'));
                }
            }

            if (type === 'split_banner' && data) {
                lastSection.querySelector('.split-image').value = data.image || '';
                lastSection.querySelector('.split-image-side').value = data.image_side || 'left';
                lastSection.querySelector('.split-object-fit').value = data.object_fit || 'cover';
                lastSection.querySelector('.split-badge').value = data.badge || '';
                lastSection.querySelector('.split-title').value = data.title || '';
                lastSection.querySelector('.split-text-bg').value = data.text_bg || '#ffffff';
                lastSection.querySelector('.split-subtitle').value = data.subtitle || '';
                lastSection.querySelector('.split-cta-text').value = data.cta_text || '';
                lastSection.querySelector('.split-cta-link').value = data.cta_link || '';
            }

            if (type === 'newsletter_signup' && data) {
                lastSection.querySelector('.nl-title').value = data.title || '';
                lastSection.querySelector('.nl-bg-style').value = data.bg_style || 'light';
                lastSection.querySelector('.nl-description').value = data.description || '';
                lastSection.querySelector('.nl-placeholder').value = data.placeholder || '';
                lastSection.querySelector('.nl-button-text').value = data.button_text || '';
                lastSection.querySelector('.nl-bg-image').value = data.bg_image || '';
            }

            if (type === 'video_banner' && data) {
                lastSection.querySelector('.vid-url').value = data.video_url || '';
                lastSection.querySelector('.vid-height').value = data.height || 'medium';
                lastSection.querySelector('.vid-overlay').value = data.overlay_opacity || '40';
                lastSection.querySelector('.vid-title').value = data.title || '';
                lastSection.querySelector('.vid-subtitle').value = data.subtitle || '';
                lastSection.querySelector('.vid-cta-text').value = data.cta_text || '';
                lastSection.querySelector('.vid-cta-link').value = data.cta_link || '';
            }

            if (type === 'testimonials_slider') {
                if (data) {
                    lastSection.querySelector('.testimonials-title').value = data.title || '';
                    if (data.testimonials) {
                        data.testimonials.forEach(item => addTestimonialItem(lastSection.querySelector('button[onclick="addTestimonialItem(this)"]'), item));
                    }
                } else {
                    addTestimonialItem(lastSection.querySelector('button[onclick="addTestimonialItem(this)"]'));
                }
            }

            if (type === 'countdown_timer' && data) {
                lastSection.querySelector('.cd-title').value = data.title || '';
                lastSection.querySelector('.cd-end-date').value = data.end_date || '';
                lastSection.querySelector('.cd-description').value = data.description || '';
                lastSection.querySelector('.cd-cta-text').value = data.cta_text || '';
                lastSection.querySelector('.cd-cta-link').value = data.cta_link || '';
                lastSection.querySelector('.cd-bg-style').value = data.bg_style || 'light';
            }

            if (settings) {
                if (settings.bg_color) {
                    const bgCheck = lastSection.querySelector('.section-has-bg');
                    const bgPick = lastSection.querySelector('.section-bg-color');
                    if (bgCheck && bgPick) {
                        bgCheck.checked = true;
                        bgPick.value = settings.bg_color;
                        bgPick.classList.remove('hidden');
                    }
                }
                if (settings.padding && lastSection.querySelector('.section-padding')) {
                    lastSection.querySelector('.section-padding').value = settings.padding;
                }
                if (settings.show_mobile !== undefined && lastSection.querySelector('.section-show-mobile')) {
                    lastSection.querySelector('.section-show-mobile').checked = settings.show_mobile;
                }
                if (settings.show_desktop !== undefined && lastSection.querySelector('.section-show-desktop')) {
                    lastSection.querySelector('.section-show-desktop').checked = settings.show_desktop;
                }
            }
        }

        function addScrollProduct(btn, slug = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-product_scroll_item');
            const clone = tpl.content.cloneNode(true);
            if (slug) {
                clone.querySelector('.item-product-slug').value = slug;
            }
            container.appendChild(clone);
        }

        function addSlide(btn, slideData = null) {
            const slidesContainer = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-slide-item');
            const clone = tpl.content.cloneNode(true);

            if (slideData) {
                const el = clone.querySelector('.slide-item');
                if (el.querySelector('.slide-image')) el.querySelector('.slide-image').value = slideData.image || '';
                if (el.querySelector('.slide-link')) el.querySelector('.slide-link').value = slideData.link || '';
                if (el.querySelector('.slide-title')) el.querySelector('.slide-title').value = slideData.title || '';
                if (el.querySelector('.slide-subtitle')) el.querySelector('.slide-subtitle').value = slideData.subtitle || '';
            }
            slidesContainer.appendChild(clone);
        }

        function addGridItem(btn, itemData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-image_grid_item');
            const clone = tpl.content.cloneNode(true);
            if (itemData) {
                if (clone.querySelector('.item-image')) clone.querySelector('.item-image').value = itemData.image || '';
                if (clone.querySelector('.item-link')) clone.querySelector('.item-link').value = itemData.link || '';
                if (clone.querySelector('.item-alt')) clone.querySelector('.item-alt').value = itemData.alt || '';
                if (clone.querySelector('.item-cta-text')) clone.querySelector('.item-cta-text').value = itemData.cta_text || '';
                if (clone.querySelector('.item-cta-style')) clone.querySelector('.item-cta-style').value = itemData.cta_style || 'pill_overlay';
                if (clone.querySelector('.item-target')) clone.querySelector('.item-target').value = itemData.target || '_self';
            }
            container.appendChild(clone);
        }

        function addScrollCard(btn, cardData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-horizontal_scroll_card_item');
            const clone = tpl.content.cloneNode(true);
            if (cardData) {
                clone.querySelector('.card-image').value = cardData.image || '';
                clone.querySelector('.card-headline').value = cardData.headline || '';
                clone.querySelector('.card-paragraph').value = cardData.paragraph || '';
                clone.querySelector('.card-cta-text').value = cardData.cta_text || '';
                clone.querySelector('.card-cta-link').value = cardData.cta_link || '';
            }
            container.appendChild(clone);
        }

        function addMarqueeItem(btn, itemData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-marquee-item');
            if (!tpl) return;
            const clone = tpl.content.cloneNode(true);
            if (itemData) {
                clone.querySelector('.item-marquee-text').value = itemData.text || '';
                clone.querySelector('.item-marquee-link').value = itemData.link || '';
            }
            container.appendChild(clone);
        }

        function addHighlightItem(btn, itemData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-highlight-item');
            if (!tpl) return;
            const clone = tpl.content.cloneNode(true);
            if (itemData) {
                clone.querySelector('.item-hl-icon').value = itemData.icon || '';
                clone.querySelector('.item-hl-label').value = itemData.label || '';
                clone.querySelector('.item-hl-desc').value = itemData.desc || '';
            }
            container.appendChild(clone);
        }

        function addCategoryItem(btn, itemData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-category-item');
            if (!tpl) return;
            const clone = tpl.content.cloneNode(true);
            if (itemData) {
                clone.querySelector('.item-cat-image').value = itemData.image || '';
                clone.querySelector('.item-cat-name').value = itemData.name || '';
                clone.querySelector('.item-cat-link').value = itemData.link || '';
            }
            container.appendChild(clone);
        }

        function addTestimonialItem(btn, itemData = null) {
            const container = btn.previousElementSibling;
            const tpl = document.getElementById('tpl-testimonial-item');
            if (!tpl) return;
            const clone = tpl.content.cloneNode(true);
            if (itemData) {
                clone.querySelector('.item-t-quote').value = itemData.quote || '';
                clone.querySelector('.item-t-name').value = itemData.name || '';
                clone.querySelector('.item-t-role').value = itemData.role || '';
                clone.querySelector('.item-t-rating').value = itemData.rating || '5';
                clone.querySelector('.item-t-avatar').value = itemData.avatar || '';
            }
            container.appendChild(clone);
        }

        function toggleSectionSettings(btn) {
            const body = btn.nextElementSibling;
            const chevron = btn.querySelector('.section-settings-chevron');
            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (chevron) chevron.classList.add('rotate-180');
            } else {
                body.classList.add('hidden');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        function toggleBgPicker(checkbox) {
            const wrapper = checkbox.closest('.space-y-3').querySelector('.section-bg-picker-wrapper');
            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
            triggerAutoSave();
        }

        function moveUp(btn) {
            const section = btn.closest('.builder-section');
            const prev = section.previousElementSibling;
            if (prev && prev.id !== 'empty-builder-msg') {
                section.parentNode.insertBefore(section, prev);
            }
        }

        function moveDown(btn) {
            const section = btn.closest('.builder-section');
            const next = section.nextElementSibling;
            if (next) {
                section.parentNode.insertBefore(next, section);
            }
        }

        function removeSection(btn) {
            if (confirm('Delete this section?')) {
                btn.closest('.builder-section').remove();
                if (container.children.length <= 1) {
                    emptyMsg.style.display = 'block';
                }
            }
        }

        // Auto-save logic
        let autoSaveTimeout;
        const autoSaveStatus = document.getElementById('save-status');

        function triggerAutoSave() {
            clearTimeout(autoSaveTimeout);

            autoSaveTimeout = setTimeout(() => {
                try {
                    // Show indicator only when actual saving starts
                    if (autoSaveStatus) {
                        autoSaveStatus.innerText = 'Saving...';
                        autoSaveStatus.classList.remove('opacity-0');
                        autoSaveStatus.classList.add('opacity-100');
                        autoSaveStatus.classList.remove('text-red-500');
                    }

                    const sections = collectSectionsData();
                    const content = JSON.stringify(sections);

                    fetch('{{ route("admin.online-store.mnpages.auto-save", $mnpage) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ content: content })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && autoSaveStatus) {
                                autoSaveStatus.innerText = 'Saved';
                                setTimeout(() => {
                                    autoSaveStatus.classList.remove('opacity-100');
                                    autoSaveStatus.classList.add('opacity-0');
                                }, 2000);
                            }
                        })
                        .catch(err => {
                            console.error('Auto-save fetch failed', err);
                            if (autoSaveStatus) {
                                autoSaveStatus.innerText = 'Save Failed';
                                autoSaveStatus.classList.add('text-red-500');
                            }
                        });
                } catch (e) {
                    console.error('Auto-save error during collection:', e);
                    if (autoSaveStatus) {
                        autoSaveStatus.innerText = 'Error in Layout';
                        autoSaveStatus.classList.remove('opacity-0');
                        autoSaveStatus.classList.add('text-red-500');
                    }
                }
            }, 1000); // Debounce 1s
        }

        // Attach listeners for auto-save
        container.addEventListener('input', triggerAutoSave);
        container.addEventListener('change', triggerAutoSave);
        // Mutation observer to detect DOM changes (adding/removing sections)
        const observer = new MutationObserver(triggerAutoSave);
        observer.observe(container, { childList: true, subtree: true });


        // Collect sections data helper
        function collectSectionsData() {
            const sections = [];

            document.querySelectorAll('.builder-section').forEach(section => {
                const type = section.dataset.type;
                let data = {};

                if (type === 'hero_slider') {
                    data.slides = [];
                    section.querySelectorAll('.slide-item').forEach(slide => {
                        data.slides.push({
                            image: slide.querySelector('.slide-image')?.value || '',
                            link: slide.querySelector('.slide-link')?.value || '',
                            title: slide.querySelector('.slide-title')?.value || '',
                            subtitle: slide.querySelector('.slide-subtitle')?.value || '',
                        });
                    });
                } else if (type === 'product_carousel') {
                    data.title = section.querySelector('.section-title')?.value || '';
                    data.collection = section.querySelector('.section-collection')?.value || '';
                    data.limit = section.querySelector('.section-limit')?.value || '';
                } else if (type === 'product_horizontal_scroll') {
                    data.title = section.querySelector('.section-title')?.value || '';
                    data.product_slugs = [];
                    section.querySelectorAll('.product-item').forEach(item => {
                        const val = item.querySelector('.item-product-slug')?.value || '';
                        if (val) data.product_slugs.push(val);
                    });
                } else if (type === 'image_product_carousel') {
                    data.image = section.querySelector('.carousel-image')?.value || '';
                    data.object_fit = section.querySelector('.carousel-image-fit') ? section.querySelector('.carousel-image-fit')?.value || '' : 'cover';
                    data.product_slugs = [];
                    section.querySelectorAll('.product-item').forEach(item => {
                        const val = item.querySelector('.item-product-slug')?.value || '';
                        if (val) data.product_slugs.push(val);
                    });
                } else if (type === 'text_block') {
                    const editorEl = section.querySelector('.quill-editor');
                    if (editorEl && editorEl._quill) {
                        data.content = editorEl._quill.root.innerHTML;
                    } else {
                        data.content = '';
                    }
                } else if (type === 'image_grid') {
                    data.title = section.querySelector('.grid-title')?.value || '';
                    data.columns = section.querySelector('.grid-columns')?.value || '';
                    data.text = section.querySelector('.grid-text')?.value || '';
                    data.cta_text = section.querySelector('.grid-cta-text')?.value || '';
                    data.cta_link = section.querySelector('.grid-cta-link')?.value || '';
                    data.hover_animation = section.querySelector('.grid-hover-animation') ? section.querySelector('.grid-hover-animation')?.value || '' : 'zoom';
                    data.images = [];
                    section.querySelectorAll('.grid-item').forEach(item => {
                        data.images.push({
                            image: item.querySelector('.item-image') ? item.querySelector('.item-image')?.value || '' : '',
                            link: item.querySelector('.item-link') ? item.querySelector('.item-link')?.value || '' : '',
                            alt: item.querySelector('.item-alt') ? item.querySelector('.item-alt')?.value || '' : '',
                            cta_text: item.querySelector('.item-cta-text') ? item.querySelector('.item-cta-text')?.value || '' : '',
                            cta_style: item.querySelector('.item-cta-style') ? item.querySelector('.item-cta-style')?.value || '' : 'pill_overlay',
                            target: item.querySelector('.item-target') ? item.querySelector('.item-target')?.value || '' : '_self',
                        });
                    });
                } else if (type === 'image_banner') {
                    data.image = section.querySelector('.banner-image')?.value || '';
                    data.object_fit = section.querySelector('.banner-fit')?.value || '';
                    data.text = section.querySelector('.banner-text')?.value || '';
                    data.text_position = section.querySelector('.banner-text-position')?.value || '';
                } else if (type === 'horizontal_scroll_cards') {
                    data.title = section.querySelector('.vscroll-title')?.value || '';
                    data.hover_animation = section.querySelector('.hscroll-hover-animation') ? section.querySelector('.hscroll-hover-animation')?.value || '' : 'zoom';
                    data.cards = [];
                    section.querySelectorAll('.vscroll-card').forEach(card => {
                        data.cards.push({
                            image: card.querySelector('.card-image')?.value || '',
                            headline: card.querySelector('.card-headline')?.value || '',
                            paragraph: card.querySelector('.card-paragraph')?.value || '',
                            cta_text: card.querySelector('.card-cta-text')?.value || '',
                            cta_link: card.querySelector('.card-cta-link')?.value || '',
                        });
                    });
                } else if (type === 'announcement_marquee') {
                    data.speed = section.querySelector('.marquee-speed')?.value || '';
                    data.bg_color = section.querySelector('.marquee-bg-color')?.value || '';
                    data.text_color = section.querySelector('.marquee-text-color')?.value || '';
                    data.items = [];
                    section.querySelectorAll('.marquee-item').forEach(item => {
                        data.items.push({
                            text: item.querySelector('.item-marquee-text')?.value || '',
                            link: item.querySelector('.item-marquee-link')?.value || ''
                        });
                    });
                } else if (type === 'feature_highlights') {
                    data.text_color = section.querySelector('.hl-text-color') ? section.querySelector('.hl-text-color')?.value || '' : '#000000';
                    data.items = [];
                    section.querySelectorAll('.highlight-item').forEach(item => {
                        data.items.push({
                            icon: item.querySelector('.item-hl-icon')?.value || '',
                            label: item.querySelector('.item-hl-label')?.value || '',
                            desc: item.querySelector('.item-hl-desc')?.value || ''
                        });
                    });
                } else if (type === 'category_grid') {
                    data.title = section.querySelector('.catgrid-title')?.value || '';
                    data.columns = section.querySelector('.catgrid-columns')?.value || '';
                    data.categories = [];
                    section.querySelectorAll('.category-item').forEach(item => {
                        data.categories.push({
                            image: item.querySelector('.item-cat-image')?.value || '',
                            name: item.querySelector('.item-cat-name')?.value || '',
                            link: item.querySelector('.item-cat-link')?.value || ''
                        });
                    });
                } else if (type === 'split_banner') {
                    data.image = section.querySelector('.split-image')?.value || '';
                    data.image_side = section.querySelector('.split-image-side')?.value || '';
                    data.object_fit = section.querySelector('.split-object-fit')?.value || '';
                    data.badge = section.querySelector('.split-badge')?.value || '';
                    data.title = section.querySelector('.split-title')?.value || '';
                    data.text_bg = section.querySelector('.split-text-bg')?.value || '';
                    data.subtitle = section.querySelector('.split-subtitle')?.value || '';
                    data.cta_text = section.querySelector('.split-cta-text')?.value || '';
                    data.cta_link = section.querySelector('.split-cta-link')?.value || '';
                } else if (type === 'newsletter_signup') {
                    data.title = section.querySelector('.nl-title')?.value || '';
                    data.bg_style = section.querySelector('.nl-bg-style')?.value || '';
                    data.description = section.querySelector('.nl-description')?.value || '';
                    data.placeholder = section.querySelector('.nl-placeholder')?.value || '';
                    data.button_text = section.querySelector('.nl-button-text')?.value || '';
                    data.bg_image = section.querySelector('.nl-bg-image')?.value || '';
                } else if (type === 'video_banner') {
                    data.video_url = section.querySelector('.vid-url')?.value || '';
                    data.height = section.querySelector('.vid-height')?.value || '';
                    data.overlay_opacity = section.querySelector('.vid-overlay')?.value || '';
                    data.title = section.querySelector('.vid-title')?.value || '';
                    data.subtitle = section.querySelector('.vid-subtitle')?.value || '';
                    data.cta_text = section.querySelector('.vid-cta-text')?.value || '';
                    data.cta_link = section.querySelector('.vid-cta-link')?.value || '';
                } else if (type === 'testimonials_slider') {
                    data.title = section.querySelector('.testimonials-title')?.value || '';
                    data.testimonials = [];
                    section.querySelectorAll('.testimonial-item').forEach(item => {
                        data.testimonials.push({
                            quote: item.querySelector('.item-t-quote')?.value || '',
                            name: item.querySelector('.item-t-name')?.value || '',
                            role: item.querySelector('.item-t-role')?.value || '',
                            rating: item.querySelector('.item-t-rating')?.value || '',
                            avatar: item.querySelector('.item-t-avatar')?.value || ''
                        });
                    });
                } else if (type === 'countdown_timer') {
                    data.title = section.querySelector('.cd-title')?.value || '';
                    data.end_date = section.querySelector('.cd-end-date')?.value || '';
                    data.description = section.querySelector('.cd-description')?.value || '';
                    data.cta_text = section.querySelector('.cd-cta-text')?.value || '';
                    data.cta_link = section.querySelector('.cd-cta-link')?.value || '';
                    data.bg_style = section.querySelector('.cd-bg-style')?.value || '';
                }

                let settings = {};
                const hasBg = section.querySelector('.section-has-bg');
                if (hasBg && hasBg.checked) {
                    settings.bg_color = section.querySelector('.section-bg-color')?.value || '';
                }
                const paddingSel = section.querySelector('.section-padding');
                if (paddingSel) {
                    settings.padding = paddingSel.value;
                }
                const mobileCheck = section.querySelector('.section-show-mobile');
                if (mobileCheck) {
                    settings.show_mobile = mobileCheck.checked;
                }
                const desktopCheck = section.querySelector('.section-show-desktop');
                if (desktopCheck) {
                    settings.show_desktop = desktopCheck.checked;
                }

                sections.push({ type: type, data: data, settings: settings });
            });
            return sections;
        }

        // Publish button handles saving — no form submit needed here.

        function publishChanges() {
            if (!confirm('Are you sure you want to publish these changes to the live site?')) return;

            const sections = collectSectionsData();

            fetch('{{ route("admin.online-store.mnpages.publish", $mnpage) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ content: JSON.stringify(sections) })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Published successfully!');
                        window.location.reload();
                    } else {
                        alert('Publish failed.');
                    }
                })
                .catch(error => {
                    console.error('Publish error:', error);
                    alert('Publish failed due to an error.');
                });
        }

        function uploadImage(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('image', input.files[0]);

                // Show loading state safely
                const label = input.closest('label');
                const span = label.querySelector('span');
                let originalText = 'Upload';
                if (span) {
                    originalText = span.innerText;
                    span.innerText = '...';
                } else {
                    // Fallback if no span wrapper exists
                    originalText = label.childNodes[0].nodeValue || 'Upload';
                    if (label.childNodes[0].nodeType === 3) {
                        label.childNodes[0].nodeValue = '... ';
                    }
                }

                fetch('{{ route("admin.online-store.mnpages.upload-image") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find the text input for image URL and set value.
                            // We use label.parentElement because the upload <label> itself has class="flex",
                            // so input.closest('.flex') would wrongly match the label, not the outer wrapper div.
                            const urlInput = label.parentElement.querySelector('input[type="text"]');
                            if (urlInput) {
                                urlInput.value = data.url;
                                triggerAutoSave(); // Save after upload
                            }
                        } else {
                            alert('Upload failed: ' + (data.error || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Upload failed');
                    })
                    .finally(() => {
                        if (span) {
                            span.innerText = originalText;
                        } else if (label.childNodes[0].nodeType === 3) {
                            label.childNodes[0].nodeValue = originalText;
                        }
                        input.value = ''; // Reset file input
                    });
            }
        }

        // Initialize Sortable
        new Sortable(container, {
            animation: 150,
            ghostClass: 'bg-indigo-50',
            handle: '.cursor-move',
            onEnd: function () {
                triggerAutoSave();
            }
        });

        // Initial Hydration
        document.addEventListener('DOMContentLoaded', function () {
            let initialContent = @json($mnpage->draft_content ?? $mnpage->content ?? []);

            // If the content is just the metadata block, fallback to published content
            if (initialContent.length === 1 && initialContent[0].type === 'page_meta') {
                initialContent = @json($mnpage->content ?? []);
            }

            console.log('Hydrating builder with:', initialContent);
            if (initialContent && Array.isArray(initialContent) && initialContent.length > 0) {
                initialContent.forEach(section => {
                    if (section.type === 'page_meta') return; // Skip layout metadata in builder
                    try {
                        addSection(section.type, section.data, section.settings);
                    } catch (e) {
                        console.error('Error hydrating section:', section.type, e);
                    }
                });
            }
        });
    </script>
</body>

</html>