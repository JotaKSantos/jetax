@php
$codeBasic = <<<'BLADE'
<x-jetax-form-group label="E-mail" name="email">
    <x-jetax-input placeholder="seu@email.com" type="email" />
</x-jetax-form-group>
BLADE;

$codeRequired = <<<'BLADE'
<x-jetax-form-group label="Nome completo" name="nome" required>
    <x-jetax-input placeholder="Digite seu nome" />
</x-jetax-form-group>
BLADE;

$codeHint = <<<'BLADE'
<x-jetax-form-group label="Senha" name="senha" hint="Minimo de 8 caracteres">
    <x-jetax-input type="password" placeholder="********" />
</x-jetax-form-group>
BLADE;

$codeError = <<<'BLADE'
<x-jetax-form-group label="CPF" name="cpf" error="CPF invalido">
    <x-jetax-input placeholder="000.000.000-00" />
</x-jetax-form-group>
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-form-group label="E-mail" name="email">
                <x-jetax-input placeholder="seu@email.com" type="email" />
            </x-jetax-form-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Obrigatorio --}}
    <x-jetax-docs-preview-section title="Obrigatorio" :code="$codeRequired">
        <div class="w-full max-w-sm">
            <x-jetax-form-group label="Nome completo" name="nome" required>
                <x-jetax-input placeholder="Digite seu nome" />
            </x-jetax-form-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Dica --}}
    <x-jetax-docs-preview-section title="Com Dica" :code="$codeHint">
        <div class="w-full max-w-sm">
            <x-jetax-form-group label="Senha" name="senha" hint="Minimo de 8 caracteres">
                <x-jetax-input type="password" placeholder="********" />
            </x-jetax-form-group>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Erro --}}
    <x-jetax-docs-preview-section title="Com Erro" :code="$codeError">
        <div class="w-full max-w-sm">
            <x-jetax-form-group label="CPF" name="cpf" error="CPF invalido">
                <x-jetax-input placeholder="000.000.000-00" />
            </x-jetax-form-group>
        </div>
    </x-jetax-docs-preview-section>

</div>
