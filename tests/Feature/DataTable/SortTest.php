<?php

use Livewire\Livewire;
use Tests\Fixtures\DataTables\PostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();

    Post::create(['title' => 'banana', 'status' => 'draft']);
    Post::create(['title' => 'apple', 'status' => 'published']);
    Post::create(['title' => 'cherry', 'status' => 'draft']);
});

it('sorts ascending by default when toggling a sortable column', function () {
    Livewire::test(PostsTable::class)
        ->call('toggleSort', 'title')
        ->assertSet('sortBy', 'title')
        ->assertSet('sortDirection', 'asc')
        ->assertSeeInOrder(['apple', 'banana', 'cherry']);
});

it('toggles to descending on second click', function () {
    Livewire::test(PostsTable::class)
        ->call('toggleSort', 'title')
        ->call('toggleSort', 'title')
        ->assertSet('sortBy', 'title')
        ->assertSet('sortDirection', 'desc')
        ->assertSeeInOrder(['cherry', 'banana', 'apple']);
});

it('persists sort state via #[Url] attributes', function () {
    Livewire::withQueryParams(['sortBy' => 'title', 'sortDirection' => 'desc'])
        ->test(PostsTable::class)
        ->assertSet('sortBy', 'title')
        ->assertSet('sortDirection', 'desc')
        ->assertSeeInOrder(['cherry', 'banana', 'apple']);
});

it('does not sort on a non-sortable column', function () {
    Livewire::test(PostsTable::class)
        ->call('toggleSort', 'body')
        ->assertSet('sortBy', null)
        ->assertSet('sortDirection', 'asc');
});
