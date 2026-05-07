<?php

namespace Tests\Fixtures\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Tests\Fixtures\Models\Post;

class CustomEmptyTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Post::query();
    }

    public function emptyTitle(): string
    {
        return 'Sem clientes cadastrados';
    }

    public function emptyDescription(): string
    {
        return 'Tente ajustar os filtros ou cadastre um novo cliente.';
    }
}
