<?php

namespace Tests\Fixtures\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Columns\ActionsColumn;
use Jetax\DesignSystem\DataTable\Columns\BadgeColumn;
use Jetax\DesignSystem\DataTable\Columns\DateColumn;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Tests\Fixtures\Models\Post;

class ShowcaseTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Post::query();
    }

    public function columns(): array
    {
        return [
            TextColumn::make('id', 'ID')->sortable(),
            TextColumn::make('title', 'Título')->sortable()->searchable(),
            BadgeColumn::make('status', 'Status')
                ->colors([
                    'draft' => 'neutral',
                    'published' => 'success',
                    'archived' => 'danger',
                ]),
            DateColumn::make('created_at', 'Criado em'),
            ActionsColumn::make('actions', '')
                ->actions([
                    [
                        'key' => 'edit',
                        'label' => 'Editar',
                        'icon' => 'edit',
                        'href' => '#',
                    ],
                    [
                        'key' => 'delete',
                        'label' => 'Excluir',
                        'icon' => 'delete',
                        'href' => '#',
                    ],
                ]),
        ];
    }
}
