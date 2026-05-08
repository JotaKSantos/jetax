<div
    {{ $attributes->merge(['class' => 'w-full divide-y divide-outline-variant rounded-xl bg-surface-container-lowest']) }}
    x-data="{
        active: null,
        mode: '{{ $mode }}',
        toggle(id) {
            if (this.mode === 'single') {
                this.active = this.active === id ? null : id;
            }
        },
        isItemOpen(id) {
            if (this.mode === 'multiple') {
                return null;
            }
            return this.active === id;
        }
    }"
    role="region"
>
    {{ $slot }}
</div>
