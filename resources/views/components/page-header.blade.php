<div {{ $attributes->merge(['class' => $hasIcon() ? 'pb-5' : 'pb-9']) }}>
    @if(!empty($breadcrumbs))
        <x-jetax-breadcrumbs :items="$breadcrumbs" class="mb-2" />
    @endif

    <div class="flex items-end justify-between">
        @if($subtitleBesideIcon)
            {{-- Subtítulo ao lado do ícone: o quadrado e a coluna de texto são irmãos; na
                 coluna, o título com `titleAfter` em cima e o subtítulo embaixo. --}}
            <div class="flex items-center gap-3.5">
                <span class="{{ $iconSquareClasses() }}">
                    <span class="material-symbols-outlined text-[26px]">{{ $icon }}</span>
                </span>

                <div>
                    <div class="flex items-center gap-2.5">
                        <{{ $heading }} class="{{ $titleClasses() }}">{{ $title }}</{{ $heading }}>

                        @if(isset($titleAfter))
                            {{ $titleAfter }}
                        @endif
                    </div>

                    @if($subtitle)
                        <p class="text-sm text-on-surface-variant mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
        @else
            <div>
                <div class="flex items-center gap-3.5">
                    @if($hasIcon())
                        <span class="{{ $iconSquareClasses() }}">
                            <span class="material-symbols-outlined text-[26px]">{{ $icon }}</span>
                        </span>
                    @endif

                    <{{ $heading }} class="{{ $titleClasses() }}">{{ $title }}</{{ $heading }}>

                    @if(isset($titleAfter))
                        {{ $titleAfter }}
                    @endif
                </div>

                @if($subtitle)
                    <p class="text-sm text-on-surface-variant mt-1">{{ $subtitle }}</p>
                @endif
            </div>
        @endif

        @if(isset($actions))
            <div class="flex items-center gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
