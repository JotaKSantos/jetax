<?php

namespace Tests\Fixtures\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Jetax\DesignSystem\DataTable\BulkActions\BulkAction;
use Jetax\DesignSystem\DataTable\Columns\TextColumn;
use Jetax\DesignSystem\DataTable\DataTableComponent;
use Tests\Fixtures\Models\Post;

class BulkActionablePostsTable extends DataTableComponent
{
    /**
     * Captura o payload recebido pelo handler da última bulk action executada,
     * permitindo asserts em testes.
     *
     * @var array<string, array<int, int|string>>
     */
    public array $lastBulkRun = [];

    public function builder(): Builder
    {
        return Post::query()->orderBy('id');
    }

    public function columns(): array
    {
        return [
            TextColumn::make('id', 'ID')->sortable(),
            TextColumn::make('title', 'Título')->sortable()->searchable(),
            TextColumn::make('status', 'Status')->sortable(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::make('publish', 'Publicar')
                ->icon('check_circle')
                ->handler(function (Collection $models) {
                    $this->lastBulkRun['publish'] = $models->pluck('id')->all();

                    $models->each(fn ($post) => $post->update(['status' => 'published']));
                }),

            BulkAction::make('delete', 'Excluir')
                ->icon('delete')
                ->variant('danger')
                ->confirm('Confirmar exclusão?')
                ->handler(function (Collection $models) {
                    $this->lastBulkRun['delete'] = $models->pluck('id')->all();

                    $models->each->delete();
                }),
        ];
    }
}
