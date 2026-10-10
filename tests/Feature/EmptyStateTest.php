<?php

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
