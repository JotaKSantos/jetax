@php
$codeBasic = <<<'BLADE'
<x-jetax-input name="email" label="E-mail" placeholder="seu@email.com" type="email" />
BLADE;

$codeTypes = <<<'BLADE'
<x-jetax-input name="nome" label="Texto" placeholder="Digite seu nome" />
<x-jetax-input name="senha" label="Senha" type="password" placeholder="********" />
<x-jetax-input name="idade" label="Numero" type="number" placeholder="25" />
BLADE;

$codeIcon = <<<'BLADE'
<x-jetax-input name="busca" label="Busca" icon="search" placeholder="Pesquisar..." />
<x-jetax-input name="email_icon" label="E-mail" icon="mail" placeholder="seu@email.com" />
BLADE;

$codeError = <<<'BLADE'
<x-jetax-input name="campo" label="Campo com erro" state="error" message="Este campo e obrigatorio" />
<x-jetax-input name="campo_warn" label="Campo com aviso" state="warning" message="Verifique o valor informado" />
<x-jetax-input name="campo_ok" label="Campo valido" state="success" message="Valor aceito" />
BLADE;

$codeMask = <<<'BLADE'
<x-jetax-input name="cpf" label="CPF" mask="cpf" placeholder="000.000.000-00" />
<x-jetax-input name="phone" label="Telefone" mask="phone" placeholder="(00) 00000-0000" />
<x-jetax-input name="cep" label="CEP" mask="cep" placeholder="00000-000" />
BLADE;

$codeDisabled = <<<'BLADE'
<x-jetax-input name="disabled" label="Desabilitado" placeholder="Nao editavel" disabled />
<x-jetax-input name="readonly" label="Somente leitura" value="Valor fixo" readonly />
BLADE;
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasic">
        <div class="w-full max-w-sm">
            <x-jetax-input name="email" label="E-mail" placeholder="seu@email.com" type="email" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tipos --}}
    <x-jetax-docs-preview-section title="Tipos" :code="$codeTypes">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-input name="nome" label="Texto" placeholder="Digite seu nome" />
            <x-jetax-input name="senha" label="Senha" type="password" placeholder="********" />
            <x-jetax-input name="idade" label="Numero" type="number" placeholder="25" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Icone --}}
    <x-jetax-docs-preview-section title="Com Icone" :code="$codeIcon">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-input name="busca" label="Busca" icon="search" placeholder="Pesquisar..." />
            <x-jetax-input name="email_icon" label="E-mail" icon="mail" placeholder="seu@email.com" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Estados --}}
    <x-jetax-docs-preview-section title="Estados" :code="$codeError">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-input name="campo" label="Campo com erro" state="error" message="Este campo e obrigatorio" />
            <x-jetax-input name="campo_warn" label="Campo com aviso" state="warning" message="Verifique o valor informado" />
            <x-jetax-input name="campo_ok" label="Campo valido" state="success" message="Valor aceito" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Com Mascara --}}
    <x-jetax-docs-preview-section title="Com Mascara" :code="$codeMask">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-input name="cpf" label="CPF" mask="cpf" placeholder="000.000.000-00" />
            <x-jetax-input name="phone" label="Telefone" mask="phone" placeholder="(00) 00000-0000" />
            <x-jetax-input name="cep" label="CEP" mask="cep" placeholder="00000-000" />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Desabilitado e Somente Leitura --}}
    <x-jetax-docs-preview-section title="Desabilitado e Somente Leitura" :code="$codeDisabled">
        <div class="w-full max-w-sm space-y-4">
            <x-jetax-input name="disabled" label="Desabilitado" placeholder="Nao editavel" disabled />
            <x-jetax-input name="readonly" label="Somente leitura" value="Valor fixo" readonly />
        </div>
    </x-jetax-docs-preview-section>

</div>
