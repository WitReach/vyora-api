<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dope Style Admin</title>
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
    @stack('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body class="bg-[#FBFBFC] font-sans antialiased text-gray-900">
    <div class="min-h-screen flex">
        <!-- Premium Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed inset-y-0 z-50">
            <div class="h-20 flex items-center px-6 border-b border-gray-50 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-black rounded-xl flex items-center justify-center shadow-lg shadow-black/10">
                        <span class="text-white font-black text-[10px]">O</span>
                    </div>
                    <h1 class="text-xs font-black tracking-[0.2em] uppercase">OCC Admin</h1>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-8 overflow-y-auto py-4">
                {{-- Global Module --}}
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white shadow-lg shadow-black/10 font-bold' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] uppercase tracking-[0.1em]">Dashboard</span>
                    </a>
                </div>

                {{-- Inventory Module --}}
                <div class="space-y-4 pt-6 mt-6 border-t border-gray-50">
                    <p class="px-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-900/40">Inventory</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.products.index') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.products.index') ? 'bg-violet-600' : 'bg-gray-300' }}"></div>
                            <span class="text-xs uppercase tracking-widest">All Products</span>
                        </a>
                        <a href="{{ route('admin.upload') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.upload') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.upload') ? 'bg-violet-600' : 'bg-gray-300' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Upload Items</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.categories.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.categories.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Categories</span>
                        </a>
                        <a href="{{ route('admin.collections.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.collections.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.collections.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Collections</span>
                        </a>
                        <a href="{{ route('admin.attributes.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.attributes.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.attributes.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Product Types & Attributes</span>
                        </a>
                    </div>
                </div>

                {{-- Online Store Module --}}
                <div class="space-y-4 pt-6 mt-6 border-t border-gray-50">
                    <p class="px-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-900/40">Online Store</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.online-store.theme-settings.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.theme-settings.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.theme-settings.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Theme Settings</span>
                        </a>
                        <a href="{{ route('admin.online-store.product-card-settings.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.product-card-settings.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.product-card-settings.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Product Card Design</span>
                        </a>
                        <a href="{{ route('admin.online-store.pdp-settings.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.pdp-settings.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.pdp-settings.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">PDP Page Design</span>
                        </a>
                        <a href="{{ route('admin.online-store.mnpages.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.mnpages.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.mnpages.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Customise</span>
                        </a>
                    </div>
                </div>

                {{-- Settings Module --}}
                <div class="space-y-4 pt-6 mt-6 border-t border-gray-50">
                    <p class="px-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-900/40">Settings</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.online-store.general-settings.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.general-settings.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.general-settings.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">General Settings</span>
                        </a>
                        <a href="{{ route('admin.online-store.policy-settings.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.policy-settings.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.policy-settings.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Shipping & Returns (PDP)</span>
                        </a>
                        <a href="{{ route('admin.online-store.coupons.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.online-store.coupons.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.online-store.coupons.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Discount & Coupons</span>
                        </a>
                    </div>
                </div>

                {{-- Management Module --}}
                <div class="space-y-4 pt-6 mt-6 border-t border-gray-50">
                    <p class="px-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-900/40">Management</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex items-center gap-4 px-6 py-3 rounded-2xl transition-all {{ request()->routeIs('admin.orders.*') ? 'text-black bg-gray-50 font-black' : 'text-gray-600 hover:text-black hover:bg-gray-50 font-semibold' }}">
                            <div class="w-2 h-2 rounded-full {{ request()->routeIs('admin.orders.*') ? 'bg-violet-600' : 'bg-gray-200' }}"></div>
                            <span class="text-xs uppercase tracking-widest">Orders</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-5 border-t border-gray-50 bg-[#FBFBFC]/50 backdrop-blur-sm">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-between px-5 py-3.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all group">
                        <span class="text-[9px] font-black uppercase tracking-widest">Logout</span>
                        <svg class="w-3.5 h-3.5 text-red-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 ml-64 flex flex-col min-h-screen">
            <!-- Header aligned with Sidebar Top -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-50 flex items-center justify-between px-8 sticky top-0 z-40">
                <h2 class="text-base font-black text-gray-800 uppercase tracking-tighter">@yield('header')</h2>
                <div class="flex items-center gap-5">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-black text-gray-900 leading-none">Admin User</span>
                        <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">Active Session</span>
                    </div>
                    <div class="w-10 h-10 bg-gray-50 rounded-xl border border-gray-100 p-1">
                        <div class="w-full h-full bg-black rounded-[0.6rem] flex items-center justify-center">
                            <span class="text-white text-[9px] font-black italic">AU</span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-8 py-10 pb-20">
                @if(session('success'))
                    <div class="mb-10 flex items-center gap-4 bg-violet-600 text-white p-6 rounded-[2rem] shadow-2xl shadow-violet-500/20">
                        <div class="w-10 h-10 bg-white/20 rounded-2xl flex items-center justify-center text-xl">✨</div>
                        <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-10 bg-red-50 border border-red-100 p-8 rounded-[2rem]">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-2 h-8 bg-red-500 rounded-full"></div>
                            <h5 class="text-xs font-black uppercase text-red-500">Registry Conflict Identified</h5>
                        </div>
                        <ul class="space-y-3">
                            @foreach ($errors->all() as $error)
                                <li class="text-[11px] font-bold text-red-900 uppercase tracking-tighter list-none flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="animate-in fade-in slide-in-from-bottom-2 duration-500">
                    @yield('content')
                </div>

                {{-- Global Footer Info --}}
                <div class="mt-24 pt-12 border-t border-gray-50 flex items-center justify-between">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-300 italic">© {{ date('Y') }} Dope Style Studio | System Engine V3.1</p>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500">Core Uplink Stable</span>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Auto-scroll active sidebar item into view on load
        document.addEventListener('DOMContentLoaded', () => {
            const activeLink = document.querySelector('aside nav a.bg-black, aside nav span.text-black, aside nav a.font-black');
            if (activeLink) {
                const linkElement = activeLink.closest('a') || activeLink;
                linkElement.scrollIntoView({ behavior: 'auto', block: 'nearest' });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>