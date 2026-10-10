<span
    {{ $rootAttributes($attributes)->merge([
        'class' => 'inline-flex items-center gap-2 h-7 rounded-[7px] bg-primary/12 border border-primary/35 text-xs font-semibold text-primary '.($removable ? 'pl-3 pr-1.5' : 'px-3'),
    ]) }}
>{{ $label !== '' ? $label : $slot }}@if ($removable)<button
        {{ $removeAttributes($attributes)->merge([
            'type' => 'button',
            'class' => 'inline-flex items-center justify-center rounded-full text-primary hover:text-on-surface transition-colors',
            'aria-label' => $removeLabel,
            'title' => $removeLabel,
        ]) }}
    ><x-jetax-icon name="xmark" size="14" class="leading-none" /></button>@endif</span>
