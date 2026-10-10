@php
$codeBasico = <<<'BLADE'
<x-jetax-stats-card
    label="Total de Usuarios"
    value="1.284"
    trend-value="+8%"
    trend="up"
    icon="users"
/>
BLADE;

$codeTrends = <<<'BLADE'
<x-jetax-stats-card label="Receita" value="R$ 45.200" trend-value="+12%" trend="up" icon="money-bills" />
<x-jetax-stats-card label="Cancelamentos" value="23" trend-value="-5%" trend="down" icon="circle-xmark" />
<x-jetax-stats-card label="Ticket Medio" value="R$ 89,50" trend-value="0%" trend="neutral" icon="ticket" />
BLADE;

$codeHighlighted = <<<'BLADE'
<x-jetax-stats-card
    label="Meta Atingida"
    value="142%"
    trend-value="+42%"
    trend="up"
    icon="trophy"
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
                icon="users"
            />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Trends --}}
    <x-jetax-docs-preview-section title="Trends (Up, Down, Neutral)" :code="$codeTrends">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-jetax-stats-card label="Receita" value="R$ 45.200" trend-value="+12%" trend="up" icon="money-bills" />
            <x-jetax-stats-card label="Cancelamentos" value="23" trend-value="-5%" trend="down" icon="circle-xmark" />
            <x-jetax-stats-card label="Ticket Medio" value="R$ 89,50" trend-value="0%" trend="neutral" icon="ticket" />
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
                icon="trophy"
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
