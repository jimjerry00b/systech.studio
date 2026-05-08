<footer class="bg-slate-900 text-slate-300 mt-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-gradient-to-br from-indigo-500 to-blue-400 text-white font-bold text-sm">S</span>
                    <span class="text-lg font-semibold tracking-tight text-white">Systech<span class="text-indigo-400">Studio</span></span>
                </a>
                <p class="mt-4 max-w-md text-sm text-slate-400 leading-relaxed">
                    A digital studio crafting modern websites, applications, and brands for ambitious teams. Built on engineering excellence and design that lasts.
                </p>
            </div>

            <div class="lg:col-span-2">
                <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Studio</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">Services</a></li>
                    <li><a href="{{ route('projects.index') }}" class="hover:text-white transition">Projects</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Services</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">Web Development</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">UI / UX Design</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">Mobile Apps</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white transition">Cloud & DevOps</a></li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h3 class="text-sm font-semibold text-white tracking-wide uppercase">Get in touch</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="mailto:hello@systechstudio.test" class="hover:text-white transition">hello@systechstudio.test</a></li>
                    <li class="text-slate-400">Mon – Fri, 9:00 – 18:00</li>
                </ul>
                <div class="mt-4 flex items-center gap-3">
                    <a href="#" aria-label="LinkedIn" class="grid h-9 w-9 place-items-center rounded-md bg-slate-800 hover:bg-indigo-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="#" aria-label="Twitter" class="grid h-9 w-9 place-items-center rounded-md bg-slate-800 hover:bg-indigo-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="GitHub" class="grid h-9 w-9 place-items-center rounded-md bg-slate-800 hover:bg-indigo-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.4 3-.405 1.02.005 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Systech Studio. All rights reserved.</p>
            <p>Built with Laravel {{ app()->version() }} & Tailwind CSS.</p>
        </div>
    </div>
</footer>
