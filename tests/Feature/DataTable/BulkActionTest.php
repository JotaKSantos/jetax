<?php

use Livewire\Livewire;
use Tests\Fixtures\DataTables\BulkActionablePostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();

    config()->set('jetax-data-table.per_page', 3);

    Post::create(['id' => 1, 'title' => 'alpha', 'status' => 'draft']);
    Post::create(['id' => 2, 'title' => 'beta', 'status' => 'draft']);
    Post::create(['id' => 3, 'title' => 'gamma', 'status' => 'draft']);
    Post::create(['id' => 4, 'title' => 'delta', 'status' => 'draft']);
    Post::create(['id' => 5, 'title' => 'epsilon', 'status' => 'draft']);
});

it('toggles selectAll on current page', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectAll', true)
        ->assertSet('selectedIds', [1, 2, 3]);
});

it('collects selected ids when user marks rows manually', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1, 3])
        ->assertSet('selectedIds', [1, 3]);
});

it('executes bulk action with the selected models', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1, 2])
        ->call('runBulkAction', 'publish');

    expect(Post::find(1)->status)->toBe('published');
    expect(Post::find(2)->status)->toBe('published');
    expect(Post::find(3)->status)->toBe('draft');
});

it('clears selection after bulk action runs', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1, 2])
        ->call('runBulkAction', 'publish')
        ->assertSet('selectedIds', [])
        ->assertSet('selectAll', false);
});

it('does not include ids from other pages when toggling selectAll', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectAll', true)
        ->call('gotoPage', 2)
        ->set('selectAll', true)
        ->assertSet('selectedIds', [1, 2, 3, 4, 5]);
});

it('removes only current page ids when unchecking selectAll', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1, 2, 3, 4, 5])
        ->set('selectAll', false)
        ->assertSet('selectedIds', [4, 5]);
});

it('ignores runBulkAction when no rows are selected', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->call('runBulkAction', 'publish');

    expect(Post::where('status', 'published')->count())->toBe(0);
});

it('ignores runBulkAction for unknown keys', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1])
        ->call('runBulkAction', 'missing')
        ->assertSet('selectedIds', [1]);
});

it('clears selection manually via clearSelection', function () {
    Livewire::test(BulkActionablePostsTable::class)
        ->set('selectedIds', [1, 2])
        ->set('selectAll', true)
        ->call('clearSelection')
        ->assertSet('selectedIds', [])
        ->assertSet('selectAll', false);
});
