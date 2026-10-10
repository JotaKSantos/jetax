@props([])

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'jetax-dark-mode-toggle inline-flex items-center justify-center w-10 h-10 rounded-lg text-on-surface-variant dark:text-white/60 hover:bg-surface-container-low dark:hover:bg-white/5 transition-colors',
        'aria-label' => 'Alternar modo escuro',
    ]) }}
    x-data="jetaxDarkMode()"
    @click="toggle()"
>
    {{-- Sun icon (visible in dark mode) --}}
    <x-jetax-icon name="sun" size="md" x-show="isDark" />
    {{-- Moon icon (visible in light mode) --}}
    <x-jetax-icon name="moon" size="md" x-show="!isDark" />
</button>

@once
@push('jetax-scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('jetaxDarkMode', () => ({
            isDark: document.documentElement.classList.contains('dark'),

            toggle() {
                this.isDark = !this.isDark;
                document.documentElement.classList.toggle('dark', this.isDark);
                localStorage.setItem('jetax-theme', this.isDark ? 'dark' : 'light');
            },

            init() {
                this.isDark = document.documentElement.classList.contains('dark');
            }
        }));
    });
</script>
@endpush
@endonce
