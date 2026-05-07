@props([
    'bulkActions' => [],
    'selectedCount' => 0,
])

@php
    $total = (int) $selectedCount;
    $actions = collect($bulkActions ?? [])->values();
@endphp

@if($total > 0 && $actions->isNotEmpty())
    <div
        class="px-6 py-3 border-b border-outline-variant/30 bg-primary/5 flex flex-wrap items-center gap-3"
        role="region"
        aria-label="Ações em lote"
    >
        <span class="text-sm font-medium text-on-surface">
            {{ $total }} {{ $total === 1 ? 'selecionado' : 'selecionados' }}
        </span>

        <div class="flex flex-wrap items-center gap-2">
            @foreach($actions as $action)
                @php
                    $variant = $action->getVariant() ?: 'secondary';
                    $confirm = $action->getConfirm();
                @endphp

                <x-jetax-button
                    size="sm"
                    :color="$variant"
                    style="soft-rounded"
                    :icon="$action->getIcon() ?: ''"
                    wire:click="runBulkAction('{{ $action->getKey() }}')"
                    :wire:confirm="$confirm ?: null"
                >
                    {{ $action->getLabel() }}
                </x-jetax-button>
            @endforeach
        </div>

        <button
            type="button"
            class="ml-auto text-xs text-on-surface-variant hover:text-on-surface transition-colors inline-flex items-center gap-1"
            wire:click="clearSelection"
        >
            <x-jetax-icon name="close" size="sm" />
            Cancelar seleção
        </button>
    </div>
@endif
