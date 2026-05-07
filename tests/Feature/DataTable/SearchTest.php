<?php

use Livewire\Livewire;
use Tests\Fixtures\DataTables\PostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();

    Post::create(['title' => 'banana', 'body' => 'amarela', 'status' => 'draft']);
    Post::create(['title' => 'apple', 'body' => 'vermelha', 'status' => 'published']);
    Post::create(['title' => 'cherry', 'body' => 'escura', 'status' => 'draft']);
});

it('filters rows matching search across searchable columns', function () {
    Livewire::test(PostsTable::class)
        ->set('search', 'apple')
        ->assertSee('apple')
        ->assertDontSee('banana')
        ->assertDontSee('cherry');
});

it('returns empty result when no match', function () {
    Livewire::test(PostsTable::class)
        ->set('search', 'zzz-no-match')
        ->assertSee('Nenhum registro encontrado')
        ->assertDontSee('apple')
        ->assertDontSee('banana');
});

it('resets to page 1 when search changes', function () {
    for ($i = 1; $i <= 30; $i++) {
        Post::create(['title' => 'extra-'.$i, 'status' => 'draft']);
    }

    $component = Livewire::test(PostsTable::class)
        ->call('gotoPage', 2);

    expect($component->instance()->getPage())->toBe(2);

    $component->set('search', 'apple');

    expect($component->instance()->getPage())->toBe(1);
});

it('persists search term in URL as q', function () {
    Livewire::withQueryParams(['q' => 'banana'])
        ->test(PostsTable::class)
        ->assertSet('search', 'banana')
        ->assertSee('banana')
        ->assertDontSee('apple');
});
