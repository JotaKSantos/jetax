@if($isLink())
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $itemClasses()]) }}
    >
        <div class="flex items-center gap-4 flex-1 min-w-0">
            @if($icon)
                <span class="material-symbols-outlined text-primary text-lg shrink-0">{{ $icon }}</span>
            @endif

            <div class="flex flex-col min-w-0">
                @if($title)
                    <span class="font-medium truncate">{{ $title }}</span>
                @endif
                @if($subtitle)
                    <span class="text-xs text-on-surface-variant truncate">{{ $subtitle }}</span>
                @endif
                @if(!$title && !$subtitle)
                    {{ $slot }}
                @endif
            </div>
        </div>

        @if(isset($actions) && $actions->isNotEmpty())
            <div class="flex items-center gap-2 shrink-0 ml-4">
                {{ $actions }}
            </div>
        @endif
    </a>
@else
    <div {{ $attributes->merge(['class' => $itemClasses()]) }}>
        <div class="flex items-center gap-4 flex-1 min-w-0">
            @if($icon)
                <span class="material-symbols-outlined text-primary text-lg shrink-0">{{ $icon }}</span>
            @endif

            <div class="flex flex-col min-w-0">
                @if($title)
                    <span class="font-medium truncate">{{ $title }}</span>
                @endif
                @if($subtitle)
                    <span class="text-xs text-on-surface-variant truncate">{{ $subtitle }}</span>
                @endif
                @if(!$title && !$subtitle)
                    {{ $slot }}
                @endif
            </div>
        </div>

        @if(isset($actions) && $actions->isNotEmpty())
            <div class="flex items-center gap-2 shrink-0 ml-4">
                {{ $actions }}
            </div>
        @endif
    </div>
@endif
