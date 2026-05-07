@php
    $firstTabName = $firstTabName();
    $navClasses = $navClasses();
    $navInnerClasses = $navInnerClasses();
    $activeTabClasses = $activeTabClasses();
    $inactiveTabClasses = $inactiveTabClasses();

    $alpineData = "{ activeTab: '{$firstTabName}'" . ($wireModel ? ", wireModel: '{$wireModel}'" : '') . " }";
@endphp

<div
    x-data="{!! $alpineData !!}"
    @if($wireModel) wire:model="{{ $wireModel }}" @endif
    {{ $attributes }}
>
    {{-- Navegação das abas --}}
    <div class="{{ $navClasses }}">
        @if($variant === 'pill')
            {{-- Pill variant: botões diretamente no container --}}
            @foreach($tabs as $tab)
                <button
                    type="button"
                    x-on:click="activeTab = '{{ $tab['name'] }}'"
                    x-bind:class="activeTab === '{{ $tab['name'] }}' ? '{{ $activeTabClasses }}' : '{{ $inactiveTabClasses }}'"
                >
                    {{ $tab['label'] }}
                    @if(!empty($tab['count']))
                        <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-primary/10 text-primary">
                            {{ $tab['count'] }}
                        </span>
                    @endif
                </button>
            @endforeach
        @else
            {{-- Underline variant: wrapper interno com flex --}}
            <nav class="{{ $navInnerClasses }}">
                @foreach($tabs as $tab)
                    <button
                        type="button"
                        x-on:click="activeTab = '{{ $tab['name'] }}'"
                        x-bind:class="activeTab === '{{ $tab['name'] }}' ? '{{ $activeTabClasses }}' : '{{ $inactiveTabClasses }}'"
                    >
                        {{ $tab['label'] }}
                        @if(!empty($tab['count']))
                            <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-primary/10 text-primary">
                                {{ $tab['count'] }}
                            </span>
                        @endif
                    </button>
                @endforeach
            </nav>
        @endif
    </div>

    {{-- Conteúdo das abas via slots nomeados --}}
    @foreach($tabs as $tab)
        @php $slotName = str_replace('-', '_', $tab['name']); @endphp
        @if(isset($$slotName) && !empty($$slotName->toHtml()))
            <div
                x-show="activeTab === '{{ $tab['name'] }}'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                {{ $$slotName }}
            </div>
        @endif
    @endforeach
</div>
