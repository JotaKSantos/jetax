<?php

use Illuminate\Pagination\LengthAwarePaginator;

it('test_renders_page_numbers', function () {
    $paginator = new LengthAwarePaginator(
        items: collect(range(1, 10)),
        total: 50,
        perPage: 10,
        currentPage: 1,
    );

    $view = $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => $paginator]
    );

    $view->assertSee('1', false);
    $view->assertSee('2', false);
});

it('test_previous_disabled_on_first_page', function () {
    $paginator = new LengthAwarePaginator(
        items: collect(range(1, 10)),
        total: 50,
        perPage: 10,
        currentPage: 1,
    );

    $view = $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => $paginator]
    );

    $view->assertSee('disabled', false);
    $view->assertSee('cursor-not-allowed', false);
});

it('test_next_disabled_on_last_page', function () {
    $paginator = new LengthAwarePaginator(
        items: collect(range(41, 50)),
        total: 50,
        perPage: 10,
        currentPage: 5,
    );

    $view = $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => $paginator]
    );

    $view->assertSee('disabled', false);
    $view->assertSee('cursor-not-allowed', false);
});

it('test_per_page_selector_rendered', function () {
    $paginator = new LengthAwarePaginator(
        items: collect(range(1, 10)),
        total: 50,
        perPage: 10,
        currentPage: 1,
    );

    $view = $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => $paginator]
    );

    $view->assertSee('<select', false);
    $view->assertSee('10', false);
    $view->assertSee('25', false);
    $view->assertSee('50', false);
    $view->assertSee('100', false);
});

it('test_result_indicator_shows_correct_range', function () {
    $paginator = new LengthAwarePaginator(
        items: collect(range(1, 10)),
        total: 50,
        perPage: 10,
        currentPage: 1,
    );
    $paginator->withPath('/');

    $view = $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => $paginator]
    );

    $view->assertSee('Mostrando', false);
    $view->assertSee('resultados', false);
    $view->assertSee('1', false);
    $view->assertSee('10', false);
    $view->assertSee('50', false);
});
