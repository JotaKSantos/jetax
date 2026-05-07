@props(['current' => 1, 'vertical' => false, 'clickable' => false])

<div
    x-data="{ current: {{ $current }}, clickable: {{ $clickable ? 'true' : 'false' }} }"
    {{ $attributes->merge(['class' => $containerClasses()]) }}
>
    {{ $slot }}
</div>

@once
<style>
    .step-vertical > *:last-child .step-line { display: none; }
    .step-vertical > *:last-child .step-label { padding-bottom: 0; }
    .step-horizontal > *:last-child .step-line { display: none; }
</style>
@endonce
