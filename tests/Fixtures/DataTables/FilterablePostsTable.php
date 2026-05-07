<?php

namespace Tests\Fixtures\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Jetax\DesignSystem\DataTable\Filters\DateFilter;
use Jetax\DesignSystem\DataTable\Filters\MultiSelectFilter;
use Jetax\DesignSystem\DataTable\Filters\SelectFilter;
use Tests\Fixtures\Models\Post;

class FilterablePostsTable extends DataTableComponent
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
            TextColumn::make('status', 'Status')->sortable(),
            TextColumn::make('created_at', 'Criado em'),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('status', 'Status')->options([
                'draft' => 'Rascunho',
                'published' => 'Publicado',
                'archived' => 'Arquivado',
            ]),
            MultiSelectFilter::make('category', 'Categoria')->options([
                'a' => 'Categoria A',
                'b' => 'Categoria B',
                'c' => 'Categoria C',
            ]),
            DateFilter::make('created_at', 'Criação'),
        ];
    }
}
