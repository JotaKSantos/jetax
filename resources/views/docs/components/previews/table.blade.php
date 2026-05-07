@php
$codeBasico = <<<'BLADE'
<x-jetax-table
    :columns="[
        ['key' => 'name', 'label' => 'Nome'],
        ['key' => 'email', 'label' => 'E-mail'],
        ['key' => 'status', 'label' => 'Status'],
    ]"
    :rows="[
        ['name' => 'Ana Lima', 'email' => 'ana@exemplo.com', 'status' => 'Ativo'],
        ['name' => 'Joao Silva', 'email' => 'joao@exemplo.com', 'status' => 'Inativo'],
        ['name' => 'Maria Santos', 'email' => 'maria@exemplo.com', 'status' => 'Ativo'],
    ]"
/>
BLADE;

$codeOrdenacao = <<<'BLADE'
<x-jetax-table
    :columns="[
        ['key' => 'name', 'label' => 'Nome', 'sortable' => true],
        ['key' => 'email', 'label' => 'E-mail', 'sortable' => true],
        ['key' => 'city', 'label' => 'Cidade'],
    ]"
    :rows="$users->map(fn ($u) => [
        'name'  => $u->name,
        'email' => $u->email,
        'city'  => $u->city,
    ])->toArray()"
/>
BLADE;

$codeComponentes = <<<'BLADE'
<x-jetax-table
    :columns="[
        ['key' => 'name', 'label' => 'Nome / Razao Social'],
        ['key' => 'doc', 'label' => 'CNPJ / CPF'],
        ['key' => 'city', 'label' => 'Cidade / UF'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'actions', 'label' => 'Acoes'],
    ]"
>
    <x-slot:body>
        &#64;foreach($clients as $client)
            <tr class="group h-11 even:bg-slate-50 hover:bg-surface-container-low transition-colors">
                <td class="px-6 py-2.5">
                    <div class="flex flex-col">
                        <span class="text-[13px] font-semibold text-on-surface">{{ $client->name }}</span>
                        <span class="text-[12px] text-slate-400">{{ $client->trade_name }}</span>
                    </div>
                </td>
                <td class="px-6 py-2.5">
                    <span class="text-[13px] font-mono text-slate-500">{{ $client->document }}</span>
                </td>
                <td class="px-6 py-2.5 text-[13px] text-slate-600">
                    {{ $client->city }} / {{ $client->state }}
                </td>
                <td class="px-6 py-2.5">
                    <x-jetax-badge :variant="$client->is_active ? 'success' : 'danger'" style="status">
                        {{ $client->is_active ? 'Ativo' : 'Inativo' }}
                    </x-jetax-badge>
                </td>
                <td class="px-6 py-2.5 text-right">
                    <div class="flex justify-end gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                        <x-jetax-button size="sm" style="soft" icon="visibility" />
                        <x-jetax-button size="sm" style="soft" icon="edit" />
                        <x-jetax-button size="sm" style="soft" color="danger" icon="delete" />
                    </div>
                </td>
            </tr>
        &#64;endforeach
    </x-slot:body>
</x-jetax-table>
BLADE;

$codeSelectable = <<<'BLADE'
<x-jetax-table
    :columns="[
        ['key' => 'name', 'label' => 'Nome'],
        ['key' => 'email', 'label' => 'E-mail'],
    ]"
    :rows="[
        ['name' => 'Ana Lima', 'email' => 'ana@exemplo.com'],
        ['name' => 'Joao Silva', 'email' => 'joao@exemplo.com'],
    ]"
    :selectable="true"
/>
BLADE;

$codeVazio = <<<'BLADE'
<x-jetax-table
    :columns="[
        ['key' => 'name', 'label' => 'Nome'],
        ['key' => 'email', 'label' => 'E-mail'],
    ]"
    :rows="[]"
/>
BLADE;

// Dados para os exemplos renderizados
$columns = [
    ['key' => 'name', 'label' => 'Nome'],
    ['key' => 'email', 'label' => 'E-mail'],
    ['key' => 'status', 'label' => 'Status'],
];

$rows = [
    ['name' => 'Ana Lima', 'email' => 'ana@exemplo.com', 'status' => 'Ativo'],
    ['name' => 'João Silva', 'email' => 'joao@exemplo.com', 'status' => 'Inativo'],
    ['name' => 'Maria Santos', 'email' => 'maria@exemplo.com', 'status' => 'Ativo'],
];

$columnsSortable = [
    ['key' => 'name', 'label' => 'Nome', 'sortable' => true],
    ['key' => 'email', 'label' => 'E-mail', 'sortable' => true],
    ['key' => 'city', 'label' => 'Cidade'],
];

$rowsSortable = [
    ['name' => 'Carlos Mendes', 'email' => 'carlos@exemplo.com', 'city' => 'Belo Horizonte / MG'],
    ['name' => 'Ana Lima', 'email' => 'ana@exemplo.com', 'city' => 'São Paulo / SP'],
    ['name' => 'Zélia Duarte', 'email' => 'zelia@exemplo.com', 'city' => 'Curitiba / PR'],
    ['name' => 'João Silva', 'email' => 'joao@exemplo.com', 'city' => 'Porto Alegre / RS'],
];

$columnsBody = [
    ['key' => 'name', 'label' => 'Nome / Razao Social'],
    ['key' => 'doc', 'label' => 'CNPJ / CPF'],
    ['key' => 'city', 'label' => 'Cidade / UF'],
    ['key' => 'status', 'label' => 'Status'],
    ['key' => 'actions', 'label' => 'Acoes'],
];

$clientsData = [
    ['name' => 'TechNova Soluções Digitais Ltda', 'trade' => 'TECHNOVA DIGITAL', 'doc' => '45.283.194/0001-92', 'city' => 'São Paulo', 'state' => 'SP', 'active' => true],
    ['name' => 'Ricardo Augusto de Oliveira', 'trade' => 'CLIENTE AVULSO', 'doc' => '123.456.789-00', 'city' => 'Curitiba', 'state' => 'PR', 'active' => true],
    ['name' => 'Luminex Group International', 'trade' => 'LUMINEX BRASIL', 'doc' => '82.103.546/0001-41', 'city' => 'Belo Horizonte', 'state' => 'MG', 'active' => false],
    ['name' => 'Global Logistics Corp', 'trade' => 'GLC TRANSPORTES', 'doc' => '19.222.845/0001-08', 'city' => 'Itajaí', 'state' => 'SC', 'active' => true],
];
@endphp

<div class="space-y-6">

    {{-- Basico --}}
    <x-jetax-docs-preview-section title="Basico" :code="$codeBasico">
        <x-jetax-table :columns="$columns" :rows="$rows" />
    </x-jetax-docs-preview-section>

    {{-- Com Ordenacao --}}
    <x-jetax-docs-preview-section title="Com Ordenacao" :code="$codeOrdenacao">
        <x-jetax-table :columns="$columnsSortable" :rows="$rowsSortable" />
    </x-jetax-docs-preview-section>

    {{-- Com Componentes (body slot) --}}
    <x-jetax-docs-preview-section title="Com Componentes (body slot)" :code="$codeComponentes">
        <x-jetax-table :columns="$columnsBody">
            <x-slot:body>
                @foreach($clientsData as $client)
                    <tr class="group h-11 even:bg-slate-50 hover:bg-surface-container-low transition-colors">
                        <td class="px-6 py-2.5">
                            <div class="flex flex-col">
                                <span class="text-[13px] font-semibold text-on-surface leading-none mb-1">{{ $client['name'] }}</span>
                                <span class="text-[12px] text-slate-400 leading-none">{{ $client['trade'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-2.5">
                            <span class="text-[13px] font-mono text-slate-500 tracking-tighter">{{ $client['doc'] }}</span>
                        </td>
                        <td class="px-6 py-2.5 text-[13px] text-slate-600">
                            {{ $client['city'] }} / {{ $client['state'] }}
                        </td>
                        <td class="px-6 py-2.5">
                            <x-jetax-badge :variant="$client['active'] ? 'success' : 'danger'" style="status">
                                {{ $client['active'] ? 'Ativo' : 'Inativo' }}
                            </x-jetax-badge>
                        </td>
                        <td class="px-6 py-2.5 text-right">
                            <div class="flex justify-end gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                <x-jetax-button size="sm" style="soft" icon="visibility" />
                                <x-jetax-button size="sm" style="soft" icon="edit" />
                                <x-jetax-button size="sm" style="soft" color="danger" icon="delete" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-jetax-table>
    </x-jetax-docs-preview-section>

    {{-- Selectable --}}
    <x-jetax-docs-preview-section title="Selectable" :code="$codeSelectable">
        <x-jetax-table
            :columns="[['key' => 'name', 'label' => 'Nome'], ['key' => 'email', 'label' => 'E-mail']]"
            :rows="[['name' => 'Ana Lima', 'email' => 'ana@exemplo.com'], ['name' => 'João Silva', 'email' => 'joao@exemplo.com']]"
            :selectable="true"
        />
    </x-jetax-docs-preview-section>

    {{-- Estado Vazio --}}
    <x-jetax-docs-preview-section title="Estado Vazio" :code="$codeVazio">
        <x-jetax-table
            :columns="[['key' => 'name', 'label' => 'Nome'], ['key' => 'email', 'label' => 'E-mail']]"
            :rows="[]"
        />
    </x-jetax-docs-preview-section>

</div>
