<nav {{ $attributes->merge(['aria-label' => 'Breadcrumb']) }}>
    <ol class="flex items-center space-x-1 text-sm font-body">
        {{-- Desktop: exibe todos os itens --}}
        @foreach($intermediaryItems() as $item)
            <li class="hidden md:flex items-center space-x-1">
                <a href="{{ $item['url'] ?? '#' }}" class="text-slate-500 hover:text-on-surface transition-colors">
                    {{ $item['label'] }}
                </a>
                <x-jetax-icon name="chevron-right" size="14" class="text-slate-300" />
            </li>
        @endforeach

        {{-- Mobile: exibe "..." quando há mais de 2 itens, ocultando os intermediários além do penúltimo --}}
        @if($shouldTruncate())
            <li class="flex md:hidden items-center space-x-1">
                <span class="text-slate-400 select-none">…</span>
                <x-jetax-icon name="chevron-right" size="14" class="text-slate-300" />
            </li>

            {{-- Penúltimo item (visível apenas em mobile) --}}
            @php $mobileItems = $mobileItems(); $mobilePenultimate = count($mobileItems) > 1 ? $mobileItems[0] : null; @endphp
            @if($mobilePenultimate)
                <li class="flex md:hidden items-center space-x-1">
                    <a href="{{ $mobilePenultimate['url'] ?? '#' }}" class="text-slate-500 hover:text-on-surface transition-colors">
                        {{ $mobilePenultimate['label'] }}
                    </a>
                    <x-jetax-icon name="chevron-right" size="14" class="text-slate-300" />
                </li>
            @endif
        @endif

        {{-- Último item: item atual, sem link --}}
        @if($currentItem())
            <li>
                <span class="text-primary font-semibold">{{ $currentItem()['label'] }}</span>
            </li>
        @endif
    </ol>
</nav>
