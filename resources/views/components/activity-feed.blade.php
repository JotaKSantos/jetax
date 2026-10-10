@props(['hasMore' => false])

<div {{ $attributes->merge(['class' => 'flex flex-col space-y-0']) }}>
    {{ $slot }}

    @if($hasMore)
        <div class="pt-4 flex justify-center">
            <button
                type="button"
                class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors flex items-center gap-1"
                wire:click="$dispatch('load-more')"
                @click="$dispatch('load-more')"
            >
                <x-jetax-icon name="chevron-down" size="sm" />
                Ver mais
            </button>
        </div>
    @endif
</div>
