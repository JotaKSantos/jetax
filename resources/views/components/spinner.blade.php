<div
    {{ $attributes->merge(['class' => trim(implode(' ', ['animate-spin rounded-[1.5rem]', $sizeClasses(), $borderClasses()]))]) }}
    aria-hidden="true"
></div>
