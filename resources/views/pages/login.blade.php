<x-layouts.app title="Sign in" description="Sign in to your Systech Studio dashboard.">

    <section class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-white">
        {{-- Decorative blurred blobs (matches the home hero) --}}
        <div class="absolute inset-0 -z-10 opacity-50" aria-hidden="true">
            <div class="absolute -top-40 -right-40 h-[36rem] w-[36rem] rounded-full bg-indigo-200 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-[36rem] w-[36rem] rounded-full bg-blue-100 blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="mx-auto max-w-md">

                {{-- Heading --}}
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2" aria-label="Systech Studio home">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-indigo-600 to-blue-500 text-white font-bold shadow-sm">S</span>
                    </a>

                    <span class="mt-6 inline-flex items-center gap-2 rounded-full bg-white ring-1 ring-slate-200 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-indigo-700 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        Admin access
                    </span>

                    <h1 class="mt-4 text-3xl sm:text-4xl font-bold tracking-tight text-slate-900">
                        Welcome <span class="bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">back</span>
                    </h1>
                    <p class="mt-3 text-sm text-slate-600">Sign in to your Systech Studio dashboard.</p>
                </div>

                {{-- Card --}}
                <div class="mt-8 rounded-2xl bg-white ring-1 ring-slate-200 shadow-sm p-8 sm:p-10">

                    @if (session('status'))
                        <div class="mb-6 rounded-lg bg-emerald-50 ring-1 ring-emerald-200 p-4 flex items-start gap-3" role="status">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg bg-rose-50 ring-1 ring-rose-200 p-4 flex items-start gap-3" role="alert">
                            <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m0 3.75h.008v.008H12V16.5zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-medium text-rose-800">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6" novalidate>
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700">Email <span class="text-rose-500">*</span></label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                                @class([
                                    'mt-2 block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                    'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('email'),
                                    'ring-rose-400 focus:ring-rose-500' => $errors->has('email'),
                                ])
                                placeholder="you@company.com"
                            >
                            @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password --}}
                        <div x-data="{ show: false }">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password <span class="text-rose-500">*</span></label>
                                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">Forgot password?</a>
                            </div>

                            <div class="relative mt-2">
                                <input
                                    :type="show ? 'text' : 'password'"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    @class([
                                        'block w-full rounded-lg border-0 py-2.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:outline-none transition',
                                        'ring-slate-300 focus:ring-indigo-600' => ! $errors->has('password'),
                                        'ring-rose-400 focus:ring-rose-500' => $errors->has('password'),
                                    ])
                                    placeholder="••••••••"
                                >
                                <button
                                    type="button"
                                    @click="show = ! show"
                                    class="absolute top-0 bottom-0 right-0 flex items-center px-3 text-slate-400 focus:outline-none"
                                    :aria-label="show ? 'Hide password' : 'Show password'"
                                >
                                    <svg x-show="! show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                </button>
                            </div>
                            @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="flex items-center">
                            <label class="flex items-center gap-2 text-sm text-slate-600 select-none">
                                <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                Remember me on this device
                            </label>
                        </div>

                        <x-button type="submit" variant="primary" class="w-full">
                            Sign in
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </x-button>
                    </form>
                </div>

                <p class="mt-6 text-center text-xs text-slate-500">
                    Protected area &middot; Authorised personnel only.
                </p>
            </div>
        </div>
    </section>

</x-layouts.app>
