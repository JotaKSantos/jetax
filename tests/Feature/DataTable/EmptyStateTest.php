<?php

use Livewire\Livewire;
use Tests\Fixtures\DataTables\CustomEmptyTable;
use Tests\Fixtures\DataTables\PostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();
});

it('renders empty state when rows is empty', function () {
    Livewire::test(PostsTable::class)
        ->assertSee('Nenhum registro encontrado');
});

it('does not render empty state when rows exist', function () {
    Post::create(['title' => 'Post existente', 'status' => 'draft']);

    Livewire::test(PostsTable::class)
        ->assertDontSee('Nenhum registro encontrado');
});

it('customizes empty state title and message', function () {
    Livewire::test(CustomEmptyTable::class)
        ->assertSee('Sem clientes cadastrados')
        ->assertSee('Tente ajustar os filtros ou cadastre um novo cliente.')
        ->assertDontSee('Nenhum registro encontrado');
});
