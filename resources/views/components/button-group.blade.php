<div {{ $attributes->merge(['class' => $containerClasses(), 'role' => 'group']) }}>
    {{ $slot }}
</div>
