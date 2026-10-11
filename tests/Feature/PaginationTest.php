<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Jetax\DesignSystem\View\Components\Pagination;

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

/**
 * Paginador de 5 páginas na página 2, com nome de página opcional.
 */
function middlePagePaginator(string $pageName = 'page'): LengthAwarePaginator
{
    return (new LengthAwarePaginator(collect(range(11, 20)), 50, 10, 2, ['pageName' => $pageName]))->withPath('/');
}

/**
 * Recorta a tag de abertura do elemento da página atual.
 */
function currentPageTag(string $html): string
{
    preg_match('/<button\b[^>]*aria-current="page"[^>]*>/', $html, $match);

    return $match[0] ?? '';
}

/**
 * Valor do atributo `class` de uma tag.
 */
function classAttribute(string $tag): string
{
    preg_match('/class="([^"]*)"/', $tag, $match);

    return $match[1] ?? '';
}

it('test_livewire_mode_pages_are_buttons_with_goto_page', function () {
    $html = (string) $this->blade(
        '<x-jetax-pagination :paginator="$paginator" livewire />',
        ['paginator' => middlePagePaginator()]
    );

    expect($html)->toContain('wire:click="gotoPage(')
        ->and($html)->toContain("wire:click=\"gotoPage(3, 'page')\"")
        ->and($html)->toContain("wire:click=\"previousPage('page')\"")
        ->and($html)->toContain("wire:click=\"nextPage('page')\"")
        ->and($html)->not->toContain('href=')
        ->and($html)->not->toContain('window.location.href');
    expect(preg_match('/<button\s+type="button"\s+wire:click="gotoPage\(1, \'page\'\)"/', $html))->toBe(1);
});

it('test_livewire_mode_uses_paginator_page_name', function () {
    $html = (string) $this->blade(
        '<x-jetax-pagination :paginator="$paginator" livewire />',
        ['paginator' => middlePagePaginator('ownersPage')]
    );

    expect($html)->toContain("wire:click=\"gotoPage(4, 'ownersPage')\"")
        ->and($html)->toContain('wire:key="paginator-ownersPage-page-4"');
});

it('test_href_mode_keeps_links', function () {
    $html = (string) $this->blade(
        '<x-jetax-pagination :paginator="$paginator" />',
        ['paginator' => middlePagePaginator()]
    );

    expect($html)->toContain('href=')
        ->and($html)->not->toContain('wire:click="gotoPage(');
});

it('test_current_page_classes_equal_in_both_modes', function () {
    $paginator = middlePagePaginator();

    $href = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" />', ['paginator' => $paginator]);
    $livewire = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire />', ['paginator' => $paginator]);

    $hrefClasses = classAttribute(currentPageTag($href));

    expect($hrefClasses)->not->toBe('')
        ->and(classAttribute(currentPageTag($livewire)))->toBe($hrefClasses)
        ->and($hrefClasses)->toContain('text-on-primary')
        ->and($hrefClasses)->not->toContain('text-white');
});

it('test_page_classes_equal_in_both_modes', function () {
    $paginator = middlePagePaginator();

    $href = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" />', ['paginator' => $paginator]);
    $livewire = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire />', ['paginator' => $paginator]);

    preg_match('/<a\b[^>]*aria-label="Ir para a página 3"[^>]*>/', $href, $link);
    preg_match('/<button\b[^>]*aria-label="Ir para a página 3"[^>]*>/', $livewire, $button);

    expect(classAttribute($button[0]))->toBe(classAttribute($link[0]));
});

it('test_livewire_mode_scrolls_to_body_by_default_and_can_disable', function () {
    $paginator = middlePagePaginator();

    $default = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire />', ['paginator' => $paginator]);
    $disabled = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire :scroll-to="false" />', ['paginator' => $paginator]);

    expect($default)->toContain('scrollIntoView()')
        ->and($disabled)->not->toContain('scrollIntoView()');
});

it('test_livewire_mode_per_page_selector_requires_model', function () {
    $paginator = middlePagePaginator();

    $without = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire />', ['paginator' => $paginator]);
    $with = (string) $this->blade('<x-jetax-pagination :paginator="$paginator" livewire per-page-model="perPage" />', ['paginator' => $paginator]);

    expect($without)->not->toContain('<select')
        ->and($with)->toContain('<select')
        ->and($with)->toContain('wire:model.live="perPage"')
        ->and($with)->not->toContain('onchange=');
});

it('test_jetax_044_page_button_is_38px_with_border_and_9px_radius', function () {
    $html = Blade::render('<x-jetax-pagination :paginator="$paginator" />', ['paginator' => middlePagePaginator()]);
    $page = htmlTag($html, 'a', 'text-on-surface-variant');

    expect($page)->toContain('min-w-[38px] h-[38px]')
        ->and($page)->toContain('rounded-[9px] border border-outline-variant')
        ->and($page)->not->toContain('w-8 h-8')
        ->and($page)->not->toContain('rounded-lg');
});

it('test_jetax_044_current_page_has_same_size_without_border', function () {
    $current = currentPageTag(Blade::render('<x-jetax-pagination :paginator="$paginator" />', ['paginator' => middlePagePaginator()]));

    expect($current)->toContain('min-w-[38px] h-[38px]')
        ->and($current)->toContain('rounded-[9px] bg-primary')
        ->and($current)->not->toContain('border');
});

it('test_jetax_044_arrows_follow_page_shape', function () {
    $pagination = new Pagination(paginator: middlePagePaginator());

    expect($pagination->arrowClasses())->toContain('min-w-[38px] h-[38px] flex items-center justify-center rounded-[9px] border border-outline-variant')
        ->and($pagination->disabledArrowClasses())->toContain('min-w-[38px] h-[38px] flex items-center justify-center rounded-[9px] border border-outline-variant');
});
