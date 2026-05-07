<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    {{-- Anti-FOUC --}}
    <script>
        (function() {
            var theme = localStorage.getItem('jetax-theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(config('jetax.vite_assets', ['resources/css/app.css', 'resources/js/app.js']))
</head>
<body class="font-body antialiased min-h-screen bg-surface-container-lowest dark:bg-on-surface">
    <div class="jetax-auth-layout flex min-h-screen">
        {{-- Left Panel: Branding --}}
        <div class="hidden lg:flex lg:w-[58%] bg-[#202947] relative overflow-hidden flex-col items-center justify-center p-12">
            {{-- Decorative blurs --}}
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-primary-container blur-3xl opacity-10"></div>
            <div class="absolute -bottom-32 -right-32 w-[500px] h-[500px] rounded-full bg-secondary blur-3xl opacity-5"></div>

            {{-- Brand content --}}
            <div class="relative z-10 text-center">
                @if($logo)
                    <div class="mx-auto mb-8 w-16 h-16 rounded-xl bg-gradient-to-br from-primary-container to-info flex items-center justify-center shadow-lg">
                        <img src="{{ $logo }}" alt="Logo" class="w-10 h-10" />
                    </div>
                @else
                    <div class="mx-auto mb-8 w-16 h-16 rounded-xl bg-gradient-to-br from-primary-container to-info flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined text-white text-3xl">lock</span>
                    </div>
                @endif

                <h2 class="font-headline text-white text-5xl md:text-7xl font-bold tracking-tight">Jetax</h2>
                <p class="text-secondary-fixed-dim text-xl md:text-2xl font-medium mt-4">Design System</p>
            </div>

            {{-- Footer --}}
            <p class="absolute bottom-10 text-white/40 text-sm font-label uppercase tracking-widest">
                Powered by TALL Stack
            </p>
        </div>

        {{-- Right Panel: Form --}}
        <div class="jetax-auth-form flex-1 flex items-center justify-center p-6 md:p-12 bg-surface-container-lowest dark:bg-[rgb(15,18,27)]">
            <div class="w-full max-w-[440px]">
                {{-- Form header --}}
                <div class="mb-10 text-left">
                    @if($title)
                        <h1 class="font-headline text-on-surface dark:text-white text-3xl md:text-4xl font-bold">{{ $title }}</h1>
                    @endif
                    @if($subtitle)
                        <p class="text-on-surface-variant dark:text-white/60 text-base mt-2">{{ $subtitle }}</p>
                    @endif
                </div>

                {{-- Form content (slot) --}}
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
