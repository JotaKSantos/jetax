<div
    x-data="{ dismissed: false, persistKey: '{{ $persistKey ?? '' }}' }"
    x-init="if (persistKey && localStorage.getItem('jetax-dismiss-' + persistKey)) { dismissed = true }"
    x-show="!dismissed"
    x-transition
    {{ $attributes->merge(['class' => 'relative']) }}
>
    {{ $slot }}

    @isset($dismissTrigger)
        @php $hasTrigger = is_object($dismissTrigger) ? $dismissTrigger->isNotEmpty() : (trim((string) $dismissTrigger) !== ''); @endphp
        @if($hasTrigger)
            <div @click="dismissed = true; if (persistKey) { localStorage.setItem('jetax-dismiss-' + persistKey, '1') }">
                {{ $dismissTrigger }}
            </div>
        @else
            <button
                type="button"
                @click="dismissed = true; if (persistKey) { localStorage.setItem('jetax-dismiss-' + persistKey, '1') }"
                class="absolute top-0 right-0 p-1 text-current opacity-60 hover:opacity-100 transition-opacity"
                aria-label="Fechar"
            >
                <x-jetax-icon name="close" size="sm" />
            </button>
        @endif
    @else
        <button
            type="button"
            @click="dismissed = true; if (persistKey) { localStorage.setItem('jetax-dismiss-' + persistKey, '1') }"
            class="absolute top-0 right-0 p-1 text-current opacity-60 hover:opacity-100 transition-opacity"
            aria-label="Fechar"
        >
            <x-jetax-icon name="close" size="sm" />
        </button>
    @endisset
</div>
