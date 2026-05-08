@props(['padding' => '1.5rem', 'featured' => false])

<div
    {{ $attributes->merge(['class' => $containerClasses()]) }}
>
    @isset($header)
        @php $hasHeader = is_object($header) ? $header->isNotEmpty() : (trim((string) $header) !== ''); @endphp
        @if($hasHeader)
            <div class="{{ $headerClasses() }}">
                <span class="font-headline font-bold text-primary text-sm">{{ $header }}</span>
            </div>
        @endif
    @endisset

    <div style="padding: {{ $padding }};">
        {{ $slot }}
    </div>

    @isset($footer)
        @php $hasFooter = is_object($footer) ? $footer->isNotEmpty() : (trim((string) $footer) !== ''); @endphp
        @if($hasFooter)
            <div class="bg-surface-container-low px-6 py-4">
                {{ $footer }}
            </div>
        @endif
    @endisset
</div>
