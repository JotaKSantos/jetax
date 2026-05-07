<?php

use Livewire\Livewire;
use Tests\Fixtures\DataTables\FilterablePostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();

    Post::create([
        'title' => 'alpha',
        'status' => 'draft',
        'category' => 'a',
        'created_at' => '2026-01-05 10:00:00',
    ]);

    Post::create([
        'title' => 'beta',
        'status' => 'published',
        'category' => 'b',
        'created_at' => '2026-02-15 10:00:00',
    ]);

    Post::create([
        'title' => 'gamma',
        'status' => 'archived',
        'category' => 'c',
        'created_at' => '2026-03-25 10:00:00',
    ]);
});

it('applies select filter to builder', function () {
    Livewire::test(FilterablePostsTable::class)
        ->set('filterValues.status', 'draft')
        ->assertSee('alpha')
        ->assertDontSee('beta')
        ->assertDontSee('gamma');
});

it('applies multiselect filter with whereIn', function () {
    Livewire::test(FilterablePostsTable::class)
        ->set('filterValues.category', ['a', 'b'])
        ->assertSee('alpha')
        ->assertSee('beta')
        ->assertDontSee('gamma');
});

it('applies date range filter', function () {
    Livewire::test(FilterablePostsTable::class)
        ->set('filterValues.created_at', [
            'from' => '2026-02-01',
            'to' => '2026-02-28',
        ])
        ->assertSee('beta')
        ->assertDontSee('alpha')
        ->assertDontSee('gamma');
});

it('combines multiple filters additively', function () {
    Livewire::test(FilterablePostsTable::class)
        ->set('filterValues.status', 'published')
        ->set('filterValues.category', ['a', 'b'])
        ->assertSee('beta')
        ->assertDontSee('alpha')
        ->assertDontSee('gamma');
});

it('persists filters in URL as f[key]=value', function () {
    Livewire::withQueryParams(['f' => ['status' => 'archived']])
        ->test(FilterablePostsTable::class)
        ->assertSet('filterValues.status', 'archived')
        ->assertSee('gamma')
        ->assertDontSee('alpha')
        ->assertDontSee('beta');
});

it('resets to page 1 when filter changes', function () {
    for ($i = 1; $i <= 20; $i++) {
        Post::create([
            'title' => 'extra-'.$i,
            'status' => 'draft',
            'category' => 'a',
        ]);
    }

    $component = Livewire::test(FilterablePostsTable::class)
        ->call('gotoPage', 2);

    expect($component->instance()->getPage())->toBe(2);

    $component->set('filterValues.status', 'draft');

    expect($component->instance()->getPage())->toBe(1);
});

it('ignores filter when value is empty', function () {
    Livewire::test(FilterablePostsTable::class)
        ->set('filterValues.status', '')
        ->assertSee('alpha')
        ->assertSee('beta')
        ->assertSee('gamma');
});
