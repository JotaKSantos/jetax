@props([
    'columns' => [],
    'rows' => [],
    'selectable' => false,
    'paginator' => null,
])

@php
    $hasBody = isset($body) && (is_object($body) ? $body->isNotEmpty() : trim((string) $body) !== '');
    $hasSortable = collect($columns)->contains(fn ($col) => !empty($col['sortable']));

    // Com paginator, quem ordena é o servidor: o cabeçalho só emite `sort`.
    $serverSort = $paginator !== null;
    $clientSort = !$hasBody && $hasSortable && !$serverSort;
    $sortButtons = $hasSortable && (!$hasBody || $serverSort);

    // Slot `cell-<key>` por coluna; o conteúdo enxerga a linha como `row` (Alpine).
    $slots = $__laravel_slots ?? [];
    $cellSlots = [];
    foreach ($columns as $column) {
        foreach ($cellSlotNames($column) as $slotName) {
            if (isset($slots[$slotName]) && trim((string) $slots[$slotName]) !== '') {
                $cellSlots[$column['key']] = $slots[$slotName];
                break;
            }
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl overflow-hidden bg-surface-container-lowest']) }}
    style="box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);"
    @if($clientSort)
        x-data="{
            rows: {{ Js::from($rows) }},
            sortColumn: '',
            sortDirection: 'asc',
            sort(column) {
                if (this.sortColumn === column) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = column;
                    this.sortDirection = 'asc';
                }
                this.rows = [...this.rows].sort((a, b) => {
                    let valA = String(a[column] ?? '').toLowerCase();
                    let valB = String(b[column] ?? '').toLowerCase();
                    if (valA < valB) return this.sortDirection === 'asc' ? -1 : 1;
                    if (valA > valB) return this.sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });
                $dispatch('sort', { key: column, direction: this.sortDirection });
            }
        }"
    @elseif($serverSort && $hasSortable)
        x-data="{
            sortColumn: '',
            sortDirection: 'asc',
            sortBy(key) {
                if (this.sortColumn === key) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = key;
                    this.sortDirection = 'asc';
                }
                $dispatch('sort', { key: key, direction: this.sortDirection });
            }
        }"
    @endif
>
    @if(empty($rows) && !$hasBody)
        <x-jetax-empty-state title="Nenhum registro encontrado" icon="inbox" />
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-outline-variant/30">
                        @if($selectable)
                            <th class="px-6 py-3 w-10">
                                <input
                                    type="checkbox"
                                    class="rounded border-outline-variant text-primary focus:ring-primary"
                                    x-data
                                    @change="$dispatch('select-all', { checked: $event.target.checked })"
                                    aria-label="Selecionar todos"
                                />
                            </th>
                        @endif

                        @foreach($columns as $column)
                            <th {{ $headerAttributes($column) }}>
                                @if(!empty($column['sortable']) && $sortButtons)
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1 hover:text-on-surface transition-colors"
                                        @click="{{ $serverSort ? 'sortBy' : 'sort' }}('{{ $column['key'] }}')"
                                        aria-label="Ordenar por {{ $column['label'] }}"
                                    >
                                        <span>{{ $column['label'] }}</span>
                                        <span class="inline-flex items-center leading-none">
                                            <x-jetax-icon
                                                name="arrows-up-down"
                                                size="sm"
                                                class="text-on-surface-variant/40"
                                                x-show="sortColumn !== '{{ $column['key'] }}'"
                                            />
                                            <x-jetax-icon
                                                name="angle-up"
                                                size="sm"
                                                class="text-on-surface"
                                                x-show="sortColumn === '{{ $column['key'] }}' && sortDirection === 'asc'"
                                                x-cloak
                                            />
                                            <x-jetax-icon
                                                name="angle-down"
                                                size="sm"
                                                class="text-on-surface"
                                                x-show="sortColumn === '{{ $column['key'] }}' && sortDirection === 'desc'"
                                                x-cloak
                                            />
                                        </span>
                                    </button>
                                @else
                                    {{ $column['label'] }}
                                @endif
                            </th>
                        @endforeach

                        @isset($actions)
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-on-surface-variant">
                                Ações
                            </th>
                        @endisset
                    </tr>
                </thead>
                <tbody>
                    @if($hasBody)
                        {{-- Modo customizado: o usuario controla o conteudo das linhas --}}
                        {{ $body }}
                    @elseif($clientSort)
                        {{-- Modo automatico com ordenacao Alpine --}}
                        <template x-for="(row, index) in rows" :key="index">
                            <tr class="group h-11 even:bg-surface-container-low hover:bg-surface-container transition-colors">
                                @if($selectable)
                                    <td class="px-6 py-2.5">
                                        <input
                                            type="checkbox"
                                            class="rounded border-outline-variant text-primary focus:ring-primary"
                                            x-data
                                            @change="$dispatch('row-selected', { row: row, checked: $event.target.checked })"
                                            aria-label="Selecionar linha"
                                        />
                                    </td>
                                @endif

                                @foreach($columns as $column)
                                    @if(isset($cellSlots[$column['key']]))
                                        <td class="{{ $cellClass($column) }}">{{ $cellSlots[$column['key']] }}</td>
                                    @else
                                        <td class="{{ $cellClass($column) }}" x-text="row['{{ $column['key'] }}'] ?? ''"></td>
                                    @endif
                                @endforeach

                                @isset($actions)
                                    <td class="px-6 py-2.5 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                            {{ $actions }}
                                        </div>
                                    </td>
                                @endisset
                            </tr>
                        </template>
                    @else
                        {{-- Modo automatico no servidor (sem ordenacao local) --}}
                        @foreach($rows as $row)
                            <tr class="group h-11 even:bg-surface-container-low hover:bg-surface-container transition-colors"
                                @if($cellSlots !== []) x-data="{ row: {{ Js::from($row) }} }" @endif
                            >
                                @if($selectable)
                                    <td class="px-6 py-2.5">
                                        <input
                                            type="checkbox"
                                            class="rounded border-outline-variant text-primary focus:ring-primary"
                                            x-data
                                            @change="$dispatch('row-selected', { row: {{ json_encode($row) }}, checked: $event.target.checked })"
                                            aria-label="Selecionar linha"
                                        />
                                    </td>
                                @endif

                                @foreach($columns as $column)
                                    <td class="{{ $cellClass($column) }}">
                                        @if(isset($cellSlots[$column['key']]))
                                            {{ $cellSlots[$column['key']] }}
                                        @else
                                            {{ $row[$column['key']] ?? '' }}
                                        @endif
                                    </td>
                                @endforeach

                                @isset($actions)
                                    <td class="px-6 py-2.5 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                            {{ $actions }}
                                        </div>
                                    </td>
                                @endisset
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if($paginator !== null)
            <x-jetax-pagination :paginator="$paginator" />
        @endif
    @endif
</div>
