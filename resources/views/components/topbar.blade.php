@props(['title' => ''])

<header
    {{ $attributes->merge(['class' => 'jetax-topbar fixed top-0 left-0 right-0 h-16 z-40 flex items-center justify-between px-4 md:px-6 bg-surface-container-lowest/80 dark:bg-sidebar/80 backdrop-blur-xl shadow-ambient dark:border-b dark:border-outline-variant/30 transition-all duration-300']) }}
    :class="$store.sidebar.collapsed ? 'md:left-[70px]' : 'md:left-64'"
>
    {{-- Left side: hamburger + search --}}
    <div class="flex items-center gap-4">
        {{-- Hamburger button --}}
        <button
            type="button"
            class="flex items-center justify-center w-10 h-10 rounded-lg text-on-surface/60 dark:text-slate-400 hover:bg-surface-container-high transition-colors"
            @click="
                if (window.innerWidth >= 768) {
                    $store.sidebar.toggle();
                } else {
                    $store.sidebar.open = !$store.sidebar.open;
                }
            "
            aria-label="Alternar menu"
        >
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>

        {{-- Search bar --}}
        <div class="relative hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface/40 dark:text-slate-400">search</span>
            <input
                type="text"
                placeholder="Pesquisar..."
                class="bg-surface-container-high border-none rounded-xl pl-10 pr-4 py-2 text-sm w-64 transition-all text-on-surface dark:text-slate-200 placeholder:text-on-surface/40 dark:placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20"
            >
        </div>
    </div>

    {{-- Right side: actions slot --}}
    <div class="flex items-center gap-3">
        @if(isset($actions))
            {{ $actions }}
        @endif
    </div>
</header>
