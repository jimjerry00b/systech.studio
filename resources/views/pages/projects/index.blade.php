<x-layouts.app title="Projects">

    <x-page-hero
        eyebrow="Selected work"
        title="Projects we've shipped."
        subtitle="A selection of recent engagements across e-commerce, healthcare, fintech, and education. Every project below was built end-to-end by our team."
    />

    {{-- Filters --}}
    <section class="border-b border-slate-100 bg-slate-50/50 py-6 sticky top-16 z-30 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 overflow-x-auto pb-1">
                <a
                    href="{{ route('projects.index') }}"
                    @class([
                        'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium whitespace-nowrap transition',
                        'bg-slate-900 text-white' => is_null($currentCategory),
                        'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100' => ! is_null($currentCategory),
                    ])
                >All</a>
                @foreach ($categories as $category)
                    <a
                        href="{{ route('projects.index', ['category' => $category]) }}"
                        @class([
                            'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium whitespace-nowrap transition',
                            'bg-slate-900 text-white' => $currentCategory === $category,
                            'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100' => $currentCategory !== $category,
                        ])
                    >{{ $category }}</a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Project Grid --}}
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if ($projects->isEmpty())
                <div class="text-center py-20">
                    <p class="text-slate-500">No projects found in this category yet.</p>
                </div>
            @else
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group block rounded-2xl bg-white ring-1 ring-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
                                @if ($project->cover_image)
                                    <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                @endif
                                @if ($project->is_featured)
                                    <span class="absolute top-3 left-3 inline-flex items-center gap-1 rounded-full bg-white/90 backdrop-blur px-3 py-1 text-xs font-semibold text-indigo-700 shadow-sm">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Featured
                                    </span>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                                        {{ $project->category }}
                                    </div>
                                    @if ($project->completed_at)
                                        <span class="text-xs text-slate-400">{{ $project->completed_at->format('M Y') }}</span>
                                    @endif
                                </div>
                                <h3 class="mt-3 text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $project->title }}</h3>
                                @if ($project->client)
                                    <p class="mt-1 text-sm text-slate-500">{{ $project->client }}</p>
                                @endif
                                <p class="mt-3 text-sm text-slate-600 leading-relaxed line-clamp-2">{{ $project->summary }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $projects->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>
