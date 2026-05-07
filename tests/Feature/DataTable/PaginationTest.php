<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Livewire;
use Tests\Fixtures\DataTables\PostsTable;
use Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->setUpPostsTable();

    for ($i = 1; $i <= 30; $i++) {
        Post::create([
            'title' => sprintf('post-%02d', $i),
            'status' => 'published',
        ]);
    }
});

it('respects per_page from config', function () {
    config()->set('jetax-data-table.per_page', 15);

    $component = Livewire::test(PostsTable::class);

    $rows = $component->instance()->rows;

    expect($rows)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($rows->perPage())->toBe(15);
    expect($rows->total())->toBe(30);
    expect($rows->items())->toHaveCount(15);
});

it('exposes a LengthAwarePaginator via the rows computed property', function () {
    $rows = Livewire::test(PostsTable::class)->instance()->rows;

    expect($rows)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($rows->total())->toBe(30);
});
