<x-layouts.app title="About">

    <x-page-hero
        eyebrow="About us"
        title="A studio of senior practitioners."
        subtitle="Systech Studio was founded in 2015 around a simple idea: small, senior teams ship better products than large junior ones. A decade later, that's still our north star."
    />

    {{-- Mission --}}
    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-5">
                    <x-section-heading
                        eyebrow="Our story"
                        title="From a two-person freelance team to an internationally trusted studio."
                    />
                </div>
                <div class="lg:col-span-7 text-slate-600 text-lg leading-relaxed space-y-5">
                    <p>
                        We started as two engineers who were tired of bloated agency processes and consulting playbooks that prioritized billable hours over outcomes. Our bet was simple: pair experienced practitioners directly with clients, cut out the middle layers, and let the work speak.
                    </p>
                    <p>
                        Today we're a team of twelve designers, engineers, and strategists working with companies from early-stage startups to publicly traded enterprises. We still write code on every engagement. We still take calls with founders. And we still ship.
                    </p>
                    <p>
                        Most importantly, we're selective about who we work with. We take on roughly one in four projects we're approached about — because the only way we can promise senior attention is to limit how many things we say yes to.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-slate-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
                @php
                    $stats = [
                        ['value' => '120+', 'label' => 'Projects shipped'],
                        ['value' => '10yr', 'label' => 'In business'],
                        ['value' => '94%',  'label' => 'Client retention'],
                        ['value' => '12',   'label' => 'Team members'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div>
                        <div class="text-4xl sm:text-5xl font-bold bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">{{ $stat['value'] }}</div>
                        <div class="mt-2 text-sm font-medium text-slate-600 uppercase tracking-wider">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="What we believe"
                title="Principles that guide our work"
                align="center"
            />

            <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $values = [
                        [
                            'title' => 'Senior-only engagements',
                            'desc'  => 'Every project has a senior designer and senior engineer assigned end-to-end. No bait-and-switch.',
                        ],
                        [
                            'title' => 'Outcomes over deliverables',
                            'desc'  => 'We measure ourselves on the value our work creates, not the volume of artifacts produced.',
                        ],
                        [
                            'title' => 'Honest timelines',
                            'desc'  => 'We tell you what\'s realistic — even when it\'s not what you want to hear. Surprises kill projects.',
                        ],
                        [
                            'title' => 'Code that lasts',
                            'desc'  => 'We write code as if we\'ll be the ones maintaining it in five years. Often, we are.',
                        ],
                        [
                            'title' => 'Design with substance',
                            'desc'  => 'Beautiful is non-negotiable, but the best design is invisible: it just works for your users.',
                        ],
                        [
                            'title' => 'Clear communication',
                            'desc'  => 'Weekly demos, async daily updates, and one shared channel. No status meetings about status meetings.',
                        ],
                    ];
                @endphp
                @foreach ($values as $value)
                    <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-7 hover:ring-indigo-200 hover:shadow-lg transition">
                        <div class="grid h-10 w-10 place-items-center rounded-lg bg-indigo-50 text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-slate-900">{{ $value['title'] }}</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $value['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    @if ($team->isNotEmpty())
        <section class="bg-slate-50 py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-section-heading
                    eyebrow="The team"
                    title="People you'll actually work with"
                    subtitle="No account managers between you and the makers."
                    align="center"
                />

                <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($team as $member)
                        <div class="group rounded-2xl bg-white ring-1 ring-slate-200 overflow-hidden hover:shadow-lg transition">
                            <div class="aspect-square overflow-hidden bg-slate-100">
                                @if ($member->photo)
                                    <img src="{{ $member->photo }}" alt="{{ $member->name }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="text-base font-semibold text-slate-900">{{ $member->name }}</h3>
                                <p class="mt-1 text-sm text-indigo-600 font-medium">{{ $member->role }}</p>
                                @if ($member->bio)
                                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">{{ $member->bio }}</p>
                                @endif
                                @if ($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-indigo-600 transition">
                                        Connect on LinkedIn
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-gradient-to-br from-indigo-600 to-blue-500 px-8 py-14 sm:px-16 sm:py-16 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">Ready to build something together?</h2>
                <p class="mt-4 text-lg text-indigo-100 max-w-2xl mx-auto">We're currently booking new engagements for next quarter. Reach out for a no-obligation chat.</p>
                <div class="mt-8">
                    <x-button href="{{ route('contact') }}" variant="outline" class="!bg-white !text-indigo-700 !ring-0 hover:!bg-indigo-50">
                        Get in touch
                    </x-button>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
