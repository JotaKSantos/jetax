@php
$codeBasic = <<<'BLADE'
<x-jetax-textarea name="descricao" label="Descricao" placeholder="Digite sua descricao..." />
BLADE;

$codeAutoResize = <<<'BLADE'
<x-jetax-textarea name="bio" label="Biografia" :auto-resize="true" placeholder="Digite e o campo expande automaticamente..." />
BLADE;

$codeError = <<<'BLADE'
<x-jetax-textarea name="obs" label="Observacoes" state="error" message="Campo obrigatorio" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-textarea name="nota" label="Desabilitado" placeholder="Nao editavel" disabled />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-textarea name="descricao" label="Descricao" placeholder="Digite sua descricao..." />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Auto Resize --}}
    <x-jetax-docs-preview-section title="Auto Resize" :code="$codeAutoResize">
        <div class="w-full max-w-sm">
            <x-jetax-textarea name="bio" label="Biografia" :auto-resize="true" placeholder="Digite e o campo expande automaticamente..." />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Erro --}}
    <x-jetax-docs-preview-section title="Com Erro" :code="$codeError">
        <div class="w-full max-w-sm">
            <x-jetax-textarea name="obs" label="Observacoes" state="error" message="Campo obrigatorio" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado --}}
    <x-jetax-docs-preview-section title="Desabilitado" :code="$codeDisabled">
        <div class="w-full max-w-sm">
            <x-jetax-textarea name="nota" label="Desabilitado" placeholder="Nao editavel" disabled />
        </div>
    </x-jetax-docs-preview-section>

</div>
