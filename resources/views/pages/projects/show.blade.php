<x-layouts.app :title="$project->title" :description="$project->summary">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
        <div class="absolute inset-0 -z-10 opacity-40" aria-hidden="true">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 h-96 w-[60rem] rounded-full bg-indigo-200 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <nav class="text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                    <li class="text-slate-300">/</li>
                    <li><a href="{{ route('projects.index') }}" class="hover:text-indigo-600">Projects</a></li>
                    <li class="text-slate-300">/</li>
                    <li class="text-slate-700 font-medium truncate">{{ $project->title }}</li>
                </ol>
            </nav>

            <div class="grid lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-8">
                    <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wider text-indigo-600">
                        <span class="rounded-full bg-indigo-50 px-3 py-1">{{ $project->category }}</span>
                        @if ($project->completed_at)
                            <span class="text-slate-400 normal-case font-normal">Completed {{ $project->completed_at->format('F Y') }}</span>
                        @endif
                    </div>
                    <h1 class="mt-5 text-4xl sm:text-5xl font-bold tracking-tight text-slate-900 leading-tight">{{ $project->title }}</h1>
                    @if ($project->client)
                        <p class="mt-3 text-lg text-slate-500">For <span class="font-semibold text-slate-700">{{ $project->client }}</span></p>
                    @endif
                    <p class="mt-5 text-lg text-slate-600 leading-relaxed max-w-2xl">{{ $project->summary }}</p>
                </div>

                <div class="lg:col-span-4">
                    <div class="rounded-2xl bg-white shadow-lg ring-1 ring-slate-200 p-6 space-y-4 text-sm">
                        @if ($project->client)
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Client</div>
                                <div class="mt-1 text-slate-900 font-medium">{{ $project->client }}</div>
                            </div>
                        @endif
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Category</div>
                            <div class="mt-1 text-slate-900 font-medium">{{ $project->category }}</div>
                        </div>
                        @if ($project->completed_at)
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">Completed</div>
                                <div class="mt-1 text-slate-900 font-medium">{{ $project->completed_at->format('F Y') }}</div>
                            </div>
                        @endif
                        @if ($project->website_url)
                            <div class="pt-2">
                                <a href="{{ $project->website_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                                    Visit live site
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($project->cover_image)
                <div class="mt-12 overflow-hidden rounded-2xl ring-1 ring-slate-200 shadow-xl">
                    <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="w-full h-auto object-cover">
                </div>
            @endif
        </div>
    </section>

    {{-- Content --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12">
                <div class="lg:col-span-8">
                    <h2 class="text-2xl font-bold text-slate-900">The project</h2>
                    <div class="mt-4 prose prose-slate max-w-none text-lg text-slate-600 leading-relaxed">
                        <p>{{ $project->description }}</p>
                    </div>
                </div>

                @if (! empty($project->technologies))
                    <div class="lg:col-span-4">
                        <h3 class="text-lg font-semibold text-slate-900">Technologies</h3>
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($project->technologies as $tech)
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700 ring-1 ring-slate-200">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Related --}}
    @if ($relatedProjects->isNotEmpty())
        <section class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    eyebrow="More work"
                    title="Other projects in {{ $project->category }}"
                />
                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedProjects as $related)
                        <a href="{{ route('projects.show', $related) }}" class="group block rounded-2xl bg-white ring-1 ring-slate-200 overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                                @if ($related->cover_image)
                                    <img src="{{ $related->cover_image }}" alt="{{ $related->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="text-base font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $related->title }}</h3>
                                <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $related->summary }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-slate-900 px-8 py-14 sm:px-16 text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white">Have a similar project?</h2>
                <p class="mt-4 text-lg text-slate-300 max-w-2xl mx-auto">We'd love to hear about it. Most engagements start with a 30-minute call.</p>
                <div class="mt-8">
                    <x-button href="{{ route('contact') }}" variant="primary">Start a conversation</x-button>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
