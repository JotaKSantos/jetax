@php
$codeBasico = <<<'BLADE'
<x-jetax-stats-card
    label="Total de Usuarios"
    value="1.284"
    trend-value="+8%"
    trend="up"
    icon="group"
/>
BLADE;

$codeTrends = <<<'BLADE'
<x-jetax-stats-card label="Receita" value="R$ 45.200" trend-value="+12%" trend="up" icon="payments" />
<x-jetax-stats-card label="Cancelamentos" value="23" trend-value="-5%" trend="down" icon="cancel" />
<x-jetax-stats-card label="Ticket Medio" value="R$ 89,50" trend-value="0%" trend="neutral" icon="confirmation_number" />
BLADE;

$codeHighlighted = <<<'BLADE'
<x-jetax-stats-card
    label="Meta Atingida"
    value="142%"
    trend-value="+42%"
    trend="up"
    icon="emoji_events"
    :highlighted="true"
/>
BLADE;

$codeSemIcone = <<<'BLADE'
<x-jetax-stats-card
    label="Pedidos Hoje"
    value="38"
    trend-value="+3"
    trend="up"
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <div class="max-w-xs">
            <x-jetax-stats-card
                label="Total de Usuarios"
                value="1.284"
                trend-value="+8%"
                trend="up"
                icon="group"
            />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Trends --}}
    <x-jetax-docs-preview-section title="Trends (Up, Down, Neutral)" :code="$codeTrends">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-jetax-stats-card label="Receita" value="R$ 45.200" trend-value="+12%" trend="up" icon="payments" />
            <x-jetax-stats-card label="Cancelamentos" value="23" trend-value="-5%" trend="down" icon="cancel" />
            <x-jetax-stats-card label="Ticket Medio" value="R$ 89,50" trend-value="0%" trend="neutral" icon="confirmation_number" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Highlighted --}}
    <x-jetax-docs-preview-section title="Highlighted" :code="$codeHighlighted">
        <div class="max-w-xs">
            <x-jetax-stats-card
                label="Meta Atingida"
                value="142%"
                trend-value="+42%"
                trend="up"
                icon="emoji_events"
                :highlighted="true"
            />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Sem Icone --}}
    <x-jetax-docs-preview-section title="Sem Icone" :code="$codeSemIcone">
        <div class="max-w-xs">
            <x-jetax-stats-card
                label="Pedidos Hoje"
                value="38"
                trend-value="+3"
                trend="up"
            />
        </div>
    </x-jetax-docs-preview-section>

</div>
