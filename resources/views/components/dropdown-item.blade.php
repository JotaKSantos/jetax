{{-- O item `disabled` usa o variante `not-enabled:` (= `:not(:enabled)`) e não `disabled:`:
     a palavra `disabled` numa classe faria um item habilitado conter `disabled`. --}}
@if($isLink())
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => 'flex items-center px-4 py-2.5 text-sm transition-colors group ' . $colorClasses()]) }}
    >
        @if($icon)
            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary" style="font-size: 18px;">{{ $icon }}</span>
        @endif

        {{ $slot }}
    </a>
@else
    <button
        type="button"
        {{ $attributes->merge(['class' => 'w-full flex items-center px-4 py-2.5 text-sm transition-colors group ' . $colorClasses() . ' not-enabled:opacity-40 not-enabled:cursor-not-allowed not-enabled:hover:bg-transparent']) }}
    >
        @if($icon)
            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary" style="font-size: 18px;">{{ $icon }}</span>
        @endif

        {{ $slot }}
    </button>
@endif
