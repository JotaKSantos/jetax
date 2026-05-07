@props(['title' => '', 'collapsible' => false])

{{-- Backdrop mobile --}}
<div
    x-show="$store.sidebar.open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$store.sidebar.open = false"
    class="fixed inset-0 bg-black/40 z-[45] md:hidden"
    x-cloak
></div>

<aside
    {{ $attributes->merge(['class' => 'jetax-sidebar fixed left-0 top-0 h-full bg-sidebar z-50 flex-col shadow-[16px_0_32px_rgba(17,26,55,0.04)] pb-8 transition-all duration-300']) }}
    :class="[
        $store.sidebar.open ? 'flex' : 'hidden md:flex',
        $store.sidebar.collapsed ? 'md:w-[70px] md:overflow-visible w-64 sidebar-scroll overflow-y-auto' : 'w-64 sidebar-scroll overflow-y-auto'
    ]"
>
    {{-- Branding --}}
    <div class="py-8 flex flex-col gap-2 transition-all duration-300 overflow-hidden" :class="$store.sidebar.collapsed ? 'px-0 items-center' : 'px-6'">
        <h1 class="font-headline text-xl font-bold text-white tracking-tight whitespace-nowrap">
            <span x-show="$store.sidebar.collapsed" x-cloak class="text-lg">J</span>
            <span x-show="!$store.sidebar.collapsed">Jetax</span>
        </h1>
        <p x-show="!$store.sidebar.collapsed" x-transition:leave.opacity.duration.200ms class="font-label text-[11px] uppercase text-slate-400 tracking-[0.08em] font-medium">Design System</p>
    </div>

    {{-- Navegação principal --}}
    <nav
        class="flex flex-col gap-1"
        aria-label="Navegação principal"
        x-init="$nextTick(() => {
            const aside = $el.closest('.sidebar-scroll') || $el.closest('aside');
            const active = aside?.querySelector('[data-sidebar-active]');
            if (active) active.scrollIntoView({ block: 'center', behavior: 'smooth' });
        })"
    >
        @if(isset($nav))
            {{ $nav }}
        @else
            @php
                $navItems = config('jetax.navigation.main', []);
                $currentGroup = null;
            @endphp

            @foreach($navItems as $item)
                @if(($item['group'] ?? null) !== $currentGroup)
                    @php $currentGroup = $item['group'] ?? null; @endphp
                    @if($currentGroup)
                        <div class="py-2 {{ !$loop->first ? 'mt-4' : '' }}" :class="$store.sidebar.collapsed ? 'px-0' : 'px-6'">
                            <p x-show="!$store.sidebar.collapsed" class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">{{ $currentGroup }}</p>
                            <div x-show="$store.sidebar.collapsed" x-cloak class="border-t border-white/10 mx-3"></div>
                        </div>
                    @endif
                @endif

                @php
                    $isActive = request()->routeIs($item['route'] ?? '');
                @endphp
                <div class="relative" x-data="{ flyout: false }" @mouseenter="flyout = true" @mouseleave="flyout = false">
                    <a
                        href="{{ $item['url'] ?? '#' }}"
                        @click="$store.sidebar.open = false"
                        class="flex items-center py-3 transition-colors duration-200
                            {{ $isActive
                                ? 'text-white font-semibold relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#0D99FF] before:rounded-r-full bg-white/5'
                                : 'text-slate-400 hover:text-white hover:bg-white/5'
                            }}"
                        :class="$store.sidebar.collapsed ? 'justify-center px-0' : 'px-6'"
                        @if($isActive) aria-current="page" data-sidebar-active @endif
                    >
                        <span class="material-symbols-outlined" :class="$store.sidebar.collapsed ? '' : 'mr-3'">{{ $item['icon'] ?? '' }}</span>
                        <span x-show="!$store.sidebar.collapsed" x-transition:leave.opacity.duration.200ms class="text-[11px] font-medium tracking-[0.08em] uppercase">{{ $item['label'] }}</span>
                    </a>
                    {{-- Flyout tooltip --}}
                    <div
                        x-show="$store.sidebar.collapsed && flyout"
                        x-transition.opacity.duration.150ms
                        x-cloak
                        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-[#1e2438] text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap z-[60] shadow-lg pointer-events-none"
                    >
                        {{ $item['label'] }}
                    </div>
                </div>
            @endforeach
        @endif
    </nav>

    {{-- Footer navigation --}}
    <div class="mt-auto pt-8 border-t border-white/5">
        @foreach(config('jetax.navigation.footer', []) as $item)
            @php
                $isActive = request()->routeIs($item['route'] ?? '');
            @endphp
            <div class="relative" x-data="{ flyout: false }" @mouseenter="flyout = true" @mouseleave="flyout = false">
                <a
                    href="{{ $item['url'] ?? '#' }}"
                    @click="$store.sidebar.open = false"
                    class="flex items-center py-3 transition-colors duration-200
                        {{ $isActive
                            ? 'text-white font-semibold relative before:content-[\'\'] before:absolute before:left-0 before:w-1 before:h-6 before:bg-[#0D99FF] before:rounded-r-full bg-white/5'
                            : 'text-slate-400 hover:text-white hover:bg-white/5'
                        }}"
                    :class="$store.sidebar.collapsed ? 'justify-center px-0' : 'px-6'"
                    @if($isActive) aria-current="page" data-sidebar-active @endif
                >
                    <span class="material-symbols-outlined" :class="$store.sidebar.collapsed ? '' : 'mr-3'">{{ $item['icon'] ?? '' }}</span>
                    <span x-show="!$store.sidebar.collapsed" x-transition:leave.opacity.duration.200ms class="text-[11px] font-medium tracking-[0.08em] uppercase">{{ $item['label'] }}</span>
                </a>
                {{-- Flyout tooltip --}}
                <div
                    x-show="$store.sidebar.collapsed && flyout"
                    x-transition.opacity.duration.150ms
                    x-cloak
                    class="absolute left-full top-1/2 -translate-y-1/2 ml-2 bg-[#1e2438] text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap z-[60] shadow-lg pointer-events-none"
                >
                    {{ $item['label'] }}
                </div>
            </div>
        @endforeach
    </div>
</aside>
