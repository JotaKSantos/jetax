@props(['title' => '', 'description' => '', 'icon' => 'inbox', 'type' => 'empty', 'size' => 'md', 'bordered' => false])

<div {{ $attributes->merge(['class' => $containerClasses()]) }}>
    <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center mb-6">
        <x-jetax-icon :name="$icon" size="36" :class="$iconColorClasses()" />
    </div>

    @if ($title)
        <h3 class="font-headline font-bold text-xl mb-2">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="{{ $descriptionClasses() }}">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="flex gap-4 justify-center">
            {{ $slot }}
        </div>
    @endif
</div>
