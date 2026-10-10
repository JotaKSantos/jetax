{{-- Superfície igual à da sidebar nos dois temas (`bg-sidebar`), com borda inferior sempre
     presente. Sem `transition-all`: o `left` depende do `$store.sidebar`, lido do localStorage
     só depois do primeiro paint, e com transição a barra deslizava a cada carga de página.

     Larguras padrão (literais aqui para o Tailwind gerar): md:left-[16rem] md:left-[70px] --}}
<header
    {{ $attributes->merge(['class' => 'jetax-topbar fixed top-0 left-0 right-0 h-16 z-40 flex items-center justify-between px-4 md:px-5 bg-sidebar border-b border-outline-variant']) }}
    :class="$store.sidebar.collapsed ? '{{ $collapsedLeftClass() }}' : '{{ $expandedLeftClass() }}'"
>
    {{-- Esquerda: hambúrguer, ações contextuais da tela e título --}}
    <div class="flex items-center gap-2.5">
        <button
            type="button"
            class="flex items-center justify-center w-[38px] h-[38px] rounded-[9px] border border-outline-variant bg-surface-container text-on-surface-variant hover:text-primary hover:border-primary/40 transition-colors"
            @click="
                if (window.innerWidth >= 768) {
                    $store.sidebar.toggle();
                } else {
                    $store.sidebar.open = !$store.sidebar.open;
                }
            "
            aria-label="Alternar menu"
        >
            <x-jetax-icon name="bars" size="22" />
        </button>

        @if(isset($leftActions))
            {{ $leftActions }}
        @endif

        @if($title !== '')
            <span class="hidden lg:block text-sm font-semibold text-on-surface-variant truncate">{{ $title }}</span>
        @endif
    </div>

    {{-- Direita: ações --}}
    <div class="flex items-center gap-2.5">
        @if(isset($actions))
            {{ $actions }}
        @endif
    </div>
</header>
