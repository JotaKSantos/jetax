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
        {{ $attributes->merge(['class' => 'w-full flex items-center px-4 py-2.5 text-sm transition-colors group ' . $colorClasses()]) }}
    >
        @if($icon)
            <span class="material-symbols-outlined mr-3 text-outline group-hover:text-primary" style="font-size: 18px;">{{ $icon }}</span>
        @endif

        {{ $slot }}
    </button>
@endif
