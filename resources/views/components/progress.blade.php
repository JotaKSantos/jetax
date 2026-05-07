@props(['value' => 0, 'max' => 100, 'color' => 'primary', 'label' => null, 'animated' => false])


@if ($label !== null)
<div class="flex justify-between items-center mb-1">
    <span class="text-xs font-medium text-on-surface-variant">{{ $label }}</span>
    <span class="text-xs font-medium text-on-surface-variant">{{ number_format($percentage(), 0) }}%</span>
</div>
@endif

<div
    {{ $attributes->merge(['class' => 'w-full bg-surface-container-low ' . $sizeClasses() . ' rounded-full overflow-hidden']) }}
    role="progressbar"
    aria-valuenow="{{ $value }}"
    aria-valuemin="0"
    aria-valuemax="{{ $max }}"
>
    <div
        class="h-full rounded-full {{ $colorClasses() }}{{ $animated ? ' progress-striped' : '' }}"
        style="width: {{ $percentage() }}%"
    ></div>
</div>
