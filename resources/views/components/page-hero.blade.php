@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
])

<section class="relative overflow-hidden bg-gradient-to-b from-slate-50 to-white border-b border-slate-100">
    <div class="absolute inset-0 -z-10 opacity-[0.4]" aria-hidden="true">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 h-96 w-[60rem] rounded-full bg-indigo-200 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <div class="max-w-3xl">
            @if ($eyebrow)
                <span class="inline-flex items-center gap-2 rounded-full bg-white ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 shadow-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
                    {{ $eyebrow }}
                </span>
            @endif
            <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 leading-tight">
                {{ $title }}
            </h1>
            @if ($subtitle)
                <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl">{{ $subtitle }}</p>
            @endif
            {{ $slot }}
        </div>
    </div>
</section>
