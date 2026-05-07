@if($message !== null || $slot->isNotEmpty())
    @if($style === 'solid')
        <div
            {{ $attributes->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon']) }}
            x-data="{ show: true }"
            x-show="show"
            class="{{ $solidClasses() }} px-5 py-3.5 rounded-lg flex items-center gap-3"
            role="alert"
        >
            @if($icon)
                <span class="material-symbols-outlined">{{ $icon }}</span>
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
                    class="p-1 hover:bg-white/20 rounded transition-colors"
                    aria-label="Fechar"
                >
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            @endif
        </div>

    @elseif($style === 'rich')
        <div
            {{ $attributes->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon']) }}
            x-data="{ show: true }"
            x-show="show"
            class="{{ $richContainerClass() }} border-l-4 {{ $richBorderClass() }} p-5 rounded-r-lg"
            role="alert"
        >
            <div class="flex gap-4">
                @if($icon)
                    <span class="material-symbols-outlined {{ $richTextClass() }}">{{ $icon }}</span>
                @endif

                <div class="flex-1">
                    @if($title)
                        <h4 class="text-sm font-bold {{ $richTextClass() }} mb-1">{{ $title }}</h4>
                    @endif

                    <div class="text-sm text-slate-600 leading-relaxed">
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
                        <span class="material-symbols-outlined text-sm {{ $richTextClass() }}">close</span>
                    </button>
                @endif
            </div>
        </div>

    @else
        {{-- soft (padrão) --}}
        <div
            {{ $attributes->except(['message', 'variant', 'style', 'dismissible', 'title', 'icon']) }}
            x-data="{ show: true }"
            x-show="show"
            class="{{ $softClasses() }} px-5 py-3.5 rounded-lg flex items-center gap-3"
            role="alert"
        >
            @if($icon)
                <span class="material-symbols-outlined">{{ $icon }}</span>
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
                    class="p-1 hover:bg-white/20 rounded transition-colors"
                    aria-label="Fechar"
                >
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            @endif
        </div>
    @endif
@endif
