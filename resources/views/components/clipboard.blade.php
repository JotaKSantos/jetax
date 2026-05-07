<div
    x-data="{ copied: false, text: '{{ $text }}' }"
    {{ $attributes }}
>
    @if ($slot->isEmpty())
        <button
            type="button"
            @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)"
            class="inline-flex items-center justify-center rounded p-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors"
            title="{{ $successMessage ?: 'Copiar' }}"
        >
            <x-jetax-icon name="content_copy" x-show="!copied" />
            <x-jetax-icon name="check" x-show="copied" />
        </button>
    @else
        <div
            @click="navigator.clipboard.writeText(text); copied = true; setTimeout(() => copied = false, 2000)"
        >
            {{ $slot }}
        </div>
        <x-jetax-icon name="content_copy" x-show="!copied" class="hidden" />
        <x-jetax-icon name="check" x-show="copied" class="hidden" />
    @endif
</div>
