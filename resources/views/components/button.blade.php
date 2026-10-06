@php
    $assertAccessibleName(trim((string) $slot) !== '', $attributes->has('aria-label'), $attributes->has('title'));
    $isDisabled = $loading || $attributes->get('disabled', false) !== false;
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-semibold transition-all';
    $widthClass = $block && ! $iconOnly ? 'w-full' : '';
    $sizeClasses = $sizeClasses();
    $appliedStyleClasses = $isDisabled ? $disabledClasses() : $styleClasses();
@endphp

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => trim(implode(' ', array_filter([$baseClasses, $sizeClasses, $appliedStyleClasses, $widthClass]))),
    ])->merge(array_filter(['style' => $isDisabled ? '' : $customStyle()])) }}
    @if($isDisabled) disabled @endif
>
    @if($loading)
        <x-jetax-spinner />
    @elseif($icon && $iconPosition === 'left')
        <span class="material-symbols-outlined">{{ $icon }}</span>
    @endif

    {{ $slot }}

    @if(!$loading && $icon && $iconPosition === 'right')
        <span class="material-symbols-outlined">{{ $icon }}</span>
    @endif
</button>
