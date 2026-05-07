@php
$items = [
    ['label' => 'Nome', 'value' => 'João Silva'],
    ['label' => 'E-mail', 'value' => 'joao@email.com'],
    ['label' => 'Telefone', 'value' => '(11) 99999-0000'],
    ['label' => 'Plano', 'value' => 'Pro'],
    ['label' => 'Status', 'value' => 'Ativo'],
    ['label' => 'Desde', 'value' => '10/01/2024'],
];

$code1col = <<<'BLADE'
<x-jetax-detail-summary
    :columns="1"
    :items="[
        ['label' => 'Nome', 'value' => 'Joao Silva'],
        ['label' => 'E-mail', 'value' => 'joao@email.com'],
        ['label' => 'Plano', 'value' => 'Pro'],
    ]"
/>
BLADE;

$code2col = <<<'BLADE'
<x-jetax-detail-summary
    :columns="2"
    :items="[
        ['label' => 'Nome', 'value' => 'Joao Silva'],
        ['label' => 'E-mail', 'value' => 'joao@email.com'],
        ['label' => 'Telefone', 'value' => '(11) 99999-0000'],
        ['label' => 'Plano', 'value' => 'Pro'],
        ['label' => 'Status', 'value' => 'Ativo'],
        ['label' => 'Desde', 'value' => '10/01/2024'],
    ]"
/>
BLADE;

$code3col = <<<'BLADE'
<x-jetax-detail-summary
    :columns="3"
    :items="[
        ['label' => 'Nome', 'value' => 'Joao Silva'],
        ['label' => 'E-mail', 'value' => 'joao@email.com'],
        ['label' => 'Telefone', 'value' => '(11) 99999-0000'],
        ['label' => 'Plano', 'value' => 'Pro'],
        ['label' => 'Status', 'value' => 'Ativo'],
        ['label' => 'Desde', 'value' => '10/01/2024'],
    ]"
/>
BLADE;
@endphp

<div class="space-y-6">

    {{-- 1 Coluna --}}
    <x-jetax-docs-preview-section title="1 Coluna" :code="$code1col">
        <x-jetax-detail-summary
            :columns="1"
            :items="array_slice($items, 0, 3)"
        />
    </x-jetax-docs-preview-section>

    {{-- 2 Colunas --}}
    <x-jetax-docs-preview-section title="2 Colunas" :code="$code2col">
        <x-jetax-detail-summary
            :columns="2"
            :items="$items"
        />
    </x-jetax-docs-preview-section>

    {{-- 3 Colunas --}}
    <x-jetax-docs-preview-section title="3 Colunas" :code="$code3col">
        <x-jetax-detail-summary
            :columns="3"
            :items="$items"
        />
    </x-jetax-docs-preview-section>

</div>
