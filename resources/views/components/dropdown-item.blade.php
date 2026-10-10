{{-- O item `disabled` usa o variante `not-enabled:` (= `:not(:enabled)`) e não `disabled:`:
     a palavra `disabled` numa classe faria um item habilitado conter `disabled`. --}}
@if($isLink())
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => 'flex items-center px-4 py-2.5 text-sm transition-colors group ' . $colorClasses()]) }}
    >
        @if($icon)
            <x-jetax-icon :name="$icon" size="18" class="mr-3 text-outline group-hover:text-primary" />
        @endif

        {{ $slot }}
    </a>
@else
    <button
        type="button"
        {{ $attributes->merge(['class' => 'w-full flex items-center px-4 py-2.5 text-sm transition-colors group ' . $colorClasses() . ' not-enabled:opacity-40 not-enabled:cursor-not-allowed not-enabled:hover:bg-transparent']) }}
    >
        @if($icon)
            <x-jetax-icon :name="$icon" size="18" class="mr-3 text-outline group-hover:text-primary" />
        @endif

        {{ $slot }}
    </button>
@endif
