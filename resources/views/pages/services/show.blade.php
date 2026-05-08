<x-layouts.app :title="$service->title" :description="$service->summary">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
        <div class="absolute inset-0 -z-10 opacity-40" aria-hidden="true">
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 h-96 w-[60rem] rounded-full bg-indigo-200 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
            <nav class="text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                    <li class="text-slate-300">/</li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-indigo-600">Services</a></li>
                    <li class="text-slate-300">/</li>
                    <li class="text-slate-700 font-medium">{{ $service->title }}</li>
                </ol>
            </nav>

            <div class="grid lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-8">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                        Service
                    </span>
                    <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-slate-900 leading-tight">{{ $service->title }}</h1>
                    <p class="mt-5 text-lg text-slate-600 leading-relaxed max-w-2xl">{{ $service->summary }}</p>
                </div>
                <div class="lg:col-span-4">
                    <div class="rounded-2xl bg-white shadow-lg ring-1 ring-slate-200 p-6">
                        <div class="grid h-14 w-14 place-items-center rounded-xl bg-gradient-to-br from-indigo-600 to-blue-500 text-white">
                            <x-service-icon :name="$service->icon" class="w-7 h-7" />
                        </div>
                        <p class="mt-4 text-sm text-slate-600 leading-relaxed">Want to discuss a {{ strtolower($service->title) }} project? We'd love to chat.</p>
                        <a href="{{ route('contact') }}" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                            Start a conversation
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12">
                <div class="lg:col-span-7">
                    <h2 class="text-2xl font-bold text-slate-900">Overview</h2>
                    <div class="mt-4 prose prose-slate max-w-none text-slate-600 text-lg leading-relaxed">
                        <p>{{ $service->description }}</p>
                    </div>
                </div>

                @if (! empty($service->features))
                    <div class="lg:col-span-5">
                        <div class="rounded-2xl bg-slate-50 ring-1 ring-slate-200 p-7">
                            <h3 class="text-lg font-semibold text-slate-900">What's included</h3>
                            <ul class="mt-5 space-y-3">
                                @foreach ($service->features as $feature)
                                    <li class="flex items-start gap-3 text-slate-700">
                                        <span class="grid h-6 w-6 flex-shrink-0 place-items-center rounded-full bg-indigo-600 text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span class="text-sm leading-relaxed">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Related Services --}}
    @if ($relatedServices->isNotEmpty())
        <section class="bg-slate-50 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    eyebrow="Explore more"
                    title="Other services you might need"
                />
                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    @foreach ($relatedServices as $related)
                        <a href="{{ route('services.show', $related) }}" class="group rounded-2xl bg-white ring-1 ring-slate-200 p-6 hover:ring-indigo-300 hover:shadow-lg transition">
                            <div class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-50 text-indigo-600">
                                <x-service-icon :name="$related->icon" class="w-5 h-5" />
                            </div>
                            <h3 class="mt-4 text-base font-semibold text-slate-900 group-hover:text-indigo-600 transition">{{ $related->title }}</h3>
                            <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $related->summary }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layouts.app>
