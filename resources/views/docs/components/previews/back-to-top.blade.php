@php
$codeBasico = <<<'BLADE'
<x-jetax-back-to-top />
BLADE;

$codeThreshold = <<<'BLADE'
<x-jetax-back-to-top :threshold="500" />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
            O botão aparece fixo no canto inferior direito da página ao rolar além de 300px.
        </p>
        <x-jetax-back-to-top />
    </x-jetax-docs-preview-section>

    {{-- Threshold customizado --}}
    <x-jetax-docs-preview-section title="Threshold Customizado" :code="$codeThreshold">
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
            Com <code class="text-xs bg-slate-100 dark:bg-white/10 px-1 py-0.5 rounded">:threshold="500"</code>, o botão só aparece após rolar 500px.
        </p>
        <x-jetax-back-to-top :threshold="500" />
    </x-jetax-docs-preview-section>

</div>
