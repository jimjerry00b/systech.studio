<x-layouts.app title="Services">

    <x-page-hero
        eyebrow="Services"
        title="Everything you need, under one roof."
        subtitle="From initial brand work through engineering and ongoing support, we provide an integrated set of services so you don't have to juggle vendors."
    />

    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="group relative flex flex-col rounded-2xl bg-white ring-1 ring-slate-200 p-8 hover:ring-indigo-300 hover:shadow-xl hover:-translate-y-1 transition-all">
                        <div class="grid h-14 w-14 place-items-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <x-service-icon :name="$service->icon" class="w-7 h-7" />
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $service->title }}</h3>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed flex-1">{{ $service->summary }}</p>

                        @if (! empty($service->features))
                            <ul class="mt-5 space-y-2">
                                @foreach (array_slice($service->features, 0, 3) as $feature)
                                    <li class="flex items-start gap-2 text-sm text-slate-600">
                                        <svg class="w-4 h-4 mt-0.5 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600">
                            Read more
                            <svg class="w-4 h-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-slate-900 px-8 py-14 sm:px-16 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Need something custom?</h2>
                <p class="mt-4 text-lg text-slate-300 max-w-2xl mx-auto">Most engagements are a blend of services. Tell us what you're trying to do and we'll propose the right shape of project.</p>
                <div class="mt-8">
                    <x-button href="{{ route('contact') }}" variant="primary">Tell us about your project</x-button>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
