@php
$codeLivewireTag = <<<'BLADE'
<livewire:jetax-docs-clientes-table />
BLADE;

$codeClasse = <<<'PHP'
<?php

namespace App\Livewire;

use App\Models\Cliente;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Columns\BadgeColumn;
use Jetax\DesignSystem\DataTable\Columns\DateColumn;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\Columns\ActionsColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Jetax\DesignSystem\DataTable\Filters\DateFilter;
use Jetax\DesignSystem\DataTable\Filters\MultiSelectFilter;
use Jetax\DesignSystem\DataTable\Filters\SelectFilter;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class ClientesTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Cliente::query();
    }

    public function columns(): array
    {
        return [
            TextColumn::make('nome', 'Nome')->sortable()->searchable(),
            BadgeColumn::make('status', 'Status')->colors([
                'ativo'     => 'success',
                'inativo'   => 'neutral',
                'pendente'  => 'warning',
                'bloqueado' => 'danger',
            ]),
            DateColumn::make('created_at', 'Criado em')->sortable(),
            ActionsColumn::make()->actions([
                ['key' => 'edit',   'label' => 'Editar',   'icon' => 'edit',   'href' => '#'],
                ['key' => 'delete', 'label' => 'Excluir',  'icon' => 'delete', 'href' => '#'],
            ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('status', 'Status')->options([
                'ativo' => 'Ativo', 'inativo' => 'Inativo',
                'pendente' => 'Pendente', 'bloqueado' => 'Bloqueado',
            ]),
            MultiSelectFilter::make('categoria', 'Categoria')->options([
                'bronze' => 'Bronze', 'prata' => 'Prata',
                'ouro' => 'Ouro', 'diamante' => 'Diamante',
            ]),
            DateFilter::make('created_at', 'Criação'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::make('activate', 'Ativar')
                ->icon('check_circle')
                ->variant('primary')
                ->handler(fn (Collection $models) => $models->each->update(['status' => 'ativo'])),
        ];
    }
}
PHP;

$codeRota = <<<'PHP'
// routes/web.php
use App\Livewire\ClientesTable;

Route::get('/clientes', ClientesTable::class)->name('clientes.index');
PHP;

$codeColumns = <<<'PHP'
TextColumn::make('nome', 'Nome')->sortable()->searchable();

BadgeColumn::make('status', 'Status')
    ->colors([
        'ativo'   => 'success',
        'inativo' => 'neutral',
    ])
    ->formatUsing(fn ($value) => ucfirst($value));

DateColumn::make('created_at', 'Criado em')
    ->sortable()
    ->format('d/m/Y H:i');

ActionsColumn::make()
    ->actions([
        ['key' => 'edit',   'label' => 'Editar',  'icon' => 'edit',   'href' => fn ($row) => "/clientes/{$row->id}/editar"],
        ['key' => 'delete', 'label' => 'Excluir', 'icon' => 'delete', 'href' => '#'],
    ])
    ->collapseAfter(3);
PHP;

$codeFilters = <<<'PHP'
SelectFilter::make('status', 'Status')->options([
    'ativo'   => 'Ativo',
    'inativo' => 'Inativo',
]);

MultiSelectFilter::make('categoria', 'Categoria')->options([
    'bronze' => 'Bronze', 'prata' => 'Prata', 'ouro' => 'Ouro',
]);

DateFilter::make('created_at', 'Criação');
PHP;

$codeBulkActions = <<<'PHP'
BulkAction::make('activate', 'Ativar')
    ->icon('check_circle')
    ->variant('primary')
    ->handler(fn (Collection $models) => $models->each->update(['status' => 'ativo']));

BulkAction::make('delete', 'Excluir')
    ->icon('delete')
    ->variant('danger')
    ->confirm('Tem certeza?')
    ->handler(fn (Collection $models) => $models->each->delete());
PHP;

$codeUrl = <<<'TXT'
?q=joao&sortBy=created_at&sortDirection=desc&f[status]=ativo&page=2
TXT;

$temCount = \Illuminate\Support\Facades\Schema::hasTable('jetax_playground_clientes')
    ? \Jetax\DesignSystem\Docs\Playground\Cliente::count()
    : 0;
@endphp

<div class="space-y-6">

    @if($temCount === 0)
        <x-jetax-alert
            variant="warning"
            style="rich"
            icon="info"
            title="Playground precisa de dados"
        >
            A tabela <code>jetax_playground_clientes</code> está vazia (ou ainda não existe).
            Rode no terminal do app consumidor:
            <pre class="mt-2 bg-amber-950/10 dark:bg-amber-100/10 px-3 py-2 rounded text-xs font-mono">php artisan migrate
php artisan jetax:seed-playground</pre>
        </x-jetax-alert>
    @else
        <x-jetax-alert
            variant="info"
            style="soft"
            icon="database"
            :message="'Playground com '.number_format($temCount, 0, ',', '.').' clientes fake. Tente ordenar, filtrar, buscar, paginar — e veja a URL refletir o estado.'"
        />
    @endif

    {{-- Playground vivo --}}
    <x-jetax-docs-preview-section title="Playground completo" :code="$codeLivewireTag">
        <div class="w-full">
            <livewire:jetax-docs-clientes-table />
        </div>
    </x-jetax-docs-preview-section>

    {{-- Como criar a classe --}}
    <x-jetax-docs-preview-section title="1. Crie a classe Livewire" :code="$codeClasse">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300 space-y-2">
            <p>Estenda <code>Jetax\DesignSystem\DataTable\DataTableComponent</code> e implemente <code>builder()</code> retornando uma query Eloquent.</p>
            <p>Os outros métodos (<code>columns</code>, <code>filters</code>, <code>bulkActions</code>) são opcionais.</p>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Rota --}}
    <x-jetax-docs-preview-section title="2. Aponte uma rota Livewire" :code="$codeRota">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300">
            Componentes <code>DataTableComponent</code> são Livewire full-page — basta apontar uma rota direta para a classe.
        </div>
    </x-jetax-docs-preview-section>

    {{-- Tipos de colunas --}}
    <x-jetax-docs-preview-section title="3. Colunas disponíveis" :code="$codeColumns">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300 space-y-1">
            <p><strong class="text-on-surface">TextColumn</strong> — render padrão.</p>
            <p><strong class="text-on-surface">BadgeColumn</strong> — pill colorido por valor com <code>colors()</code> e <code>formatUsing()</code>.</p>
            <p><strong class="text-on-surface">DateColumn</strong> — data formatada (default <code>d/m/Y</code>, locale pt-BR).</p>
            <p><strong class="text-on-surface">ActionsColumn</strong> — botões revelados no hover; <code>collapseAfter(N)</code> agrupa o restante num dropdown.</p>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Filtros --}}
    <x-jetax-docs-preview-section title="4. Filtros tipados" :code="$codeFilters">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300 space-y-1">
            <p><strong class="text-on-surface">SelectFilter</strong> — <code>where(key, value)</code>.</p>
            <p><strong class="text-on-surface">MultiSelectFilter</strong> — <code>whereIn(key, values)</code>.</p>
            <p><strong class="text-on-surface">DateFilter</strong> — range from/to (<code>whereBetween</code>).</p>
        </div>
    </x-jetax-docs-preview-section>

    {{-- Bulk actions --}}
    <x-jetax-docs-preview-section title="5. Ações em lote" :code="$codeBulkActions">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300">
            Quando o array de <code>bulkActions()</code> não está vazio, uma coluna de checkbox é adicionada e a barra flutuante aparece ao primeiro item selecionado.
        </div>
    </x-jetax-docs-preview-section>

    {{-- Estado na URL --}}
    <x-jetax-docs-preview-section title="6. Estado persistido na URL" :code="$codeUrl">
        <div class="w-full text-sm text-slate-600 dark:text-slate-300 space-y-2">
            <p>Sort, busca, filtros e página são serializados como query string via <code>#[Url]</code>. Refresh mantém estado e o link fica compartilhável.</p>
            <ul class="list-disc list-inside space-y-1 ml-2">
                <li><code>q</code> — termo de busca global</li>
                <li><code>sortBy</code>, <code>sortDirection</code> — ordenação</li>
                <li><code>f[chave]</code> — valores dos filtros</li>
                <li><code>page</code> — paginação</li>
            </ul>
        </div>
    </x-jetax-docs-preview-section>

</div>
