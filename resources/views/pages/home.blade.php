<x-layouts.app title="Home">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-white">
        <div class="absolute inset-0 -z-10 opacity-50" aria-hidden="true">
            <div class="absolute -top-40 -right-40 h-[36rem] w-[36rem] rounded-full bg-indigo-200 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-[36rem] w-[36rem] rounded-full bg-blue-100 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-20 pb-24 sm:pt-28 sm:pb-32 lg:pt-32 lg:pb-40">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        Now booking projects for Q3 2026
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 leading-[1.1]">
                        Digital products,<br>
                        <span class="bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">engineered with care.</span>
                    </h1>

                    <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-xl">
                        Systech Studio is a small senior team designing and building modern websites, applications, and brands for ambitious companies — without the agency overhead.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <x-button href="{{ route('contact') }}" variant="primary">
                            Start a project
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </x-button>
                        <x-button href="{{ route('projects.index') }}" variant="outline">
                            View our work
                        </x-button>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-3 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            10+ years experience
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Senior team only
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Fixed-scope pricing
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="absolute inset-0 -m-6 bg-gradient-to-tr from-indigo-200/60 to-blue-200/60 rounded-3xl blur-2xl" aria-hidden="true"></div>
                        <div class="relative grid grid-cols-2 gap-4">
                            <div class="space-y-4">
                                <div class="rounded-2xl bg-white shadow-lg ring-1 ring-slate-200 p-5">
                                    <div class="text-xs font-medium text-slate-500 uppercase tracking-wide">Projects shipped</div>
                                    <div class="mt-2 text-3xl font-bold text-slate-900">120<span class="text-indigo-600">+</span></div>
                                </div>
                                <div class="rounded-2xl bg-slate-900 text-white shadow-lg p-5">
                                    <div class="text-xs font-medium text-indigo-300 uppercase tracking-wide">Avg. response</div>
                                    <div class="mt-2 text-3xl font-bold">&lt; 4h</div>
                                </div>
                            </div>
                            <div class="space-y-4 mt-8">
                                <div class="rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-500 text-white shadow-lg p-5">
                                    <div class="text-xs font-medium text-indigo-100 uppercase tracking-wide">Client retention</div>
                                    <div class="mt-2 text-3xl font-bold">94%</div>
                                </div>
                                <div class="rounded-2xl bg-white shadow-lg ring-1 ring-slate-200 p-5">
                                    <div class="text-xs font-medium text-slate-500 uppercase tracking-wide">Team members</div>
                                    <div class="mt-2 text-3xl font-bold text-slate-900">12</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trusted by / Logos --}}
    <section class="border-y border-slate-100 bg-slate-50/50 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-widest text-slate-500">Trusted by teams at</p>
            <div class="mt-6 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-6 items-center">
                @foreach (['Northwind', 'Helix', 'Apex', 'Greenfield', 'Lumen', 'Forge'] as $brand)
                    <div class="text-center text-lg font-bold text-slate-400 tracking-tight">{{ $brand }}</div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between flex-wrap gap-6 mb-12">
                <x-section-heading
                    eyebrow="What we do"
                    title="Services built around outcomes"
                    subtitle="From idea to launch, we cover every layer of your digital presence with senior practitioners on every engagement."
                />
                <x-button href="{{ route('services.index') }}" variant="outline">All services</x-button>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="group relative rounded-2xl bg-white ring-1 ring-slate-200 p-7 hover:ring-indigo-300 hover:shadow-lg transition-all">
                        <div class="grid h-12 w-12 place-items-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <x-service-icon :name="$service->icon" />
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $service->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $service->summary }}</p>
                        <div class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600">
                            Learn more
                            <svg class="w-4 h-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Projects --}}
    @if ($featuredProjects->isNotEmpty())
        <section class="bg-slate-50 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between flex-wrap gap-6 mb-12">
                    <x-section-heading
                        eyebrow="Selected work"
                        title="Recent projects we're proud of"
                        subtitle="A small selection of work shipped over the past 12 months."
                    />
                    <x-button href="{{ route('projects.index') }}" variant="outline">View all projects</x-button>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    @foreach ($featuredProjects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group block rounded-2xl bg-white ring-1 ring-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                @if ($project->cover_image)
                                    <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                                    {{ $project->category }}
                                </div>
                                <h3 class="mt-3 text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $project->title }}</h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed line-clamp-2">{{ $project->summary }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Process --}}
    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="How we work"
                title="A process that respects your time"
                subtitle="No bloated discovery phases. We move fast, communicate clearly, and ship in tight iterations."
                align="center"
            />

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $steps = [
                        ['n' => '01', 'title' => 'Discover', 'desc' => 'A focused kick-off to align on goals, audience, and constraints. No 50-page reports.'],
                        ['n' => '02', 'title' => 'Design', 'desc' => 'Wireframes evolve into pixel-perfect, accessible interfaces in tight feedback loops.'],
                        ['n' => '03', 'title' => 'Build', 'desc' => 'Senior engineers ship clean, tested code with weekly demo releases.'],
                        ['n' => '04', 'title' => 'Launch & support', 'desc' => 'We hand off thoroughly and stay on call for the critical post-launch weeks.'],
                    ];
                @endphp
                @foreach ($steps as $step)
                    <div class="relative rounded-2xl bg-white ring-1 ring-slate-200 p-7">
                        <div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">{{ $step['n'] }}</div>
                        <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 px-8 py-16 sm:px-16 sm:py-20">
                <div class="absolute inset-0 -z-0 opacity-30" aria-hidden="true">
                    <div class="absolute top-0 right-0 h-72 w-72 rounded-full bg-indigo-500 blur-3xl"></div>
                </div>
                <div class="relative grid lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Have a project in mind?</h2>
                        <p class="mt-4 text-lg text-slate-300 leading-relaxed">We typically get back to enquiries within four hours during business days. Tell us what you're building.</p>
                    </div>
                    <div class="lg:text-right">
                        <x-button href="{{ route('contact') }}" variant="primary" class="text-base">
                            Start the conversation
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
