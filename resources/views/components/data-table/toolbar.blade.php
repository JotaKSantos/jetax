<div class="px-6 py-4 border-b border-outline-variant/30 flex flex-wrap items-end gap-3">
    <div class="flex-1 min-w-[220px] max-w-md">
        <x-jetax-input
            name="search"
            icon="search"
            placeholder="Buscar..."
            wire:model.live.debounce.300ms="search"
        />
    </div>

    @foreach(($filters ?? []) as $filter)
        @php
            $filterKey = $filter->getKey();
            $filterPlaceholder = $filter->getPlaceholder() ?: 'Todos';
        @endphp

        @switch($filter->getType())
            @case('select')
                <div class="min-w-[180px]">
                    <x-jetax-select
                        :name="'filter_'.$filterKey"
                        :label="$filter->getLabel()"
                        :placeholder="$filterPlaceholder"
                        :options="$filter->getOptions()"
                        wire:model.live="filterValues.{{ $filterKey }}"
                    />
                </div>
                @break

            @case('multiselect')
                <div class="min-w-[180px]">
                    <x-jetax-select
                        :name="'filter_'.$filterKey.'[]'"
                        :label="$filter->getLabel()"
                        :options="$filter->getOptions()"
                        multiple
                        wire:model.live="filterValues.{{ $filterKey }}"
                    />
                </div>
                @break

            @case('date')
                <div class="flex items-end gap-2">
                    <div class="min-w-[140px]">
                        <x-jetax-input
                            :name="'filter_'.$filterKey.'_from'"
                            type="date"
                            :label="$filter->getLabel().' (de)'"
                            wire:model.live="filterValues.{{ $filterKey }}.from"
                        />
                    </div>
                    <div class="min-w-[140px]">
                        <x-jetax-input
                            :name="'filter_'.$filterKey.'_to'"
                            type="date"
                            :label="$filter->getLabel().' (até)'"
                            wire:model.live="filterValues.{{ $filterKey }}.to"
                        />
                    </div>
                </div>
                @break
        @endswitch
    @endforeach
</div>
