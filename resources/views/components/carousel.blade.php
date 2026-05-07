<div
    {{ $attributes->merge(['class' => 'relative overflow-hidden w-full']) }}
    x-data="{
        current: 0,
        total: 0,
        autoplay: {{ $autoplay ? 'true' : 'false' }},
        interval: {{ $interval }},
        _timer: null,
        init() {
            this.total = this.$el.querySelectorAll('.carousel-item').length;
            if (this.autoplay && this.total > 1) {
                this._timer = setInterval(() => { this.next(); }, this.interval);
            }
        },
        next() {
            this.current = this.current >= this.total - 1 ? 0 : this.current + 1;
        },
        prev() {
            this.current = this.current <= 0 ? this.total - 1 : this.current - 1;
        },
        goTo(index) {
            this.current = index;
        }
    }"
>
    {{-- Faixa de slides --}}
    <div
        class="flex transition-transform duration-500 ease-in-out"
        :style="'transform: translateX(-' + (current * 100) + '%)'"
    >
        {{ $slot }}
    </div>

    {{-- Seta anterior --}}
    <button
        type="button"
        class="absolute left-2 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center w-8 h-8 rounded-full bg-white/80 dark:bg-surface-container/80 shadow hover:bg-white dark:hover:bg-surface-container focus:outline-none"
        @click="prev()"
        aria-label="Slide anterior"
    >
        <x-jetax-icon name="chevron_left" size="md" />
    </button>

    {{-- Seta próxima --}}
    <button
        type="button"
        class="absolute right-2 top-1/2 -translate-y-1/2 z-10 flex items-center justify-center w-8 h-8 rounded-full bg-white/80 dark:bg-surface-container/80 shadow hover:bg-white dark:hover:bg-surface-container focus:outline-none"
        @click="next()"
        aria-label="Próximo slide"
    >
        <x-jetax-icon name="chevron_right" size="md" />
    </button>

    {{-- Indicadores (dots) --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        <template x-for="(item, index) in total" :key="index">
            <button
                type="button"
                class="carousel-indicator w-2 h-2 rounded-full transition-colors focus:outline-none"
                :class="current === index ? 'bg-white' : 'bg-white/50'"
                @click="goTo(index)"
                :aria-label="'Ir para slide ' + (index + 1)"
            ></button>
        </template>
    </div>
</div>
