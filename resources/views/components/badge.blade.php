<span
    {{ $attributes->merge(['class' => $radiusClasses() . ' ' . $paddingClasses() . ' ' . $colorClasses() . ' inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider']) }}
>
    @if ($style === 'status')
        <span class="w-2 h-2 rounded-full {{ $dotClasses() }}"></span>
    @endif
    {{ $slot }}
</span>
