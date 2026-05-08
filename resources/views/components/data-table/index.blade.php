@props([
    'columns' => [],
    'rows' => null,
    'bulkActions' => [],
])

@php
    $hasRows = $rows !== null && $rows->total() > 0;
    $hasBulkActions = ! empty($bulkActions);
    $selectedCount = count($this->selectedIds ?? []);
    $columnSpan = count($columns) + ($hasBulkActions ? 1 : 0);
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl overflow-hidden bg-surface-container-lowest']) }}
    style="box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);"
>
    @include('jetax::components.data-table.toolbar')

    @if($hasBulkActions)
        @include('jetax::components.data-table.bulk-bar', [
            'bulkActions' => $bulkActions,
            'selectedCount' => $selectedCount,
        ])
    @endif

    @if(! $hasRows)
        @include('jetax::components.data-table.empty', [
            'title' => $emptyTitle ?? 'Nenhum registro encontrado',
            'description' => $emptyDescription ?? '',
            'icon' => $emptyIcon ?? 'inbox',
        ])
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-primary/5">
                    <tr class="border-b border-outline-variant/30">
                        @if($hasBulkActions)
                            <th class="w-10 px-6 py-3">
                                <x-jetax-checkbox
                                    name="data-table-select-all"
                                    wire:model.live="selectAll"
                                    aria-label="Selecionar todos os registros desta página"
                                />
                            </th>
                        @endif
                        @foreach($columns as $column)
                            <th class="px-6 py-3 text-left text-[11px] font-bold uppercase tracking-widest text-on-surface-variant">
                                @if($column->isSortable())
                                    <button
                                        type="button"
                                        class="flex items-center gap-1 hover:text-on-surface transition-colors"
                                        wire:click="toggleSort('{{ $column->getKey() }}')"
                                        aria-label="Ordenar por {{ $column->getLabel() }}"
                                    >
                                        <span>{{ $column->getLabel() }}</span>
                                        <span class="inline-flex items-center leading-none">
                                            @if($this->sortBy === $column->getKey() && $this->sortDirection === 'asc')
                                                <x-jetax-icon name="keyboard_arrow_up" size="md" class="text-on-surface" />
                                            @elseif($this->sortBy === $column->getKey() && $this->sortDirection === 'desc')
                                                <x-jetax-icon name="keyboard_arrow_down" size="md" class="text-on-surface" />
                                            @else
                                                <x-jetax-icon name="expand_all" size="md" class="text-on-surface-variant/40" />
                                            @endif
                                        </span>
                                    </button>
                                @else
                                    {{ $column->getLabel() }}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr class="group h-11 even:bg-surface-container-low hover:bg-surface-container transition-colors">
                            @if($hasBulkActions)
                                <td class="w-10 px-6 py-2.5">
                                    <x-jetax-checkbox
                                        :name="'data-table-select-'.$row->getKey()"
                                        wire:model.live="selectedIds"
                                        :value="$row->getKey()"
                                        aria-label="Selecionar registro"
                                    />
                                </td>
                            @endif
                            @foreach($columns as $column)
                                <td class="px-6 py-2.5 text-sm text-on-surface">
                                    {{ $column->render($row) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-jetax-pagination :paginator="$rows" />
    @endif
</div>
