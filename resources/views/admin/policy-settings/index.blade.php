@extends('layouts.admin')

@section('header', 'Shipping & Returns (PDP)')

@section('content')
    <div class="pb-24">
        <form id="policy-form" action="{{ route('admin.online-store.policy-settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Sticky Header for Actions -->
            <div
                class="sticky top-0 z-40 bg-gray-50/80 backdrop-blur-md border-b border-gray-200 -mx-4 px-4 py-4 mb-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-black flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Shipping & Returns (Product Display Page (PDP))</h1>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Product Page Information
                            Section</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-800 transition-all shadow-lg shadow-black/10 active:scale-95">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Core Shipping -->
                <div class="lg:col-span-12">
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden group hover:border-indigo-100 transition-colors bg-gradient-to-br from-white to-gray-50/30">
                        <div class="p-8 md:p-12">
                            <div class="flex items-center gap-4 mb-10">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Logistics & Shipping</h2>
                                    <p class="text-sm text-gray-500 font-medium">Configure global delivery costs and
                                        timelines.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="space-y-2 group/field">
                                    <label
                                        class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1 group-hover/field:text-indigo-600 transition-colors">COD
                                        Gateway Charges</label>
                                    <input type="text" name="cod_charges" value="{{ $settings['cod_charges'] }}"
                                        placeholder="e.g. ₹50 or Free"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter px-1">Applied
                                        for Cash on Delivery</p>
                                </div>
                                <div class="space-y-2 group/field">
                                    <label
                                        class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1 group-hover/field:text-indigo-600 transition-colors">Prepaid
                                        Processing</label>
                                    <input type="text" name="prepaid_charges" value="{{ $settings['prepaid_charges'] }}"
                                        placeholder="e.g. ₹0 or Free"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter px-1">
                                        Processing fee for online payments</p>
                                </div>
                                <div class="space-y-2 group/field">
                                    <label
                                        class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1 group-hover/field:text-indigo-600 transition-colors">Estimate
                                        Delivery</label>
                                    <input type="text" name="delivery_timeline" value="{{ $settings['delivery_timeline'] }}"
                                        placeholder="e.g. 3-5 Working Days"
                                        class="w-full bg-gray-50 border-gray-100 rounded-2xl py-4 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter px-1">Visible
                                        on product details page</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Policies Grid -->
                <div class="lg:col-span-12 grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Returns Policy Card --}}
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden group hover:border-blue-100 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-black text-gray-900 tracking-tight">Returns Policy</h2>
                            </div>
                            <div
                                class="editor-wrap rounded-3xl border border-gray-100 overflow-hidden bg-gray-50/50 focus-within:ring-2 focus-within:ring-blue-500 transition-all">
                                <div id="return-policy-editor" class="bg-white min-h-[300px] border-0">
                                    {!! $settings['return_policy'] !!}</div>
                            </div>
                            <textarea name="return_policy" class="hidden">{{ $settings['return_policy'] }}</textarea>
                        </div>
                    </div>

                    {{-- Exchanges Policy Card --}}
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden group hover:border-amber-100 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-black text-gray-900 tracking-tight">Exchange Policy</h2>
                            </div>
                            <div
                                class="editor-wrap rounded-3xl border border-gray-100 overflow-hidden bg-gray-50/50 focus-within:ring-2 focus-within:ring-amber-500 transition-all">
                                <div id="exchange-policy-editor" class="bg-white min-h-[300px] border-0">
                                    {!! $settings['exchange_policy'] !!}</div>
                            </div>
                            <textarea name="exchange_policy" class="hidden">{{ $settings['exchange_policy'] }}</textarea>
                        </div>
                    </div>

                    {{-- Refund Method Card --}}
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden group hover:border-emerald-100 transition-colors">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-black text-gray-900 tracking-tight">Refund Method</h2>
                            </div>
                            <div
                                class="editor-wrap rounded-3xl border border-gray-100 overflow-hidden bg-gray-50/50 focus-within:ring-2 focus-within:ring-emerald-500 transition-all">
                                <div id="refund-method-editor" class="bg-white min-h-[300px] border-0">
                                    {!! $settings['refund_method'] !!}</div>
                            </div>
                            <textarea name="refund_method" class="hidden">{{ $settings['refund_method'] }}</textarea>
                        </div>
                    </div>

                    {{-- Additional Dynamic Sections --}}
                    <div
                        class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden group hover:border-black transition-colors flex flex-col">
                        <div class="p-8 flex-1">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-500">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-black text-gray-900 tracking-tight">Custom Sections</h2>
                                </div>
                                <button type="button" id="add-section-btn"
                                    class="bg-black text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-gray-800 transition-all shadow-lg shadow-black/10 active:scale-95 flex items-center gap-2">
                                    + Add Block
                                </button>
                            </div>

                            <div id="extra-sections-container" class="space-y-8"></div>
                            <input type="hidden" name="extra_sections" id="extra-sections-input"
                                value="{{ $settings['extra_sections'] ?? '[]' }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* Quill Editor Custom Styling */
        .ql-toolbar.ql-snow {
            border: none !important;
            background: #f8fafc;
            padding: 12px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .ql-container.ql-snow {
            border: none !important;
            font-family: inherit !important;
            font-size: 0.95rem !important;
        }

        .ql-editor {
            padding: 24px 32px !important;
            line-height: 1.7 !important;
            color: #1e293b !important;
        }

        .ql-editor.ql-blank::before {
            left: 32px !important;
            color: #cbd5e1 !important;
            font-weight: 500 !important;
        }

        .extra-section-row {
            animation: slideInFromTop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.policySettingsInited) return;
            window.policySettingsInited = true;

            var toolbarOptions = [
                ['bold', 'italic'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ];

            // Static Editors
            var quillReturn = new Quill('#return-policy-editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });
            var quillExchange = new Quill('#exchange-policy-editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });
            var quillRefund = new Quill('#refund-method-editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });

            var returnInput = document.querySelector('textarea[name="return_policy"]');
            var exchangeInput = document.querySelector('textarea[name="exchange_policy"]');
            var refundInput = document.querySelector('textarea[name="refund_method"]');

            quillReturn.on('text-change', () => { returnInput.value = quillReturn.root.innerHTML; });
            quillExchange.on('text-change', () => { exchangeInput.value = quillExchange.root.innerHTML; });
            quillRefund.on('text-change', () => { refundInput.value = quillRefund.root.innerHTML; });

            // Dynamic Extra Sections
            var container = document.getElementById('extra-sections-container');
            var jsonInput = document.getElementById('extra-sections-input');
            var sectionIdx = 0;
            var quillMap = {};

            function addSection(heading, content) {
                var idx = sectionIdx++;
                var div = document.createElement('div');
                div.className = 'extra-section-row bg-gray-50/50 rounded-[2rem] p-6 md:p-8 border border-gray-100 relative group/section hover:bg-white hover:shadow-xl hover:shadow-gray-200/50 transition-all';
                div.dataset.idx = idx;
                div.innerHTML = `
                <button type="button" data-idx="${idx}"
                    class="remove-section-btn absolute top-6 right-6 text-gray-300 hover:text-red-500 transition-all p-2 bg-white rounded-xl border border-transparent hover:border-red-100 hover:shadow-lg hover:shadow-red-500/10"
                    title="Remove section">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div class="space-y-6">
                    <div class="max-w-md">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1 mb-2 block">Block Heading</label>
                        <input type="text" data-idx="${idx}" data-field="heading"
                            value="${(heading || '').replace(/"/g, '&quot;')}"
                            placeholder="e.g. Authenticity Guarantee"
                            class="section-heading w-full bg-white border-gray-200 rounded-xl py-3 px-4 text-gray-900 font-bold focus:ring-2 focus:ring-black transition-all">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1 mb-2 block">Block Content</label>
                        <div class="editor-wrap rounded-2xl border border-gray-200 overflow-hidden bg-white shadow-sm">
                            <div id="section-editor-${idx}" class="min-h-[200px] border-0 text-sm">${content || ''}</div>
                        </div>
                    </div>
                </div>
            `;
                container.appendChild(div);

                var q = new Quill(`#section-editor-${idx}`, {
                    theme: 'snow',
                    modules: { toolbar: toolbarOptions }
                });
                quillMap[idx] = q;
            }

            try {
                container.innerHTML = '';
                var existing = JSON.parse(jsonInput.value || '[]');
                existing.forEach(function (s) { addSection(s.heading, s.content); });
            } catch (e) { }

            document.getElementById('add-section-btn').addEventListener('click', function () {
                addSection('', '');
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            });

            container.addEventListener('click', function (e) {
                var btn = e.target.closest('.remove-section-btn');
                if (!btn || !confirm('Permanently delete this section?')) return;
                var idx = parseInt(btn.dataset.idx);
                delete quillMap[idx];
                btn.closest('.extra-section-row').remove();
            });

            document.getElementById('policy-form').addEventListener('submit', function () {
                var sections = [];
                container.querySelectorAll('.extra-section-row').forEach(function (row) {
                    var idx = parseInt(row.dataset.idx);
                    var headingInput = row.querySelector('.section-heading');
                    var heading = headingInput ? headingInput.value : '';
                    var content = quillMap[idx] ? quillMap[idx].root.innerHTML : '';
                    if (heading.trim() !== '' || (content.trim() !== '' && content !== '<p><br></p>')) {
                        sections.push({ heading: heading, content: content });
                    }
                });
                jsonInput.value = JSON.stringify(sections);
            });
        });
    </script>
@endpush