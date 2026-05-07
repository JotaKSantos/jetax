@php
$codeBasic = <<<'BLADE'
{{-- Incluir no layout principal --}}
<x-jetax-toast-container />
BLADE;

$codePositions = <<<'BLADE'
<x-jetax-toast-container position="top-right" />
<x-jetax-toast-container position="top-left" />
<x-jetax-toast-container position="bottom-right" />
<x-jetax-toast-container position="bottom-left" />
BLADE;

$codeDispatch = <<<'BLADE'
{{-- Via Livewire (no componente PHP) --}}
$this->dispatch('toast', message: 'Salvo com sucesso!', variant: 'success');
$this->dispatch('toast', message: 'Erro ao processar.', variant: 'error');
$this->dispatch('toast', message: 'Atencao!', variant: 'warning');
$this->dispatch('toast', message: 'Informacao.', variant: 'info');
BLADE;

$codeAlpine = <<<'BLADE'
{{-- Via Alpine.js --}}
<button
    x-data
    &#64;click="$dispatch('toast', { message: 'Toast via Alpine!', variant: 'success' })"
    class="px-4 py-2 bg-emerald-600 text-white rounded-lg"
>
    Disparar Toast
</button>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Uso Basico --}}
    <x-jetax-docs-preview-section title="Uso Basico" :code="$codeBasic">
        <x-jetax-toast-container />
        <p class="text-sm text-slate-500">O container de toasts deve ser incluido uma vez no layout. Os toasts aparecem ao disparar eventos.</p>
    </x-jetax-docs-preview-section>

    {{-- Posicoes --}}
    <x-jetax-docs-preview-section title="Posicoes" :code="$codePositions">
        <div class="text-sm text-slate-600 space-y-2">
            <p><code class="bg-slate-100 px-1.5 py-0.5 rounded">top-right</code> — Canto superior direito (padrao)</p>
            <p><code class="bg-slate-100 px-1.5 py-0.5 rounded">top-left</code> — Canto superior esquerdo</p>
            <p><code class="bg-slate-100 px-1.5 py-0.5 rounded">bottom-right</code> — Canto inferior direito</p>
            <p><code class="bg-slate-100 px-1.5 py-0.5 rounded">bottom-left</code> — Canto inferior esquerdo</p>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Disparando via Livewire --}}
    <x-jetax-docs-preview-section title="Disparar via Livewire" :code="$codeDispatch">
        <div class="text-sm text-slate-600 space-y-2">
            <p>Use <code class="bg-slate-100 px-1.5 py-0.5 rounded">$this->dispatch('toast', ...)</code> no componente Livewire.</p>
            <p>Variantes disponiveis: <code class="bg-slate-100 px-1.5 py-0.5 rounded">success</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">error</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">warning</code>, <code class="bg-slate-100 px-1.5 py-0.5 rounded">info</code>.</p>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Disparando via Alpine.js --}}
    <x-jetax-docs-preview-section title="Disparar via Alpine.js" :code="$codeAlpine">
        <div class="flex flex-wrap gap-3">
            <button
                x-data
                @click="$dispatch('toast', { message: 'Sucesso!', variant: 'success' })"
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm hover:bg-emerald-700 transition-colors"
            >
                Toast Success
            </button>
            <button
                x-data
                @click="$dispatch('toast', { message: 'Erro ao processar.', variant: 'error' })"
                class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-colors"
            >
                Toast Error
            </button>
            <button
                x-data
                @click="$dispatch('toast', { message: 'Atencao!', variant: 'warning' })"
                class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm hover:bg-amber-600 transition-colors"
            >
                Toast Warning
            </button>
            <button
                x-data
                @click="$dispatch('toast', { message: 'Informacao.', variant: 'info' })"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors"
            >
                Toast Info
            </button>
        </div>
    </x-jetax-docs-preview-section>

</div>
