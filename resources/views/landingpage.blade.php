<?php
// MovieBox - homepage
$movies = [
    ['title' => 'Interstellar',      'year' => 2014, 'genre' => 'Sci-Fi',    'rating' => 8.7],
    ['title' => 'The Dark Knight',   'year' => 2008, 'genre' => 'Action',    'rating' => 9.0],
    ['title' => 'Parasite',          'year' => 2019, 'genre' => 'Thriller',  'rating' => 8.5],
    ['title' => 'Dune',              'year' => 2021, 'genre' => 'Sci-Fi',    'rating' => 8.0],
    ['title' => 'Whiplash',          'year' => 2014, 'genre' => 'Drama',     'rating' => 8.5],
    ['title' => 'Spirited Away',     'year' => 2001, 'genre' => 'Animation', 'rating' => 8.6],
    ['title' => 'The Matrix',        'year' => 1999, 'genre' => 'Sci-Fi',    'rating' => 8.7],
    ['title' => 'Get Out',           'year' => 2017, 'genre' => 'Horror',    'rating' => 7.7],
    ['title' => 'Inception',         'year' => 2010, 'genre' => 'Sci-Fi',    'rating' => 8.8],
    ['title' => 'The Godfather',     'year' => 1972, 'genre' => 'Crime',     'rating' => 9.2],
    ['title' => 'Pulp Fiction',      'year' => 1994, 'genre' => 'Crime',     'rating' => 8.9],
    ['title' => 'Fight Club',        'year' => 1999, 'genre' => 'Drama',     'rating' => 8.8],
    ['title' => 'Forrest Gump',      'year' => 1994, 'genre' => 'Drama',     'rating' => 8.8],
    ['title' => 'Gladiator',         'year' => 2000, 'genre' => 'Action',    'rating' => 8.5],
    ['title' => 'La La Land',        'year' => 2016, 'genre' => 'Romance',   'rating' => 8.0],
    ['title' => 'Joker',             'year' => 2019, 'genre' => 'Drama',     'rating' => 8.4],
    ['title' => 'Mad Max: Fury Road','year' => 2015, 'genre' => 'Action',    'rating' => 8.1],
    ['title' => 'Coco',              'year' => 2017, 'genre' => 'Animation', 'rating' => 8.4],
];

// Featured banner slides for the hero carousel
$featured = [
    ['title' => 'Bhooth Bangla',    'year' => 2026, 'genres' => 'Comédie, Horreur',   'rating' => 7.2, 'image' => 'https://picsum.photos/seed/bhooth/1600/720'],
    ['title' => 'Dune: Part Two',   'year' => 2024, 'genres' => 'Sci-Fi, Aventure',    'rating' => 8.5, 'image' => 'https://picsum.photos/seed/dune/1600/720'],
    ['title' => 'The Batman',       'year' => 2022, 'genres' => 'Action, Crime',       'rating' => 7.9, 'image' => 'https://picsum.photos/seed/batman/1600/720'],
    ['title' => 'Oppenheimer',      'year' => 2023, 'genres' => 'Drame, Histoire',     'rating' => 8.4, 'image' => 'https://picsum.photos/seed/oppenheimer/1600/720'],
    ['title' => 'Spider-Man',       'year' => 2021, 'genres' => 'Action, Aventure',    'rating' => 8.2, 'image' => 'https://picsum.photos/seed/spiderman/1600/720'],
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieBox — Watch Movies & Shows</title>

    <!-- Tailwind CSS (Play CDN — no build step required) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#e50914',
                    },
                },
            },
        };
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-neutral-950 text-neutral-100 antialiased">

    <!-- Header / Navbar -->
    <header id="site-header" class="sticky top-0 z-50 bg-transparent transition-colors duration-300">
        <nav class="flex w-full items-center gap-3 px-4 py-4 sm:gap-4 sm:px-6">

            <!-- Menu toggle -->
            <button id="menu-toggle" type="button" aria-label="Toggle menu" aria-expanded="true" aria-controls="sidebar" class="shrink-0 rounded-lg p-2 text-neutral-200 transition hover:bg-white/10">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
            </button>

            <!-- Logo -->
            <a href="#" class="flex shrink-0 items-center gap-2 text-xl font-extrabold tracking-tight text-white">
                <span class="grid h-7 w-7 place-items-center rounded-md bg-gradient-to-br from-cyan-400 to-emerald-500 text-neutral-900">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
                </span>
                MovieBox
            </a>

            <!-- Search -->
            <label class="relative flex min-w-0 flex-1 items-center">
                <svg class="pointer-events-none absolute left-4 z-10 h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="search" placeholder="Rechercher des films / séries TV" class="w-full max-w-[560px] rounded-md border border-white/10 bg-neutral-800/60 py-2.5 pl-12 pr-4 text-sm text-white placeholder-neutral-400 backdrop-blur focus:border-emerald-400 focus:outline-none focus:ring-1 focus:ring-emerald-400">
            </label>

            <!-- Application button -->
            <a href="#" class="flex shrink-0 items-center gap-2 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 px-4 py-2 text-sm font-bold text-neutral-900 transition hover:brightness-105">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                Application
            </a>
        </nav>
    </header>

    <!-- Body layout: sidebar + content -->
    <div class="flex items-start">

        <!-- Left sidebar -->
        <aside id="sidebar" class="sticky top-[73px] h-[calc(100vh-73px)] w-56 shrink-0 overflow-hidden transition-[width] duration-300 ease-in-out">
            <div class="flex h-full w-56 flex-col border-r border-neutral-800 bg-neutral-950 px-3 py-4">

            <!-- Language selector -->
            <details class="group relative mb-3">
                <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 text-sm font-bold text-white transition hover:bg-neutral-900">
                    <span class="flex items-center gap-2">
                        <svg class="h-5 w-5 shrink-0 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        FRANÇAIS
                    </span>
                    <svg class="h-4 w-4 text-neutral-400 transition group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <div class="absolute left-0 right-0 z-20 mt-1 flex flex-col rounded-lg border border-neutral-700 bg-neutral-800 py-1 text-sm shadow-xl shadow-black/50">
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">English</a>
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">العربية</a>
                    <a href="#" class="px-3 py-1.5 font-bold text-white">Français</a>
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">Bahasa Indonesia</a>
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">हिन्दी</a>
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">اردو</a>
                    <a href="#" class="px-3 py-1.5 text-neutral-300 transition hover:bg-neutral-700 hover:text-white">Filipino</a>
                </div>
            </details>

            <!-- Primary navigation -->
            <nav class="flex min-h-0 flex-1 flex-col gap-0.5 overflow-y-auto text-sm font-semibold">
                <a href="#" class="flex items-center gap-3 rounded-lg bg-neutral-900 px-3 py-2.5 text-white">
                    <svg class="h-5 w-5 shrink-0 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Accueil
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="15" x="2" y="7" rx="2"/><polyline points="17 2 12 7 7 2"/></svg>
                    Emission TV
                </a>
                <a href="#movies" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 3v18M17 3v18M3 7.5h4M3 12h18M3 16.5h4M17 7.5h4M17 16.5h4"/></svg>
                    Film
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                    Animation
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" x2="6" y1="20" y2="16"/><line x1="12" x2="12" y1="20" y2="10"/><line x1="18" x2="18" y1="20" y2="4"/></svg>
                    Les Plus Regardés
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                    Application
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                    Moviebox TV APK
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    FM Download
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" x2="10" y1="12" y2="12"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="15" x2="15.01" y1="13" y2="13"/><line x1="18" x2="18.01" y1="11" y2="11"/><rect width="20" height="12" x="2" y="6" rx="2"/></svg>
                    Games
                </a>
                <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-neutral-300 transition hover:bg-neutral-900 hover:text-white">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="m8 11 4 4 4-4"/><path d="M3 21h18"/></svg>
                    Old Moviebox
                </a>
            </nav>

            <!-- Get MovieBox -->
            <div class="mt-auto shrink-0 border-t border-neutral-800 pt-4">
                <p class="mb-3 px-1 text-xs font-semibold text-neutral-400">Get MovieBox</p>

                <!-- Mobile/desktop app card -->
                <a href="#" class="flex items-center gap-3 rounded-xl bg-gradient-to-r from-cyan-400 to-emerald-400 p-3 text-neutral-900 transition hover:brightness-105">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white/40">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/></svg>
                    </span>
                    <span class="min-w-0 flex-1 leading-tight">
                        <span class="block truncate text-sm font-bold">MovieBox App</span>
                        <span class="block truncate text-xs">For mobile &amp; desktop</span>
                    </span>
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-md bg-emerald-600/80 text-white">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3M21 21v.01M12 7v3a2 2 0 0 1-2 2H7M3 12h.01M12 3h.01M12 16v.01M16 12h1M21 12v.01M12 21v-1"/></svg>
                    </span>
                </a>

                <!-- TV APK card -->
                <a href="#" class="mt-2 flex items-center gap-3 rounded-xl border border-neutral-800 bg-neutral-900 p-3 transition hover:border-neutral-700">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-neutral-800 text-[10px] font-bold text-neutral-300">TV</span>
                    <span class="min-w-0 flex-1 leading-tight">
                        <span class="block truncate text-sm font-semibold text-white">TV APK</span>
                        <span class="block truncate text-xs text-neutral-400">Android TV</span>
                    </span>
                    <svg class="h-5 w-5 shrink-0 text-neutral-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                </a>
            </div>
            </div><!-- /sidebar inner -->
        </aside>

        <!-- Main content column -->
        <div class="min-w-0 flex-1">

    <!-- Hero slider -->
    <section id="hero-slider" class="relative w-full overflow-hidden" aria-roledescription="carousel">
        <div class="relative h-[60vh] min-h-[360px] max-h-[680px] w-full">
            <?php foreach ($featured as $i => $slide): ?>
                <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out <?= $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' ?>">
                    <img
                        src="<?= htmlspecialchars($slide['image']) ?>"
                        alt="<?= htmlspecialchars($slide['title']) ?>"
                        class="h-full w-full object-cover"
                        <?= $i === 0 ? '' : 'loading="lazy"' ?>
                    >
                    <!-- Legibility gradients -->
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/30 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-neutral-950/80 via-neutral-950/10 to-transparent"></div>

                    <!-- Caption -->
                    <div class="absolute bottom-0 left-0 max-w-2xl p-6 sm:p-10">
                        <h2 class="text-3xl font-extrabold tracking-tight text-white drop-shadow-lg sm:text-5xl">
                            <?= htmlspecialchars($slide['title']) ?>
                        </h2>
                        <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-neutral-300">
                            <svg class="h-4 w-4 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 3v18M17 3v18M3 7.5h4M3 12h18M3 16.5h4M17 7.5h4M17 16.5h4"/></svg>
                            <span><?= htmlspecialchars((string) $slide['year']) ?></span>
                            <span class="text-neutral-600">|</span>
                            <span><?= htmlspecialchars($slide['genres']) ?></span>
                            <span class="text-neutral-600">|</span>
                            <span class="font-semibold text-yellow-400">★ <?= htmlspecialchars((string) $slide['rating']) ?></span>
                        </div>
                        <a href="#" class="mt-5 inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 text-sm font-bold text-neutral-900 transition hover:bg-neutral-200">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
                            Regarder
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Prev / Next -->
        <button type="button" data-dir="-1" aria-label="Précédent" class="absolute left-3 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full border border-white/20 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 sm:left-5">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" data-dir="1" aria-label="Suivant" class="absolute right-3 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full border border-white/20 bg-black/40 text-white backdrop-blur transition hover:bg-black/70 sm:right-5">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-4 right-6 z-20 flex items-center gap-2">
            <?php foreach ($featured as $i => $slide): ?>
                <button type="button" class="hero-dot h-2 rounded-full transition-all duration-300 <?= $i === 0 ? 'w-5 bg-white' : 'w-2 bg-white/40' ?>" data-index="<?= $i ?>" aria-label="Diapositive <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Movie slider -->
    <section id="movies" data-slider class="mx-auto w-full px-4 py-14 sm:px-6">
        <div class="mb-6 flex items-end justify-between">
            <h2 class="flex items-center gap-2 text-2xl font-bold sm:text-3xl">
                <span aria-hidden="true">🔥</span> Popular Now
            </h2>
            <a href="#" class="flex items-center gap-1 text-sm font-medium text-neutral-400 transition hover:text-white">
                More
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div class="relative">
            <!-- Prev -->
            <button type="button" data-slider-prev aria-label="Précédent" class="absolute left-0 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full border border-white/20 bg-black/60 text-white backdrop-blur transition hover:bg-black/80">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>

            <!-- Track -->
            <div data-slider-track class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-2">
                <?php foreach ($movies as $movie): ?>
                    <article class="group w-[180px] shrink-0 snap-start">
                        <div class="relative flex aspect-[2/3] items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-neutral-800 to-neutral-700 ring-1 ring-white/5 transition group-hover:ring-emerald-400/40">
                            <span class="px-3 text-center text-sm font-semibold text-neutral-400">
                                <?= htmlspecialchars($movie['title']) ?>
                            </span>
                            <span class="absolute right-2 top-2 rounded-md bg-black/70 px-2 py-1 text-xs font-bold text-yellow-400">
                                ★ <?= htmlspecialchars((string) $movie['rating']) ?>
                            </span>
                        </div>
                        <h3 class="mt-2 truncate text-sm font-semibold text-white transition group-hover:text-brand">
                            <?= htmlspecialchars($movie['title']) ?>
                        </h3>
                        <p class="truncate text-xs text-neutral-400">
                            <?= htmlspecialchars((string) $movie['year']) ?> · <?= htmlspecialchars($movie['genre']) ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Next -->
            <button type="button" data-slider-next aria-label="Suivant" class="absolute right-0 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full border border-white/20 bg-black/60 text-white backdrop-blur transition hover:bg-black/80">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </section>

        </div><!-- /Main content column -->
    </div><!-- /Body layout -->

    <!-- Footer -->
    <footer class="border-t border-neutral-800 bg-neutral-950">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-8 text-sm text-neutral-500 sm:flex-row sm:px-6">
            <p>&copy; <?= date('Y') ?> MovieBox. All rights reserved.</p>
            <ul class="flex gap-6">
                <li><a href="#" class="transition hover:text-white">Privacy</a></li>
                <li><a href="#" class="transition hover:text-white">Terms</a></li>
                <li><a href="#" class="transition hover:text-white">Help</a></li>
            </ul>
        </div>
    </footer>

    <!-- Header background on scroll -->
    <script>
        (function () {
            var header = document.getElementById('site-header');
            var scrolledClasses = ['bg-black/95', 'backdrop-blur', 'shadow-lg', 'shadow-black/30'];

            function onScroll() {
                if (window.scrollY > 10) {
                    header.classList.add.apply(header.classList, scrolledClasses);
                } else {
                    header.classList.remove.apply(header.classList, scrolledClasses);
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            // Sidebar toggle
            var sidebar = document.getElementById('sidebar');
            var menuToggle = document.getElementById('menu-toggle');
            if (sidebar && menuToggle) {
                menuToggle.addEventListener('click', function () {
                    var collapsed = sidebar.classList.toggle('w-0');
                    sidebar.classList.toggle('w-56', !collapsed);
                    menuToggle.setAttribute('aria-expanded', String(!collapsed));
                });
            }

            // Hero carousel
            var hero = document.getElementById('hero-slider');
            if (hero) {
                var slides = hero.querySelectorAll('.hero-slide');
                var dots = hero.querySelectorAll('.hero-dot');
                var count = slides.length;
                var current = 0;
                var timer;

                function go(index) {
                    index = (index + count) % count;
                    if (index === current) return;

                    slides[current].classList.replace('opacity-100', 'opacity-0');
                    slides[current].classList.replace('z-10', 'z-0');
                    dots[current].classList.replace('w-5', 'w-2');
                    dots[current].classList.replace('bg-white', 'bg-white/40');

                    current = index;

                    slides[current].classList.replace('opacity-0', 'opacity-100');
                    slides[current].classList.replace('z-0', 'z-10');
                    dots[current].classList.replace('w-2', 'w-5');
                    dots[current].classList.replace('bg-white/40', 'bg-white');
                }

                function restart() {
                    clearInterval(timer);
                    timer = setInterval(function () { go(current + 1); }, 5000);
                }

                hero.querySelectorAll('[data-dir]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        go(current + parseInt(btn.getAttribute('data-dir'), 10));
                        restart();
                    });
                });

                dots.forEach(function (dot) {
                    dot.addEventListener('click', function () {
                        go(parseInt(dot.getAttribute('data-index'), 10));
                        restart();
                    });
                });

                restart();
            }

            // Horizontal content sliders
            document.querySelectorAll('[data-slider]').forEach(function (slider) {
                var track = slider.querySelector('[data-slider-track]');
                if (!track) return;
                var prevBtn = slider.querySelector('[data-slider-prev]');
                var nextBtn = slider.querySelector('[data-slider-next]');

                function step() { return Math.max(track.clientWidth * 0.8, 200); }

                if (prevBtn) prevBtn.addEventListener('click', function () {
                    track.scrollBy({ left: -step(), behavior: 'smooth' });
                });
                if (nextBtn) nextBtn.addEventListener('click', function () {
                    track.scrollBy({ left: step(), behavior: 'smooth' });
                });
            });
        })();
    </script>

</body>
</html>
