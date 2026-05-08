<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    {{-- Anti-FOUC: carrega dark mode do localStorage antes do render --}}
    <script>
        (function() {
            var theme = localStorage.getItem('jetax-theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(config('jetax.vite_assets', ['resources/css/app.css', 'resources/js/app.js']))
    @include('jetax::partials.sidebar-store')
</head>
<body class="font-body antialiased bg-surface text-on-surface min-h-screen">
    <div class="flex min-h-screen" x-data>
        {{-- Sidebar --}}
        <x-jetax::sidebar :title="$title" />

        {{-- Área Principal --}}
        <div class="flex-1 ml-0 min-h-screen flex flex-col transition-all duration-300" :class="$store.sidebar.collapsed ? 'md:ml-[70px]' : 'md:ml-64'">
            {{-- Topbar --}}
            <x-jetax::topbar :title="$title">
                <x-slot:actions>
                    {{-- Fullscreen --}}
                    <button
                        type="button"
                        class="p-2 text-on-surface/60 dark:text-slate-400 hover:text-primary hover:bg-surface-container-high rounded-lg transition-all"
                        aria-label="Tela cheia"
                    >
                        <span class="material-symbols-outlined">fullscreen</span>
                    </button>

                    {{-- Notifications --}}
                    <button
                        type="button"
                        class="p-2 text-on-surface/60 dark:text-slate-400 hover:text-primary hover:bg-surface-container-high rounded-lg transition-all relative"
                        aria-label="Notificações"
                    >
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full ring-2 ring-surface-container-lowest dark:ring-sidebar"></span>
                    </button>

                    {{-- Dark mode toggle --}}
                    <button
                        type="button"
                        x-data="{ dark: document.documentElement.classList.contains('dark') }"
                        x-on:click="dark = !dark; document.documentElement.classList.toggle('dark'); localStorage.setItem('jetax-theme', dark ? 'dark' : 'light')"
                        class="p-2 rounded-lg transition-all text-on-surface/60 dark:text-slate-400 hover:text-primary hover:bg-surface-container-high"
                        aria-label="Alternar modo escuro"
                    >
                        <span class="material-symbols-outlined" x-show="!dark">dark_mode</span>
                        <span class="material-symbols-outlined" x-show="dark" x-cloak>light_mode</span>
                    </button>

                    {{-- Divider --}}
                    <div class="h-8 w-px bg-outline-variant/30 mx-2"></div>

                    {{-- User profile --}}
                    <div class="flex items-center gap-3 cursor-pointer hover:bg-surface-container-high p-1.5 rounded-xl transition-all">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold leading-tight text-on-surface">Admin User</p>
                            <p class="text-[10px] text-on-surface/60 dark:text-slate-400">Administrator</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-lg">person</span>
                        </div>
                    </div>

                    @if(isset($actions))
                        {{ $actions }}
                    @endif
                </x-slot:actions>
            </x-jetax::topbar>

            {{-- Workspace --}}
            <main class="jetax-workspace flex-1 pt-16 overflow-y-auto">
                <div class="p-6 md:p-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
