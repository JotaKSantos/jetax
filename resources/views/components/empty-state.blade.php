@props(['title' => '', 'description' => '', 'icon' => 'inbox', 'type' => 'empty'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center p-12']) }}>
    <div class="w-20 h-20 rounded-full bg-surface-container-low flex items-center justify-center mb-6">
        <span class="material-symbols-outlined text-4xl {{ $iconColorClasses() }}">{{ $icon }}</span>
    </div>

    @if ($title)
        <h3 class="font-headline font-bold text-xl mb-2">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="text-on-surface-variant text-sm mb-8 max-w-xs">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="flex gap-4 justify-center">
            {{ $slot }}
        </div>
    @endif
</div>
