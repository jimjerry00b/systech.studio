<x-layouts.app title="Contact">

    <x-page-hero
        eyebrow="Contact"
        title="Let's build something together."
        subtitle="Tell us about your project. We typically reply within four hours during business days."
    />

    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-10">

                {{-- Sidebar --}}
                <aside class="lg:col-span-4 space-y-6">
                    <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-7">
                        <div class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-slate-900">Email us</h3>
                        <p class="mt-1 text-sm text-slate-600">For new projects and partnerships.</p>
                        <a href="mailto:hello@systechstudio.test" class="mt-3 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-700">hello@systechstudio.test</a>
                    </div>

                    <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-7">
                        <div class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="mt-4 text-base font-semibold text-slate-900">Office hours</h3>
                        <p class="mt-1 text-sm text-slate-600">Monday – Friday<br>9:00 – 18:00 GMT</p>
                    </div>

                    <div class="rounded-2xl bg-slate-900 text-white p-7">
                        <h3 class="text-base font-semibold">Quick FAQ</h3>
                        <dl class="mt-4 space-y-4 text-sm">
                            <div>
                                <dt class="font-semibold text-white">Project size?</dt>
                                <dd class="mt-1 text-slate-300">Most engagements range from $25k to $250k+.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-white">Timeline?</dt>
                                <dd class="mt-1 text-slate-300">From four-week sprints to six-month builds.</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-white">Locations?</dt>
                                <dd class="mt-1 text-slate-300">Remote-first, client-friendly time zones.</dd>
                            </div>
                        </dl>
                    </div>
                </aside>

                {{-- Form --}}
                <div class="lg:col-span-8">
                    <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-8 sm:p-10 shadow-sm">

                        @if (session('status'))
                            <div class="mb-6 rounded-lg bg-emerald-50 ring-1 ring-emerald-200 p-4 flex items-start gap-3" role="status">
                                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
                            </div>
                        @endif

                        @if ($errors->has('message') && ! $errors->has('email') && ! $errors->has('name'))
                            {{-- Rate limit error has only 'message' field --}}
                        @endif

                        <h2 class="text-2xl font-bold text-slate-900">Send us a message</h2>
                        <p class="mt-2 text-sm text-slate-600">Fields marked with <span class="text-rose-500">*</span> are required.</p>

                        <form action="{{ route('contact.store') }}" method="POST" class="mt-8 space-y-6" novalidate>
                            @csrf

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700">Your name <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        autocomplete="name"
                                        @class([
                                            'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                            'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('name'),
                                            'ring-rose-400 focus:ring-rose-500' => $errors->has('name'),
                                        ])
                                        placeholder="Jane Doe"
                                    >
                                    @error('name')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        @class([
                                            'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                            'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('email'),
                                            'ring-rose-400 focus:ring-rose-500' => $errors->has('email'),
                                        ])
                                        placeholder="you@company.com"
                                    >
                                    @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-slate-700">Phone <span class="text-slate-400">(optional)</span></label>
                                    <input
                                        type="tel"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        autocomplete="tel"
                                        @class([
                                            'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                            'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('phone'),
                                            'ring-rose-400 focus:ring-rose-500' => $errors->has('phone'),
                                        ])
                                        placeholder="+1 555 0100"
                                    >
                                    @error('phone')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-medium text-slate-700">Subject <span class="text-rose-500">*</span></label>
                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        value="{{ old('subject') }}"
                                        required
                                        @class([
                                            'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                            'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('subject'),
                                            'ring-rose-400 focus:ring-rose-500' => $errors->has('subject'),
                                        ])
                                        placeholder="Website redesign for…"
                                    >
                                    @error('subject')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-slate-700">Message <span class="text-rose-500">*</span></label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    required
                                    @class([
                                        'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                        'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('message'),
                                        'ring-rose-400 focus:ring-rose-500' => $errors->has('message'),
                                    ])
                                    placeholder="Tell us about your project, timeline, and any specific requirements…"
                                >{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center justify-between flex-wrap gap-4 pt-2">
                                <p class="text-xs text-slate-500">By submitting, you agree to be contacted about your enquiry. Limited to 3 messages per hour.</p>
                                <x-button type="submit" variant="primary">
                                    Send message
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
