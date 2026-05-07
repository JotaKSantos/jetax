<?php

namespace Tests\Fixtures\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Tests\Fixtures\Models\Post;

class PostsTable extends DataTableComponent
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
            TextColumn::make('body', 'Corpo')->searchable(),
            TextColumn::make('status', 'Status')->sortable(),
        ];
    }
}
