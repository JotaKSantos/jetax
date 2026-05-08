@props(['title' => 'Jetax — Design System'])
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <style>
        pre { overflow-x: auto; }
        code { font-family: 'Courier New', monospace; font-size: 0.875rem; }
    </style>
</head>
<body class="h-full bg-surface text-on-surface font-body antialiased" x-data>

    @php
        $navGroups = \Jetax\DesignSystem\Docs\ComponentRegistry::all();
        $iconMap = \Jetax\DesignSystem\Docs\ComponentRegistry::componentIcons();
        $currentComponent = request()->segment(3);
    @endphp

    <x-jetax::sidebar :collapsible="true">
        <x-slot:nav>
            {{-- Geral --}}
            <div class="py-2" :class="$store.sidebar.collapsed ? 'px-0' : 'px-6'">
                <p x-show="!$store.sidebar.collapsed" class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">Geral</p>
                <div x-show="$store.sidebar.collapsed" x-cloak class="border-t border-white/10 mx-3"></div>
            </div>

            @php
                $generalLinks = [
                    ['url' => '/docs', 'label' => 'Visão Geral', 'icon' => 'home', 'match' => fn () => request()->is('docs') && !request()->segment(2)],
                    ['url' => '/docs/getting-started', 'label' => 'Primeiros Passos', 'icon' => 'rocket_launch', 'match' => fn () => request()->is('docs/getting-started')],
                    ['url' => '/docs/customization', 'label' => 'Customização', 'icon' => 'palette', 'match' => fn () => request()->is('docs/customization')],
                ];
            @endphp

            @foreach($generalLinks as $link)
                @php $isActive = ($link['match'])(); @endphp
                <div class="relative" x-data="{ flyout: false }" @mouseenter="flyout = true" @mouseleave="flyout = false">
                    <a
                        href="{{ $link['url'] }}"
                        @click="$store.sidebar.open = false"
                        class="flex items-center py-3 transition-colors duration-200
                            {{ $isActive
                                ? 'text-white font-semibold relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#0D99FF] before:rounded-r-full bg-white/5'
                                : 'text-slate-400 hover:text-white hover:bg-white/5'
                            }}"
                        :class="$store.sidebar.collapsed ? 'justify-center px-0' : 'px-6'"
                        @if($isActive) aria-current="page" data-sidebar-active @endif
                    >
                        <span class="material-symbols-outlined" :class="$store.sidebar.collapsed ? '' : 'mr-3'">{{ $link['icon'] }}</span>
                        <span x-show="!$store.sidebar.collapsed" x-transition:leave.opacity.duration.200ms class="text-[11px] font-medium tracking-[0.08em] uppercase">{{ $link['label'] }}</span>
                    </a>
                    <div
                        x-show="$store.sidebar.collapsed && flyout"
                        x-transition.opacity.duration.150ms
                        x-cloak
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-[#1e2438] text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap z-[60] shadow-lg pointer-events-none"
                    >
                        {{ $link['label'] }}
                    </div>
                </div>
            @endforeach

            {{-- Componentes por categoria --}}
            @foreach($navGroups as $category => $items)
                {{-- Grupo expandido (sidebar aberta) --}}
                <div x-show="!$store.sidebar.collapsed">
                    <div class="px-6 py-2 mt-4">
                        <p class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">{{ $category }}</p>
                    </div>

                    @foreach($items as $item)
                        @php $isActive = $currentComponent === $item['slug']; @endphp
                        <a
                            href="/docs/components/{{ $item['slug'] }}"
                            @click="$store.sidebar.open = false"
                            class="flex items-center px-6 py-3 transition-colors duration-200
                                {{ $isActive
                                    ? 'text-white font-semibold relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#0D99FF] before:rounded-r-full bg-white/5'
                                    : 'text-slate-400 hover:text-white hover:bg-white/5'
                                }}"
                            @if($isActive) aria-current="page" data-sidebar-active @endif
                        >
                            <span class="material-symbols-outlined mr-3 text-[18px]">{{ $iconMap[$item['slug']] ?? 'widgets' }}</span>
                            <span class="text-[11px] font-medium tracking-[0.08em] uppercase">{{ $item['name'] }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- Grupo colapsado (sidebar fechada) — ícone do primeiro item + flyout com todos --}}
                <div x-show="$store.sidebar.collapsed" x-cloak class="relative" x-data="{ flyout: false }" @mouseenter="flyout = true" @mouseleave="flyout = false">
                    <div class="py-2">
                        <div class="border-t border-white/10 mx-3"></div>
                    </div>
                    @php
                        $firstItem = $items[0] ?? null;
                        $hasActiveInGroup = collect($items)->contains(fn ($i) => $currentComponent === $i['slug']);
                    @endphp
                    <button
                        type="button"
                        class="w-full flex items-center justify-center py-3 transition-colors duration-200 {{ $hasActiveInGroup ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}"
                    >
                        <span class="material-symbols-outlined text-[20px]">{{ $iconMap[$firstItem['slug'] ?? ''] ?? 'widgets' }}</span>
                    </button>
                    {{-- Flyout do grupo --}}
                    <div
                        x-show="flyout"
                        x-ref="flyoutPanel"
                        x-effect="if (flyout) { $nextTick(() => {
                            const el = $refs.flyoutPanel;
                            const vh = window.innerHeight;
                            const pad = 16;
                            el.style.top = '0';
                            el.style.maxHeight = '';
                            const rect = el.getBoundingClientRect();
                            if (rect.height >= vh - 2 * pad) {
                                el.style.top = (pad - rect.top) + 'px';
                                el.style.maxHeight = (vh - 2 * pad) + 'px';
                            } else if (rect.bottom > vh - pad) {
                                const shift = rect.bottom - vh + pad;
                                const maxShift = rect.top - pad;
                                el.style.top = -Math.min(shift, maxShift) + 'px';
                            }
                        }) }"
                        x-transition.opacity.duration.150ms
                        class="absolute left-full top-0 ml-2 bg-[#1e2438] rounded-lg py-2 z-[60] shadow-lg min-w-[180px] overflow-y-auto sidebar-scroll"
                    >
                        <p class="px-3 py-1.5 text-[10px] font-bold tracking-widest text-slate-500 uppercase">{{ $category }}</p>
                        @foreach($items as $item)
                            @php $isActive = $currentComponent === $item['slug']; @endphp
                            <a
                                href="/docs/components/{{ $item['slug'] }}"
                                @click="$store.sidebar.open = false"
                                class="flex items-center px-3 py-2 text-xs transition-colors duration-200
                                    {{ $isActive ? 'text-white font-semibold bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}"
                            >
                                <span class="material-symbols-outlined mr-2 text-[16px]">{{ $iconMap[$item['slug']] ?? 'widgets' }}</span>
                                {{ $item['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </x-slot:nav>
    </x-jetax::sidebar>

    {{-- Topbar --}}
    <x-jetax::topbar>
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
        </x-slot:actions>
    </x-jetax::topbar>

    {{-- Área de conteúdo principal --}}
    <main class="pt-16 min-h-full overflow-y-auto dark:bg-[rgb(15,18,27)] transition-all duration-300" :class="$store.sidebar.collapsed ? 'md:ml-[70px]' : 'md:ml-64'">
        <div class="p-10 space-y-10">
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>
