@props([
    'columns' => [],
    'rows' => [],
    'selectable' => false,
    'paginator' => null,
])

@php
    $hasBody = isset($body) && (is_object($body) ? $body->isNotEmpty() : trim((string) $body) !== '');
    $hasSortable = collect($columns)->contains(fn ($col) => !empty($col['sortable']));
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl overflow-hidden bg-surface-container-lowest']) }}
    style="box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);"
    @if(!$hasBody && $hasSortable)
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
                $dispatch('sort', { column: column, direction: this.sortDirection });
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
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-on-surface-variant">
                                @if(!empty($column['sortable']) && !$hasBody)
                                    <button
                                        type="button"
                                        class="flex items-center gap-1 hover:text-on-surface transition-colors"
                                        @click="sort('{{ $column['key'] }}')"
                                        aria-label="Ordenar por {{ $column['label'] }}"
                                    >
                                        <span>{{ $column['label'] }}</span>
                                        <span class="inline-flex items-center leading-none">
                                            <span
                                                class="material-symbols-outlined text-base text-on-surface-variant/40"
                                                x-show="sortColumn !== '{{ $column['key'] }}'"
                                            >expand_all</span>
                                            <span
                                                class="material-symbols-outlined text-base text-on-surface"
                                                x-show="sortColumn === '{{ $column['key'] }}' && sortDirection === 'asc'"
                                                x-cloak
                                            >keyboard_arrow_up</span>
                                            <span
                                                class="material-symbols-outlined text-base text-on-surface"
                                                x-show="sortColumn === '{{ $column['key'] }}' && sortDirection === 'desc'"
                                                x-cloak
                                            >keyboard_arrow_down</span>
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
                    @elseif($hasSortable)
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
                                    <td class="px-6 py-2.5 text-sm text-on-surface" x-text="row['{{ $column['key'] }}'] ?? ''"></td>
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
                        {{-- Modo automatico simples (sem ordenacao) --}}
                        @foreach($rows as $row)
                            <tr class="group h-11 even:bg-surface-container-low hover:bg-surface-container transition-colors">
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
                                    <td class="px-6 py-2.5 text-sm text-on-surface">
                                        {{ $row[$column['key']] ?? '' }}
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
