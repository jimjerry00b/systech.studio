@props([
    'eyebrow' => null,
    'title' => null,
    'subtitle' => null,
    'align' => 'left',
])

@php
    $alignClass = $align === 'center' ? 'text-center mx-auto' : 'text-left';
@endphp

<div {{ $attributes->merge(['class' => "max-w-2xl $alignClass"]) }}>
    @if ($eyebrow)
        <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700">
            <span class="h-1.5 w-1.5 rounded-full bg-indigo-600"></span>
            {{ $eyebrow }}
        </span>
    @endif

    @if ($title)
        <h2 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">{{ $title }}</h2>
    @endif

    @if ($subtitle)
        <p class="mt-4 text-lg text-slate-600 leading-relaxed">{{ $subtitle }}</p>
    @endif

    {{ $slot }}
</div>
