@php
    $itemId = 'accordion-item-' . \Illuminate\Support\Str::random(8);
@endphp

<div
    {{ $attributes->merge(['class' => 'accordion-item']) }}
    x-data="{
        id: '{{ $itemId }}',
        localOpen: {{ $open ? 'true' : 'false' }},
        get isOpen() {
            if (this.mode === 'multiple' || typeof this.$data.mode === 'undefined') {
                return this.localOpen;
            }
            const parentState = this.isItemOpen?.(this.id);
            return parentState !== null ? parentState : this.localOpen;
        },
        handleToggle() {
            if (typeof this.toggle === 'function' && this.mode === 'single') {
                this.toggle(this.id);
            } else {
                this.localOpen = !this.localOpen;
            }
        }
    }"
>
    <button
        type="button"
        class="accordion-header w-full px-6 py-4 flex items-center justify-between text-left hover:bg-surface-container-low transition-colors"
        x-on:click="handleToggle()"
        :aria-expanded="isOpen"
    >
        <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $title }}</span>
        <span
            class="material-symbols-outlined text-slate-400 chevron transition-transform duration-300"
            :class="{ 'rotate-180': isOpen }"
        >expand_more</span>
    </button>

    <div
        class="overflow-hidden transition-all duration-300 ease-out"
        x-show="isOpen"
        x-collapse
    >
        <div class="px-6 pb-4 text-sm text-slate-500 dark:text-slate-400">
            {{ $slot }}
        </div>
    </div>
</div>
