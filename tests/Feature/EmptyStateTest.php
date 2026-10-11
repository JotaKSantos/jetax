<?php

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Jetax\DesignSystem\View\Components\EmptyState;

it('test_title_and_description_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Nenhum cliente encontrado" description="Comece adicionando um novo cliente." />'
    );

    $view->assertSee('Nenhum cliente encontrado');
    $view->assertSee('Comece adicionando um novo cliente.');
});

it('test_icon_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Vazio" icon="user-magnifying-glass" />'
    );

    $view->assertSee('fa-solid fa-user-magnifying-glass', false);
});

it('test_default_icon_is_font_awesome_inbox', function () {
    $html = (string) $this->blade('<x-jetax-empty-state title="Vazio" />');

    expect(htmlTag($html, 'i', 'fa-inbox'))->toContain('fa-solid fa-inbox')
        ->toContain('aria-hidden="true"')
        ->and($html)->not->toContain('material');
});

it('test_icon_accepts_style_prefix', function () {
    $html = (string) $this->blade('<x-jetax-empty-state title="Vazio" icon="regular:folder-open" />');

    expect($html)->toContain('fa-regular fa-folder-open')
        ->not->toContain('regular:');
});

it('test_cta_slot_rendered', function () {
    $view = $this->blade(
        '<x-jetax-empty-state title="Vazio"><button>Criar Novo</button></x-jetax-empty-state>'
    );

    $view->assertSee('Criar Novo');
});

it('test_jetax_039_padding_follows_mockup', function () {
    $root = htmlTag(Blade::render('<x-jetax-empty-state title="Vazio" />'), 'div');

    expect($root)->toContain('px-5 py-10')
        ->and($root)->not->toContain('p-12');
});

it('test_jetax_039_has_no_frame_by_default', function () {
    $root = htmlTag(Blade::render('<x-jetax-empty-state title="Vazio" />'), 'div');

    expect($root)->not->toContain('border-dashed')
        ->and($root)->not->toContain('rounded-[10px]');
});

it('test_jetax_039_bordered_draws_dashed_frame', function () {
    $root = htmlTag(Blade::render('<x-jetax-empty-state title="Vazio" bordered />'), 'div');

    expect($root)->toContain('border border-dashed border-primary/18 rounded-[10px]')
        ->and($root)->toContain('px-5 py-10')
        ->and($root)->not->toContain('bordered');
});

it('test_jetax_039_sizes_constant', function () {
    expect(EmptyState::SIZES)->toBe(['md', 'sm']);
});

it('test_jetax_039_md_description_keeps_paragraph_style', function () {
    $paragraph = htmlTag(Blade::render('<x-jetax-empty-state title="Vazio" description="Nada aqui." />'), 'p');

    expect($paragraph)->toContain('text-on-surface-variant text-sm mb-8 max-w-xs');
});

it('test_jetax_039_sm_description_is_single_bold_line', function () {
    $html = Blade::render('<x-jetax-empty-state size="sm" description="Nenhum recebimento hoje." />');
    $paragraph = htmlTag($html, 'p');

    expect($paragraph)->toContain('text-sm font-bold text-on-surface')
        ->and($paragraph)->not->toContain('mb-8')
        ->and($paragraph)->not->toContain('max-w-xs')
        ->and($html)->toContain('Nenhum recebimento hoje.')
        ->and(htmlTag($html, 'div'))->not->toContain('size=');
});

it('test_jetax_039_invalid_size_throws_in_testing', function () {
    expect(bladeRenderFailure('<x-jetax-empty-state size="xl" title="Vazio" />'))->toBeInstanceOf(InvalidArgumentException::class);
});

it('test_jetax_039_invalid_size_logs_and_falls_back_to_md_in_production', function () {
    config(['app.env' => 'production']);
    Log::spy();

    $emptyState = new EmptyState(size: 'xl');

    expect($emptyState->size)->toBe('md')
        ->and($emptyState->descriptionClasses())->toContain('max-w-xs');

    Log::shouldHaveReceived('warning')->once();
});
