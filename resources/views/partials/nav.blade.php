@php
    $navLinks = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'services.index', 'label' => 'Services'],
        ['route' => 'projects.index', 'label' => 'Projects'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
    :class="scrolled ? 'bg-white/90 backdrop-blur-md border-slate-200 shadow-sm' : 'bg-white border-transparent'"
    class="sticky top-0 z-50 border-b transition-all duration-200"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-gradient-to-br from-indigo-600 to-blue-500 text-white font-bold text-sm shadow-sm">S</span>
                <span class="text-lg font-semibold tracking-tight text-slate-900 group-hover:text-indigo-600 transition">Systech<span class="text-indigo-600">Studio</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-1" aria-label="Primary">
                @foreach ($navLinks as $link)
                    @php $active = request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*'); @endphp
                    <a
                        href="{{ route($link['route']) }}"
                        @class([
                            'px-3 py-2 rounded-md text-sm font-medium transition-colors',
                            'text-indigo-600 bg-indigo-50' => $active,
                            'text-slate-700 hover:text-indigo-600 hover:bg-slate-50' => ! $active,
                        ])
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="hidden md:block">
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-600 transition">
                    Start a project
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <button
                @click="open = !open"
                class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-slate-700 hover:bg-slate-100"
                aria-label="Toggle navigation"
                :aria-expanded="open"
            >
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="md:hidden border-t border-slate-200 bg-white">
        <div class="px-4 py-3 space-y-1">
            @foreach ($navLinks as $link)
                @php $active = request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*'); @endphp
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'block rounded-md px-3 py-2 text-base font-medium',
                        'text-indigo-600 bg-indigo-50' => $active,
                        'text-slate-700 hover:bg-slate-50' => ! $active,
                    ])
                >{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('contact') }}" class="block rounded-md bg-slate-900 px-3 py-2 text-center text-base font-semibold text-white mt-2">Start a project</a>
        </div>
    </div>
</header>
