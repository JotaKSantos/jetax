<div
    {{ $attributes->merge(['class' => 'w-full divide-y divide-slate-100 rounded-xl bg-white dark:bg-surface-container-low dark:divide-white/10']) }}
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
