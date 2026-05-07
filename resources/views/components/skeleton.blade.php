<style>
    @keyframes jetax-shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .jetax-skeleton-shimmer {
        background: linear-gradient(90deg, #f3f2ff 25%, #ebedff 50%, #f3f2ff 75%);
        background-size: 200% 100%;
        animation: jetax-shimmer 1.5s infinite linear;
    }
</style>
<div
    {{ $attributes->merge(['class' => 'jetax-skeleton-shimmer '.$skeletonClasses()]) }}
></div>
