<?php

namespace Jetax\DesignSystem\Docs\Playground;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;
use Jetax\DesignSystem\DataTable\Columns\ActionsColumn;
use Jetax\DesignSystem\DataTable\Columns\BadgeColumn;
use Jetax\DesignSystem\DataTable\Columns\DateColumn;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Jetax\DesignSystem\DataTable\Filters\DateFilter;
use Jetax\DesignSystem\DataTable\Filters\MultiSelectFilter;
use Jetax\DesignSystem\DataTable\Filters\SelectFilter;

class ClientesTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Cliente::query();
    }

    public function columns(): array
    {
        return [
            TextColumn::make('id', 'ID')->sortable(),
            TextColumn::make('nome', 'Nome')->sortable()->searchable(),
            TextColumn::make('razao_social', 'Razão social')->searchable(),
            TextColumn::make('documento', 'Documento'),
            TextColumn::make('cidade', 'Cidade')->sortable(),
            BadgeColumn::make('status', 'Status')
                ->sortable()
                ->colors([
                    'ativo'     => 'success',
                    'inativo'   => 'neutral',
                    'pendente'  => 'warning',
                    'bloqueado' => 'danger',
                ])
                ->formatUsing(fn ($value) => ucfirst((string) $value)),
            BadgeColumn::make('categoria', 'Categoria')
                ->colors([
                    'bronze'   => 'neutral',
                    'prata'    => 'info',
                    'ouro'     => 'warning',
                    'diamante' => 'success',
                ])
                ->formatUsing(fn ($value) => ucfirst((string) $value)),
            DateColumn::make('created_at', 'Criado em')->sortable(),
            ActionsColumn::make()
                ->actions([
                    ['key' => 'view', 'label' => 'Visualizar', 'icon' => 'visibility', 'href' => '#'],
                    ['key' => 'edit', 'label' => 'Editar', 'icon' => 'edit', 'href' => '#'],
                    ['key' => 'delete', 'label' => 'Excluir', 'icon' => 'delete', 'href' => '#'],
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('status', 'Status')->options([
                'ativo'     => 'Ativo',
                'inativo'   => 'Inativo',
                'pendente'  => 'Pendente',
                'bloqueado' => 'Bloqueado',
            ]),
            MultiSelectFilter::make('categoria', 'Categoria')->options([
                'bronze'   => 'Bronze',
                'prata'    => 'Prata',
                'ouro'     => 'Ouro',
                'diamante' => 'Diamante',
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
                ->handler(function (Collection $models) {
                    $models->each(fn (Cliente $cliente) => $cliente->update(['status' => 'ativo']));
                }),

            BulkAction::make('block', 'Bloquear')
                ->icon('block')
                ->variant('danger')
                ->confirm('Tem certeza que deseja bloquear os clientes selecionados?')
                ->handler(function (Collection $models) {
                    $models->each(fn (Cliente $cliente) => $cliente->update(['status' => 'bloqueado']));
                }),
        ];
    }

    public function emptyTitle(): string
    {
        return 'Nenhum cliente encontrado';
    }

    public function emptyDescription(): string
    {
        return 'Ajuste os filtros ou limpe a busca para ver mais resultados.';
    }

    public function emptyIcon(): string
    {
        return 'group_off';
    }
}
