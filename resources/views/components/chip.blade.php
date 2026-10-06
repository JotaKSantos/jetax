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
    ><span class="material-symbols-outlined text-sm leading-none" aria-hidden="true">close</span></button>@endif</span>
