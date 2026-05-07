<button
    {{ $attributes->merge(['class' => 'fixed bottom-6 right-6 z-40 rounded-full bg-primary text-white shadow-lg p-3 transition-colors hover:bg-primary/90 focus:outline-none']) }}
    x-data="{ visible: false }"
    x-show="visible"
    x-transition
    @scroll.window="visible = window.scrollY > {{ $threshold }}"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    aria-label="Voltar ao topo"
    type="button"
>
    <x-jetax-icon name="arrow_upward" />
</button>
