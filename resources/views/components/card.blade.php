@props(['padding' => '1.5rem', 'featured' => false, 'headerClass' => '', 'footerClass' => ''])

<div
    {{ $attributes->merge(['class' => $containerClasses()]) }}
>
    @isset($header)
        @php $hasHeader = is_object($header) ? $header->isNotEmpty() : (trim((string) $header) !== ''); @endphp
        @if($hasHeader)
            <div class="{{ $headerClasses() }}">
                {{ $header }}
            </div>
        @endif
    @endisset

    <div style="padding: {{ $padding }};">
        {{ $slot }}
    </div>

    @isset($footer)
        @php $hasFooter = is_object($footer) ? $footer->isNotEmpty() : (trim((string) $footer) !== ''); @endphp
        @if($hasFooter)
            <div class="{{ $footerClasses() }}">
                {{ $footer }}
            </div>
        @endif
    @endisset
</div>
