@php
$variants = ['primary', 'info', 'success', 'warning', 'danger'];

$codeSoft = implode("\n", array_map(fn($v) => '<x-jetax-alert variant="' . $v . '" message="Alerta ' . ucfirst($v) . '" />', $variants));

$codeSolid = implode("\n", array_map(fn($v) => '<x-jetax-alert variant="' . $v . '" style="solid" message="Alerta ' . ucfirst($v) . '" />', $variants));

$codeRich = implode("\n", array_map(fn($v) => '<x-jetax-alert variant="' . $v . '" style="rich" title="' . ucfirst($v) . '" icon="info" message="Mensagem detalhada do alerta." />', $variants));

$codeIcons = <<<'BLADE'
<x-jetax-alert variant="info" icon="info" message="Informacao importante." />
<x-jetax-alert variant="success" icon="check_circle" message="Operacao realizada!" />
<x-jetax-alert variant="warning" icon="warning" message="Atencao aos dados." />
<x-jetax-alert variant="danger" icon="error" message="Erro ao processar." />
BLADE;

$codeDismissible = <<<'BLADE'
<x-jetax-alert variant="success" message="Voce pode fechar este alerta." dismissible />
<x-jetax-alert variant="warning" style="solid" message="Alerta solid dispensavel." dismissible />
<x-jetax-alert variant="info" style="rich" title="Dispensavel" icon="info" message="Alerta rich dispensavel." dismissible />
BLADE;

$codeSlot = <<<'BLADE'
<x-jetax-alert variant="info">
    Conteudo customizado com <strong>HTML</strong> via slot.
</x-jetax-alert>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Estilo Soft --}}
    <x-jetax-docs-preview-section title="Estilo Soft" :code="$codeSoft">
        <div class="space-y-3">
            @foreach($variants as $variant)
                <x-jetax-alert :variant="$variant" :message="'Alerta ' . ucfirst($variant)" />
            @endforeach
        </div>
    </x-jetax-docs-preview-section>

    {{-- Estilo Solid --}}
    <x-jetax-docs-preview-section title="Estilo Solid" :code="$codeSolid">
        <div class="space-y-3">
            @foreach($variants as $variant)
                <x-jetax-alert :variant="$variant" style="solid" :message="'Alerta ' . ucfirst($variant)" />
            @endforeach
        </div>
    </x-jetax-docs-preview-section>

    {{-- Estilo Rich --}}
    <x-jetax-docs-preview-section title="Estilo Rich" :code="$codeRich">
        <div class="space-y-3">
            @foreach($variants as $variant)
                <x-jetax-alert :variant="$variant" style="rich" :title="ucfirst($variant)" icon="info" message="Mensagem detalhada do alerta." />
            @endforeach
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Icones --}}
    <x-jetax-docs-preview-section title="Com Icones" :code="$codeIcons">
        <div class="space-y-3">
            <x-jetax-alert variant="info" icon="info" message="Informacao importante." />
            <x-jetax-alert variant="success" icon="check_circle" message="Operacao realizada!" />
            <x-jetax-alert variant="warning" icon="warning" message="Atencao aos dados." />
            <x-jetax-alert variant="danger" icon="error" message="Erro ao processar." />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Dispensavel --}}
    <x-jetax-docs-preview-section title="Dispensavel" :code="$codeDismissible">
        <div class="space-y-3">
            <x-jetax-alert variant="success" message="Voce pode fechar este alerta." dismissible />
            <x-jetax-alert variant="warning" style="solid" message="Alerta solid dispensavel." dismissible />
            <x-jetax-alert variant="info" style="rich" title="Dispensavel" icon="info" message="Alerta rich dispensavel." dismissible />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Conteudo via Slot --}}
    <x-jetax-docs-preview-section title="Conteudo via Slot" :code="$codeSlot">
        <x-jetax-alert variant="info">
            Conteudo customizado com <strong>HTML</strong> via slot.
        </x-jetax-alert>
    </x-jetax-docs-preview-section>

</div>
