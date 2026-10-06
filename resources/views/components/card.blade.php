@php
    $consumerClasses = $splitConsumerClasses((string) $attributes->get('class', ''));
@endphp

<div
    {{ $attributes->except('class')->merge(['class' => trim($containerClasses().' '.$consumerClasses['container'])]) }}
>
    @isset($header)
        @php $hasHeader = is_object($header) ? $header->isNotEmpty() : (trim((string) $header) !== ''); @endphp
        @if($hasHeader)
            <div class="{{ $headerClasses() }}">
                {{ $header }}
            </div>
        @endif
    @endisset

    <div class="{{ $bodyClasses($consumerClasses['padding']) }}">
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
