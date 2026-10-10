@if($message !== null || $slot->isNotEmpty())
    @if($style === 'solid')
        <div
            {{ $attributes
                ->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon'])
                ->merge(['class' => $solidClasses().' px-5 py-3.5 rounded-lg flex items-center gap-3']) }}
            x-data="{ show: true }"
            x-show="show"
            role="alert"
        >
            @if($icon)
                <x-jetax-icon :name="$icon" size="lg" />
            @endif

            <span class="text-sm font-medium flex-1">
                @if($message)
                    {{ $message }}
                @else
                    {{ $slot }}
                @endif
            </span>

            @if($dismissible)
                <button
                    type="button"
                    x-on:click="show = false"
                    class="p-1 hover:bg-current/15 rounded transition-colors"
                    aria-label="Fechar"
                >
                    <x-jetax-icon name="xmark" size="14" />
                </button>
            @endif
        </div>

    @elseif($style === 'rich')
        <div
            {{ $attributes
                ->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon'])
                ->merge(['class' => $richContainerClass().' border-l-4 '.$richBorderClass().' p-5 rounded-r-lg']) }}
            x-data="{ show: true }"
            x-show="show"
            role="alert"
        >
            <div class="flex gap-4">
                @if($icon)
                    <x-jetax-icon :name="$icon" size="lg" :class="$richTextClass()" />
                @endif

                <div class="flex-1">
                    @if($title)
                        <h4 class="text-sm font-bold {{ $richTextClass() }} mb-1">{{ $title }}</h4>
                    @endif

                    <div class="text-sm text-on-surface-variant leading-relaxed">
                        @if($message)
                            {{ $message }}
                        @else
                            {{ $slot }}
                        @endif
                    </div>
                </div>

                @if($dismissible)
                    <button
                        type="button"
                        x-on:click="show = false"
                        class="p-1 hover:bg-black/10 rounded transition-colors self-start"
                        aria-label="Fechar"
                    >
                        <x-jetax-icon name="xmark" size="14" :class="$richTextClass()" />
                    </button>
                @endif
            </div>
        </div>

    @else
        {{-- soft (padrão) --}}
        <div
            {{ $attributes
                ->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon'])
                ->merge(['class' => $softClasses().' px-5 py-3.5 rounded-lg flex items-center gap-3']) }}
            x-data="{ show: true }"
            x-show="show"
            role="alert"
        >
            @if($icon)
                <x-jetax-icon :name="$icon" size="lg" />
            @endif

            <span class="text-sm font-medium flex-1">
                @if($message)
                    {{ $message }}
                @else
                    {{ $slot }}
                @endif
            </span>

            @if($dismissible)
                <button
                    type="button"
                    x-on:click="show = false"
                    class="p-1 hover:bg-current/15 rounded transition-colors"
                    aria-label="Fechar"
                >
                    <x-jetax-icon name="xmark" size="14" />
                </button>
            @endif
        </div>
    @endif
@endif
