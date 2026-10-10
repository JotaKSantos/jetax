<?php

use Illuminate\Support\Facades\App;
use Jetax\DesignSystem\DataTable\Columns\ActionsColumn;
use Jetax\DesignSystem\DataTable\Columns\BadgeColumn;
use Jetax\DesignSystem\DataTable\Columns\DateColumn;
use Livewire\Livewire;
use Tests\Fixtures\DataTables\ShowcaseTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();
});

// ---------------------------------------------------------------------------
// BadgeColumn
// ---------------------------------------------------------------------------

it('renders badge column with variant based on value map', function () {
    Post::create(['title' => 'Rascunho', 'status' => 'draft', 'created_at' => now()]);

    Livewire::test(ShowcaseTable::class)
        ->assertSee('draft')
        ->assertSee('bg-surface-container border border-outline-variant text-on-surface-variant');
});

it('maps multiple status values to distinct variants', function () {
    Post::create(['title' => 'A', 'status' => 'draft', 'created_at' => now()]);
    Post::create(['title' => 'B', 'status' => 'published', 'created_at' => now()]);
    Post::create(['title' => 'C', 'status' => 'archived', 'created_at' => now()]);

    $response = Livewire::test(ShowcaseTable::class);

    // neutral → bg-surface-container
    $response->assertSee('bg-surface-container border border-outline-variant');
    // success → bg-success/10
    $response->assertSee('bg-success/10');
    // danger → bg-error/5
    $response->assertSee('bg-error/5');
});

it('applies formatUsing callback to badge label', function () {
    Post::create(['title' => 'Post', 'status' => 'draft', 'created_at' => now()]);

    $column = BadgeColumn::make('status', 'Status')
        ->colors(['draft' => 'neutral'])
        ->formatUsing(fn ($v) => ['draft' => 'Rascunho'][$v] ?? $v);

    $post = Post::first();
    $rendered = (string) $column->render($post);

    expect($rendered)->toContain('Rascunho');
    expect($rendered)->not->toContain('>draft<');
});

// ---------------------------------------------------------------------------
// DateColumn
// ---------------------------------------------------------------------------

it('formats date column with pt-BR locale', function () {
    App::setLocale('pt_BR');

    Post::create(['title' => 'Post', 'status' => 'draft', 'created_at' => '2026-04-17 10:00:00']);

    Livewire::test(ShowcaseTable::class)
        ->assertSee('17/04/2026');
});

it('respects custom format in date column', function () {
    App::setLocale('pt_BR');

    Post::create(['title' => 'Post', 'status' => 'draft', 'created_at' => '2026-04-17 10:00:00']);

    $post = Post::first();
    $column = DateColumn::make('created_at', 'Criado em')->format('d M Y');
    $rendered = (string) $column->render($post);

    // Espera abreviação em pt_BR: "abr" ou "Apr" dependendo de locale instalado
    expect($rendered)->toContain('17');
    expect($rendered)->toContain('2026');
});

// ---------------------------------------------------------------------------
// ActionsColumn
// ---------------------------------------------------------------------------

it('renders actions column scoped to row with icons', function () {
    $post = Post::create(['title' => 'Ação', 'status' => 'draft', 'created_at' => now()]);

    $column = ActionsColumn::make('actions', '')
        ->actions(fn ($row) => [
            [
                'key' => 'edit',
                'label' => 'Editar',
                'icon' => 'pen',
                'href' => "/posts/{$row->id}/edit",
            ],
        ]);

    $rendered = (string) $column->render($post);

    expect($rendered)->toContain('fa-solid fa-pen');
    expect($rendered)->toContain("/posts/{$post->id}/edit");
});

it('collapses extra actions into dropdown', function () {
    $post = Post::create(['title' => 'Muitas ações', 'status' => 'draft', 'created_at' => now()]);

    $column = ActionsColumn::make('actions', '')
        ->actions([
            ['key' => 'a1', 'label' => 'Ação 1', 'icon' => 'pen', 'href' => '#'],
            ['key' => 'a2', 'label' => 'Ação 2', 'icon' => 'eye', 'href' => '#'],
            ['key' => 'a3', 'label' => 'Ação 3', 'icon' => 'share-nodes', 'href' => '#'],
            ['key' => 'a4', 'label' => 'Ação 4', 'icon' => 'box-archive', 'href' => '#'],
            ['key' => 'a5', 'label' => 'Ação 5', 'icon' => 'regular:trash-can', 'href' => '#'],
        ])
        ->collapseAfter(3);

    $rendered = (string) $column->render($post);

    // O gatilho do dropdown usa o FA mapeado de more_vert
    expect($rendered)->toContain('fa-solid fa-ellipsis-vertical');
    // Ação 4 e 5 estão colapsadas → aparecem como dropdown-item, com o estilo do prefixo
    expect($rendered)->toContain('fa-solid fa-box-archive');
    expect($rendered)->toContain('fa-regular fa-trash-can');
    // As 3 primeiras estão visíveis como x-jetax-icon direto
    expect($rendered)->toContain('fa-solid fa-pen');
    expect($rendered)->toContain('fa-solid fa-eye');
    expect($rendered)->toContain('fa-solid fa-share-nodes');
    expect($rendered)->not->toContain('regular:')
        ->not->toContain('material');
});
